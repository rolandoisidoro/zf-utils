<?php
return [
    'zfutils' => [
        'boostrap_notify' => [
            // See http://bootstrap-notify.remabledesigns.com/#documentation-options
            'options' => [
                'icon'    => '',
                'title'   => '',
                'url'     => '',
                'target'  => '',
            ],

            // See http://bootstrap-notify.remabledesigns.com/#documentation-settings
            'settings' => [
                'element'         => 'body',
                'position'        => null,
                'allow_dismiss'   => true,
                'showProgressbar' => false,
                'placement'       => [
                    'from'  => 'top',
                    'align' => 'right',
                ],
                'offset'          => [
                    'x' => 20,
                    'y' => 20,
                ],
                'spacing'         => 10,
                'z_index'         => 1031,
                'delay'           => 5000,
                'timer'           => 1000,
                'newest_on_top'   => false,
                'url_target'      => '_blank',
                'mouse_over'      => null,
                'animate'         => [
                    'enter' => 'animated fadeInDown',
                    'exit'  => 'animated fadeOutUp',
                ],
                'onShow'          => null,
                'onShown'         => null,
                'onClose'         => null,
                'onClosed'        => null,
                'icon_type'       => 'class',
            ],
        ],
    ],

    'view_helpers' => [
        'factories' => [
            'ZFUtils\View\Helper\BootstrapNotify' => 'ZFUtils\View\Helper\Factory\BootstrapNotifyFactory',
        ],

        'aliases' => [
            'bootstrapnotify' => 'ZFUtils\View\Helper\BootstrapNotify',
            'bootstrapNotify' => 'ZFUtils\View\Helper\BootstrapNotify',
            'BootstrapNotify' => 'ZFUtils\View\Helper\BootstrapNotify',
        ],
    ],
];

