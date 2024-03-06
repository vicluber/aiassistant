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
class FilesTest extends UnitTestCase
{
    /**
     * @var \Effective\Aiassistant\Domain\Model\Files|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Effective\Aiassistant\Domain\Model\Files::class,
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
