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
     * instructions
     *
     * @var string
     */
    protected $instructions = '';

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * retrieval
     *
     * @var bool
     */
    protected $retrieval = false;

    /**
     * model
     *
     * @var string
     */
    protected $model = '';

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
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns the instructions
     *
     * @return string
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Sets the instructions
     *
     * @param string $instructions
     * @return void
     */
    public function setInstructions(string $instructions)
    {
        $this->instructions = $instructions;
    }

    /**
     * Returns the model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the model
     *
     * @param string $model
     * @return void
     */
    public function setModel(string $model)
    {
        $this->model = $model;
    }

    /**
     * Returns the retrieval
     *
     * @return bool
     */
    public function getRetrieval()
    {
        return $this->retrieval;
    }

    /**
     * Sets the retrieval
     *
     * @param bool $retrieval
     * @return void
     */
    public function setRetrieval(bool $retrieval)
    {
        $this->retrieval = $retrieval;
    }
}
