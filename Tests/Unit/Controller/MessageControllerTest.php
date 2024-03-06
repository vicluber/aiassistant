<?php

declare(strict_types=1);

namespace Effective\Aiassistant\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Victor Willhuber <victorwillhuber@gmail.com>
 */
class MessageControllerTest extends UnitTestCase
{
    /**
     * @var \Effective\Aiassistant\Controller\MessageController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\Effective\Aiassistant\Controller\MessageController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllMessagesFromRepositoryAndAssignsThemToView(): void
    {
        $allMessages = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $messageRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $messageRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMessages));
        $this->subject->_set('messageRepository', $messageRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('messages', $allMessages);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenMessageToView(): void
    {
        $message = new \Effective\Aiassistant\Domain\Model\Message();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('message', $message);

        $this->subject->showAction($message);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenMessageToMessageRepository(): void
    {
        $message = new \Effective\Aiassistant\Domain\Model\Message();

        $messageRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $messageRepository->expects(self::once())->method('add')->with($message);
        $this->subject->_set('messageRepository', $messageRepository);

        $this->subject->createAction($message);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenMessageToView(): void
    {
        $message = new \Effective\Aiassistant\Domain\Model\Message();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('message', $message);

        $this->subject->editAction($message);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenMessageInMessageRepository(): void
    {
        $message = new \Effective\Aiassistant\Domain\Model\Message();

        $messageRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $messageRepository->expects(self::once())->method('update')->with($message);
        $this->subject->_set('messageRepository', $messageRepository);

        $this->subject->updateAction($message);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenMessageFromMessageRepository(): void
    {
        $message = new \Effective\Aiassistant\Domain\Model\Message();

        $messageRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $messageRepository->expects(self::once())->method('remove')->with($message);
        $this->subject->_set('messageRepository', $messageRepository);

        $this->subject->deleteAction($message);
    }
}
