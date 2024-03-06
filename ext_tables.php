<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Aiassistant',
        'site',
        'createaiassistant',
        '',
        [
            \Effective\Aiassistant\Controller\MessageController::class => 'list, show, new, create, edit, update, delete',
            \Effective\Aiassistant\Controller\AssistantController::class => 'list, show, new, create, edit, update, delete',
            
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:aiassistant/Resources/Public/Icons/user_mod_createaiassistant.svg',
            'labels' => 'LLL:EXT:aiassistant/Resources/Private/Language/locallang_createaiassistant.xlf',
        ]
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_aiassistant_domain_model_message', 'EXT:aiassistant/Resources/Private/Language/locallang_csh_tx_aiassistant_domain_model_message.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_aiassistant_domain_model_message');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_aiassistant_domain_model_assistant', 'EXT:aiassistant/Resources/Private/Language/locallang_csh_tx_aiassistant_domain_model_assistant.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_aiassistant_domain_model_assistant');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_aiassistant_domain_model_files', 'EXT:aiassistant/Resources/Private/Language/locallang_csh_tx_aiassistant_domain_model_files.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_aiassistant_domain_model_files');

    // Flexform - Productslist
    $pluginSignature = 'aiassistant_chatform';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:aiassistant/Configuration/FlexForms/ChatForm.xml');
})();
