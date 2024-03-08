<?php
return [
    'createaiassistant' => [
        'parent' => 'web',
        'position' => ['after' => 'web_info'],
        'access' => 'admin',
        'workspaces' => 'live',
        'icon' => 'EXT:aiassistant/Resources/Public/Icons/user_mod_createaiassistant.svg',
        'labels' => ['title' => 'AI Assistants', 'shortDescription' => 'Use this module to create new assistants an read the messages users have had with your assistants'],
        'extensionName' => 'Aiassistant',
        'controllerActions' => [
            \Effective\Aiassistant\Controller\AssistantController::class =>  [ 'list', 'show', 'new', 'create', 'edit', 'update', 'delete' ]
        ],
    ],
];