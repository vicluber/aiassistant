<?php

declare(strict_types=1);

namespace Effective\Aiassistant\Controller;

use Effective\Aiassistant\Domain\Repository\AssistantRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

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
    public function __construct(protected readonly ModuleTemplateFactory $moduleTemplateFactory, AssistantRepository $assistantRepository)
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
        if($this->apiKey == ""){
            $this->addFlashMessage('It seems that the API key is missing from the configuration. Set your API key in "Extension Configuration".', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        }else{
            $assistants = $this->assistantRepository->findAll();
            $this->view->assign('assistants', $assistants);
        }
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
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
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        if($this->apiKey == ""){
            $this->addFlashMessage('It seems that the API key is missing from the configuration. Set your API key in "Extension Configuration".', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        }else{
            $this->view->assign('models', $this->requestModels());
        }
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
    }

    /**
     * action create
     *
     * @param \Effective\Aiassistant\Domain\Model\Assistant $newAssistant
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createAction(\Effective\Aiassistant\Domain\Model\Assistant $newAssistant): \Psr\Http\Message\ResponseInterface
    {
        
        try {
            if ($_FILES['file']['error']['file'] === 0) {
                $uploaded = $this->uploadFile($_FILES['file']['tmp_name']['file'], $_FILES['file']['name']['file']);
            }
            $tools = [];
            if($newAssistant->getRetrieval()){
                $tools[] = ['type' => 'retrieval'];
            }
            $response = $this->client->assistants()->create([
                'instructions' => $newAssistant->getInstructions(),
                'name' => $newAssistant->getName(),
                'tools' => $tools,
                'model' => $newAssistant->getModel(),
            ]);
            
            if (isset($response->id)) {
                $newAssistant->setAssistantId($response->id);
                $this->assistantRepository->add($newAssistant);
                if(isset($uploaded)){
                    if($uploaded != false){ $this->attachFileToAssistant($uploaded, $response->id); }
                }
                $this->addFlashMessage('The object was successfully created.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
            } else {
                $this->addFlashMessage('Failed to create the assistant. No ID was returned.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            }
        } catch (\Exception $e) {
            $this->addFlashMessage('An error occurred while creating the assistant: ' . $e->getMessage(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
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
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
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
            if($assistant->getAssistantId() == ''){ $assistant->setAssistantId('placeholder'); }
            $response = $this->client->assistants()->delete($assistant->getAssistantId());
            if (isset($response->deleted) && $response->deleted) {
                $this->assistantRepository->remove($assistant);
                $this->addFlashMessage('The assistant was successfully deleted.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
            } else {
                $this->addFlashMessage('Deletion was not successful.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            }
        } catch (\Exception $e) {
            if(str_contains($e->getMessage(), 'No assistant found with')){
                $this->addFlashMessage('The assistant was successfully deleted.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
                $this->addFlashMessage('No assistant on OpenAI found with that ID', 'Warning', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                $this->assistantRepository->remove($assistant);
            }else{
                $this->addFlashMessage('Oops!: ' . $e->getMessage(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            }
        }
        /*$absoluteTemplatePath = GeneralUtility::getFileAbsFileName('EXT:aiassistant/Resources/Private/Templates/Assistant/List.html');
        $this->view->setTemplatePathAndFilename($absoluteTemplatePath);*/
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
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

    /**
     * Upload files to OpenAI dashboard
     */
    public function uploadFile($temporaryFileName, $originalFileName)
    {
        $filename = preg_replace('/[^A-Za-z0-9_.-]/', '', str_replace(' ', '_', $originalFileName));
        move_uploaded_file($temporaryFileName, '/var/www/html/public/fileadmin/user_upload/' . $filename);
        $uploadResponse = $this->client->files()->upload([
            'purpose' => 'assistants',
            'file' => fopen('/var/www/html/public/fileadmin/user_upload/' . $filename, 'r'),
        ]);
        $uploadId = $uploadResponse->id;
        for ($attempts = 0; $attempts < 2; $attempts++) {
            sleep(3);
            $statusResponse = $this->client->files()->retrieve($uploadId);
            if ($statusResponse->status == 'processed') {
                return $uploadResponse->id;
            }
        }
        return false;
    }


    /**
     * Upload files to OpenAI dashboard
     */
    public function attachFileToAssistant($fileId, $assistantId)
    {
        try {
            $response = $this->client->assistants()->files()->create($assistantId, [
                'file_id' => $fileId,
            ]);
            if($response->id)
            {
                return true;
            }
            
        } catch (\Throwable $th) {
            $this->addFlashMessage('Oops!: ' . $e->getMessage(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }
    }
}
