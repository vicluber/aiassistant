<?php

declare(strict_types=1);

namespace Effective\Aiassistant\Controller;

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
 * AssistantController
 */
class AssistantController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

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
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \Effective\Aiassistant\Domain\Model\Assistant $newAssistant
     */
    public function createAction(\Effective\Aiassistant\Domain\Model\Assistant $newAssistant)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->assistantRepository->add($newAssistant);
        $this->redirect('list');
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
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
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
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->assistantRepository->remove($assistant);
        $this->redirect('list');
    }
}
