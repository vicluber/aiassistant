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
class AssistantTest extends UnitTestCase
{
    /**
     * @var \Effective\Aiassistant\Domain\Model\Assistant|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Effective\Aiassistant\Domain\Model\Assistant::class,
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
    public function getAssistantIdReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getAssistantId()
        );
    }

    /**
     * @test
     */
    public function setAssistantIdForStringSetsAssistantId(): void
    {
        $this->subject->setAssistantId('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('assistantId'));
    }

    /**
     * @test
     */
    public function getFilesReturnsInitialValueForFileReference(): void
    {
        self::assertEquals(
            null,
            $this->subject->getFiles()
        );
    }

    /**
     * @test
     */
    public function setFilesForFileReferenceSetsFiles(): void
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setFiles($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('files'));
    }
}
