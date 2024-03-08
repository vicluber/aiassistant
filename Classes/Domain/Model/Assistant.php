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
     * name
     *
     * @var string
     */
    protected $name = '';

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
}
