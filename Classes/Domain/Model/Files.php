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
 * Files
 */
class Files extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * fileId
     *
     * @var string
     */
    protected $fileId = '';

    /**
     * The assistant to whom this file has been given
     *
     * @var \Effective\Aiassistant\Domain\Model\Assistant
     */
    protected $assistant = null;

    /**
     * Returns the fileId
     *
     * @return string
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * Sets the fileId
     *
     * @param string $fileId
     * @return void
     */
    public function setFileId(string $fileId)
    {
        $this->fileId = $fileId;
    }

    /**
     * Returns the assistant
     *
     * @return \Effective\Aiassistant\Domain\Model\Assistant
     */
    public function getAssistant()
    {
        return $this->assistant;
    }

    /**
     * Sets the assistant
     *
     * @param \Effective\Aiassistant\Domain\Model\Assistant $assistant
     * @return void
     */
    public function setAssistant(\Effective\Aiassistant\Domain\Model\Assistant $assistant)
    {
        $this->assistant = $assistant;
    }
}
