<?php

declare(strict_types=1);

namespace Effective\Aiassistant\Domain\Model;


/**
 * This file is part of the "OpenAI Asistant" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Victor Willhuber <victorwillhuber@gmail.com>, effective
 */

/**
 * Assistant
 */
class Assistant extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * assistantId
     *
     * @var string
     */
    protected $assistantId = '';

    /**
     * files
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $files = null;

    /**
     * Returns the assistantId
     *
     * @return string
     */
    public function getAssistantId()
    {
        return $this->assistantId;
    }

    /**
     * Sets the assistantId
     *
     * @param string $assistantId
     * @return void
     */
    public function setAssistantId(string $assistantId)
    {
        $this->assistantId = $assistantId;
    }

    /**
     * Returns the files
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the files
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $files
     * @return void
     */
    public function setFiles(\TYPO3\CMS\Extbase\Domain\Model\FileReference $files)
    {
        $this->files = $files;
    }
}
