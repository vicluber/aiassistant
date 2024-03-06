<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Aiassistant',
        'Chatform',
        [
            \Effective\Aiassistant\Controller\MessageController::class => 'index, list, show, new, create, edit, update, delete',
            \Effective\Aiassistant\Controller\AssistantController::class => 'index, list, show, new, create, edit, update, delete'
        ],
        // non-cacheable actions
        [
            \Effective\Aiassistant\Controller\MessageController::class => 'create, update, delete',
            \Effective\Aiassistant\Controller\AssistantController::class => 'create, update, delete'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    chatform {
                        iconIdentifier = aiassistant-plugin-chatform
                        title = LLL:EXT:aiassistant/Resources/Private/Language/locallang_db.xlf:tx_aiassistant_chatform.name
                        description = LLL:EXT:aiassistant/Resources/Private/Language/locallang_db.xlf:tx_aiassistant_chatform.description
                        tt_content_defValues {
                            CType = list
                            list_type = aiassistant_chatform
                        }
                    }
                }
                show = *
            }
       }'
    );
})();
