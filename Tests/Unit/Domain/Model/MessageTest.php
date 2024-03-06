<?php

declare(strict_types=1);

namespace Effective\Aiassistant\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Victor Willhuber <victorwillhuber@gmail.com>
 */
class MessageTest extends UnitTestCase
{
    /**
     * @var \Effective\Aiassistant\Domain\Model\Message|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Effective\Aiassistant\Domain\Model\Message::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getUserPromptReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getUserPrompt()
        );
    }

    /**
     * @test
     */
    public function setUserPromptForStringSetsUserPrompt(): void
    {
        $this->subject->setUserPrompt('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('userPrompt'));
    }

    /**
     * @test
     */
    public function getAssistantAnswerReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getAssistantAnswer()
        );
    }

    /**
     * @test
     */
    public function setAssistantAnswerForStringSetsAssistantAnswer(): void
    {
        $this->subject->setAssistantAnswer('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('assistantAnswer'));
    }

    /**
     * @test
     */
    public function getFileCitationReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getFileCitation()
        );
    }

    /**
     * @test
     */
    public function setFileCitationForStringSetsFileCitation(): void
    {
        $this->subject->setFileCitation('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('fileCitation'));
    }

    /**
     * @test
     */
    public function getThreadReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getThread()
        );
    }

    /**
     * @test
     */
    public function setThreadForStringSetsThread(): void
    {
        $this->subject->setThread('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('thread'));
    }

    /**
     * @test
     */
    public function getPromptTokensReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getPromptTokens()
        );
    }

    /**
     * @test
     */
    public function setPromptTokensForIntSetsPromptTokens(): void
    {
        $this->subject->setPromptTokens(12);

        self::assertEquals(12, $this->subject->_get('promptTokens'));
    }

    /**
     * @test
     */
    public function getCompletionTokensReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getCompletionTokens()
        );
    }

    /**
     * @test
     */
    public function setCompletionTokensForIntSetsCompletionTokens(): void
    {
        $this->subject->setCompletionTokens(12);

        self::assertEquals(12, $this->subject->_get('completionTokens'));
    }

    /**
     * @test
     */
    public function getFileIdReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getFileId()
        );
    }

    /**
     * @test
     */
    public function setFileIdForStringSetsFileId(): void
    {
        $this->subject->setFileId('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('fileId'));
    }

    /**
     * @test
     */
    public function getAssistantReturnsInitialValueForAssistant(): void
    {
        self::assertEquals(
            null,
            $this->subject->getAssistant()
        );
    }

    /**
     * @test
     */
    public function setAssistantForAssistantSetsAssistant(): void
    {
        $assistantFixture = new \Effective\Aiassistant\Domain\Model\Assistant();
        $this->subject->setAssistant($assistantFixture);

        self::assertEquals($assistantFixture, $this->subject->_get('assistant'));
    }
}
