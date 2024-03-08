<?php

declare(strict_types=1);

namespace Effective\Aiassistant\Controller;

use Effective\Aiassistant\Domain\Repository\AssistantRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

/**
 * This file is part of the "OpenAI Asistant" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Victor Willhuber <victorwillhuber@gmail.com>, effective
 */

/**
 * AssistantController
 */
class AssistantController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var string
     */
    protected $apiKey = null;

    /**
     *
     * @var \OpenAI
     */
    protected $client = null;

    /**
     * @var AssistantRepository
     */
    private $assistantRepository = null;

    /**
     * Constructor injection for AssistantRepository
     *
     * @param AssistantRepository $assistantRepository
     */
    public function __construct(AssistantRepository $assistantRepository)
    {
        $this->assistantRepository = $assistantRepository;
        $this->apiKey = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('aiassistant', 'APIkey');
        $this->client = \OpenAI::client($this->apiKey);
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $assistants = $this->assistantRepository->findAll();
        $this->view->assign('assistants', $assistants);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \Effective\Aiassistant\Domain\Model\Assistant $assistant
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\Effective\Aiassistant\Domain\Model\Assistant $assistant): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('assistant', $assistant);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('models', $this->requestModels());
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \Effective\Aiassistant\Domain\Model\Assistant $newAssistant
     */
    public function createAction(\Effective\Aiassistant\Domain\Model\Assistant $newAssistant)
    {
        try {
            $response = $this->client->assistants()->create([
                'instructions' => $newAssistant->getInstructions(),
                'name' => $newAssistant->getName(),
                'tools' => [
                    [
                        'type' => 'code_interpreter',
                    ],
                ],
                'model' => $newAssistant->getModel(),
            ]);
            if (isset($response->id)) {
                $newAssistant->setAssistantId($response->id);
                $this->assistantRepository->add($newAssistant);
                $this->addFlashMessage('The object was successfully created.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
            } else {
                $this->addFlashMessage('Failed to create the assistant. No ID was returned.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            }
        } catch (\Exception $e) {
            $this->addFlashMessage('An error occurred while creating the assistant: ' . $e->getMessage(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }
        $absoluteTemplatePath = GeneralUtility::getFileAbsFileName('EXT:aiassistant/Resources/Private/Templates/Assistant/Show.html');
        $this->view->setTemplatePathAndFilename($absoluteTemplatePath);
        $this->view->assign('assistant', $newAssistant);
        return $this->htmlResponse();
    }


    /**
     * action edit
     *
     * @param \Effective\Aiassistant\Domain\Model\Assistant $assistant
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("assistant")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\Effective\Aiassistant\Domain\Model\Assistant $assistant): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('models', $this->requestModels());
        $this->view->assign('assistant', $assistant);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \Effective\Aiassistant\Domain\Model\Assistant $assistant
     */
    public function updateAction(\Effective\Aiassistant\Domain\Model\Assistant $assistant)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->assistantRepository->update($assistant);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \Effective\Aiassistant\Domain\Model\Assistant $assistant
     */
    public function deleteAction(\Effective\Aiassistant\Domain\Model\Assistant $assistant)
    {
        try {
            $response = $this->client->assistants()->delete($assistant->getAssistantId());
            if (isset($response->deleted) && $response->deleted) {
                $this->assistantRepository->remove($assistant);
                $this->addFlashMessage('The assistant was successfully deleted.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
            } else {
                $this->addFlashMessage('Deletion was not successful.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            }
        } catch (\Exception $e) {
            $this->addFlashMessage('An error occurred while deleting the assistant: ' . $e->getMessage(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }
        $absoluteTemplatePath = GeneralUtility::getFileAbsFileName('EXT:aiassistant/Resources/Private/Templates/Assistant/List.html');
        $this->view->setTemplatePathAndFilename($absoluteTemplatePath);
        $assistants = $this->assistantRepository->findAll();
        $this->view->assign('assistants', $assistants);
        return $this->htmlResponse();
    }

    /**
     * action request models array
     */
    public function requestModels() : array
    {
        $response = $this->client->models()->list();
        $models = [];
        foreach ($response->data as $model) {
            $models[$model->id] = $model->id;
        }
        return $models;
    }

    /**
     * Very similar to requestModels but with a returning format compatible with "itemsProcFunc" for filling FlexForms elements
     */
    public function fillAssistants(array &$config)
    {
        $assistants = $this->assistantRepository->findAll();
        foreach ($assistants as $assistant) {
            $config['items'][] = [$assistant->getName(), $assistant->getAssistantId()];
        }
    }
}
