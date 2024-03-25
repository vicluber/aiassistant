<?php

declare(strict_types=1);

namespace Effective\Aiassistant\Controller;
use Effective\Aiassistant\Domain\Repository\MessageRepository;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use Effective\Aiassistant\Domain\Repository\AssistantRepository;

/**
 * This file is part of the "OpenAI Asistant" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Victor Willhuber <victorwillhuber@gmail.com>, effective
 */

/**
 * MessageController
 */
class MessageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var string
     */
    protected $apiKey = null;

    /**
     * @var AssistantRepository
     */
    private $assistantRepository = null;

    /**
     *
     * @var \OpenAI
     */
    protected $client = null;
    
    /**
     * messageRepository
     *
     * @var \Effective\Aiassistant\Domain\Repository\MessageRepository
     */
    protected $messageRepository = null;

    /**
     * Constructor injection for messageRepository
     *
     * @param MessageRepository $messageRepository
     * @param AssistantRepository $assistantRepository
     */
    public function __construct(AssistantRepository $assistantRepository, MessageRepository $messageRepository)
    {
        $this->assistantRepository = $assistantRepository;
        $this->messageRepository = $messageRepository;
        $this->apiKey = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('aiassistant', 'APIkey');
        $this->client = \OpenAI::client($this->apiKey);
    }

    /**
     * @param \Effective\Aiassistant\Domain\Repository\MessageRepository $messageRepository
     */
    public function injectMessageRepository(\Effective\Aiassistant\Domain\Repository\MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }


    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }


    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $messages = $this->messageRepository->findAll();
        $this->view->assign('messages', $messages);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \Effective\Aiassistant\Domain\Model\Message $message
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\Effective\Aiassistant\Domain\Model\Message $message): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('message', $message);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \Effective\Aiassistant\Domain\Model\Message $newMessage
     */
    public function createAction(\Effective\Aiassistant\Domain\Model\Message $newMessage)
    {
        if(isset($_POST['tx_aiassistant_chatform']['assistantId'])){
            $assistantId = $_POST['tx_aiassistant_chatform']['assistantId'];
            if(isset($assistant)){
                $assistant = $this->assistantRepository->findOneByAssistantId($assistantId);
                $newMessage->setAssistant($assistant);
            }
        }
        $assistant = $this->client->assistants()->retrieve($assistantId);
        $thread = $this->client->threads()->create([]);
        $message = $this->client->threads()->messages()->create($thread->id, ['role' => 'user', 'content' => $newMessage->getUserPrompt()]);
        $run = $response = $this->client->threads()->runs()->create(threadId: $thread->id, parameters: ['assistant_id' => $assistantId]);
        try {
            // FIX THIS; DONT CHECK ALL THE MESSAGES JUST GET THE LAST ONE
            $completedRun = $this->fetchRunResult($this->client, $run->id, $thread->id);
            $completedRun = $this->client->threads()->messages()->list($thread->id, ['limit' => 10]);
            $response = $this->responseFactory->createResponse();
            $jsonArray = [
                'answer' => $completedRun->toArray()['data'][0]['content'][0]['text']['value']
            ];
            $newMessage->setAssistantAnswer($jsonArray['answer']);
            $newMessage->setThread($thread->id);
            $this->messageRepository->add($newMessage);
            $jsonString = json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $response->getBody()->write($jsonString);
            throw new PropagateResponseException($response, 200);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * @param $client
     * @param $runId
     * @param $threadId
     * @param $timeoutSeconds
     */
    function fetchRunResult($client, $runId, $threadId, $timeoutSeconds = 1000)
    {
        $startTime = time();

        // Record the start time
        $pollInterval = 5;

        // How often to check the status, in seconds
        while (true) {

            // Retrieve the current run status using the provided thread ID and run ID
            $currentRun = $client->threads()->runs()->retrieve(threadId: $threadId, runId: $runId);
            $status = $currentRun['status'] ?? 'unknown';
            if ($status === 'completed') {

                // The run has completed, return the result or the run status as needed
                // You might need to adjust this part if the final response is structured differently
                return $currentRun;

                // Returning the whole run object for flexibility
            } elseif ($status === 'failed' || $status === 'cancelled') {

                // Handle failure or cancellation as needed
                throw new Exception("Run ended with status: {$status}");
            }

            // Check if the timeout has been reached
            if (time() - $startTime > $timeoutSeconds) {
                throw new Exception("Timeout reached waiting for run to complete.");
            }

            // Wait for a bit before checking again
            sleep($pollInterval);
        }
    }
}
