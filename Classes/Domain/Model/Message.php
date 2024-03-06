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
 * Message
 */
class Message extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * userPrompt
     *
     * @var string
     */
    protected $userPrompt = '';

    /**
     * assistantAnswer
     *
     * @var string
     */
    protected $assistantAnswer = '';

    /**
     * fileCitation
     *
     * @var string
     */
    protected $fileCitation = '';

    /**
     * thread
     *
     * @var string
     */
    protected $thread = '';

    /**
     * promptTokens
     *
     * @var int
     */
    protected $promptTokens = 0;

    /**
     * completionTokens
     *
     * @var int
     */
    protected $completionTokens = 0;

    /**
     * fileId
     *
     * @var string
     */
    protected $fileId = '';

    /**
     * The assistant who has sent this message
     *
     * @var \Effective\Aiassistant\Domain\Model\Assistant
     */
    protected $assistant = null;

    /**
     * Returns the userPrompt
     *
     * @return string
     */
    public function getUserPrompt()
    {
        return $this->userPrompt;
    }

    /**
     * Sets the userPrompt
     *
     * @param string $userPrompt
     * @return void
     */
    public function setUserPrompt(string $userPrompt)
    {
        $this->userPrompt = $userPrompt;
    }

    /**
     * Returns the assistantAnswer
     *
     * @return string
     */
    public function getAssistantAnswer()
    {
        return $this->assistantAnswer;
    }

    /**
     * Sets the assistantAnswer
     *
     * @param string $assistantAnswer
     * @return void
     */
    public function setAssistantAnswer(string $assistantAnswer)
    {
        $this->assistantAnswer = $assistantAnswer;
    }

    /**
     * Returns the fileCitation
     *
     * @return string
     */
    public function getFileCitation()
    {
        return $this->fileCitation;
    }

    /**
     * Sets the fileCitation
     *
     * @param string $fileCitation
     * @return void
     */
    public function setFileCitation(string $fileCitation)
    {
        $this->fileCitation = $fileCitation;
    }

    /**
     * Returns the thread
     *
     * @return string
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Sets the thread
     *
     * @param string $thread
     * @return void
     */
    public function setThread(string $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Returns the promptTokens
     *
     * @return int
     */
    public function getPromptTokens()
    {
        return $this->promptTokens;
    }

    /**
     * Sets the promptTokens
     *
     * @param int $promptTokens
     * @return void
     */
    public function setPromptTokens(int $promptTokens)
    {
        $this->promptTokens = $promptTokens;
    }

    /**
     * Returns the completionTokens
     *
     * @return int
     */
    public function getCompletionTokens()
    {
        return $this->completionTokens;
    }

    /**
     * Sets the completionTokens
     *
     * @param int $completionTokens
     * @return void
     */
    public function setCompletionTokens(int $completionTokens)
    {
        $this->completionTokens = $completionTokens;
    }

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
