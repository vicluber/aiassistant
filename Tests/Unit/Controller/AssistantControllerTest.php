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
class AssistantControllerTest extends UnitTestCase
{
    /**
     * @var \Effective\Aiassistant\Controller\AssistantController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\Effective\Aiassistant\Controller\AssistantController::class))
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
    public function listActionFetchesAllAssistantsFromRepositoryAndAssignsThemToView(): void
    {
        $allAssistants = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $assistantRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $assistantRepository->expects(self::once())->method('findAll')->will(self::returnValue($allAssistants));
        $this->subject->_set('assistantRepository', $assistantRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('assistants', $allAssistants);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenAssistantToView(): void
    {
        $assistant = new \Effective\Aiassistant\Domain\Model\Assistant();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('assistant', $assistant);

        $this->subject->showAction($assistant);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenAssistantToAssistantRepository(): void
    {
        $assistant = new \Effective\Aiassistant\Domain\Model\Assistant();

        $assistantRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $assistantRepository->expects(self::once())->method('add')->with($assistant);
        $this->subject->_set('assistantRepository', $assistantRepository);

        $this->subject->createAction($assistant);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenAssistantToView(): void
    {
        $assistant = new \Effective\Aiassistant\Domain\Model\Assistant();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('assistant', $assistant);

        $this->subject->editAction($assistant);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenAssistantInAssistantRepository(): void
    {
        $assistant = new \Effective\Aiassistant\Domain\Model\Assistant();

        $assistantRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $assistantRepository->expects(self::once())->method('update')->with($assistant);
        $this->subject->_set('assistantRepository', $assistantRepository);

        $this->subject->updateAction($assistant);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenAssistantFromAssistantRepository(): void
    {
        $assistant = new \Effective\Aiassistant\Domain\Model\Assistant();

        $assistantRepository = $this->getMockBuilder(\::class)
            ->onlyMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $assistantRepository->expects(self::once())->method('remove')->with($assistant);
        $this->subject->_set('assistantRepository', $assistantRepository);

        $this->subject->deleteAction($assistant);
    }
}
