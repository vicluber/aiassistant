<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:aiassistant/Resources/Private/Language/locallang_db.xlf:tx_aiassistant_domain_model_assistant',
        'label' => 'assistant_id',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'assistant_id',
        'iconfile' => 'EXT:aiassistant/Resources/Public/Icons/tx_aiassistant_domain_model_assistant.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'assistant_id, name, instructions, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_aiassistant_domain_model_assistant',
                'foreign_table_where' => 'AND {#tx_aiassistant_domain_model_assistant}.{#pid}=###CURRENT_PID### AND {#tx_aiassistant_domain_model_assistant}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'assistant_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:aiassistant/Resources/Private/Language/locallang_db.xlf:tx_aiassistant_domain_model_assistant.assistant_id',
            'description' => 'LLL:EXT:aiassistant/Resources/Private/Language/locallang_db.xlf:tx_aiassistant_domain_model_assistant.assistant_id.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:aiassistant/Resources/Private/Language/locallang_db.xlf:tx_aiassistant_domain_model_assistant.name',
            'description' => 'LLL:EXT:aiassistant/Resources/Private/Language/locallang_db.xlf:tx_aiassistant_domain_model_assistant.name.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'instructions' => [
            'exclude' => true,
            'label' => 'LLL:EXT:aiassistant/Resources/Private/Language/locallang_db.xlf:tx_aiassistant_domain_model_assistant.instructions',
            'description' => 'LLL:EXT:aiassistant/Resources/Private/Language/locallang_db.xlf:tx_aiassistant_domain_model_assistant.instructions.description',
            'config' => [
                'type' => 'text',
                'size' => 100,
                'eval' => 'trim',
                'default' => ''
            ],
        ]
    ],
];
