<?php

declare(strict_types=1);

namespace Effective\Aiassistant\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * This file is part of the "OpenAI Assistant" Extension for TYPO3 CMS.
 *
 * (c) 2024 Victor Willhuber <victorwillhuber@gmail.com>, effective
 */

/**
 * The repository for Assistants
 */
class AssistantRepository extends Repository
{
    /**
     * Finds an assistant by its assistantId
     *
     * @param string $assistantId
     */
    public function findOneByAssistantId(string $assistantId)
    {
        $query = $this->createQuery();
        $statement = "SELECT * FROM tx_aiassistant_domain_model_assistant WHERE assistant_id = '" . $assistantId . "'";
        $query->statement($statement);
        return $query->execute()->getFirst();
    }
}
