<?php

return [
    'show_warnings' => false,
    'public_path' => null,
    'convert_entities' => true,
    'show_warnings' => false,

    'options' => [
        'defaultFont' => 'DejaVu Sans',
        'fontDir' => storage_path('fonts'),
        'fontCache' => storage_path('fonts'),
        'tempDir' => storage_path('app'),
        'chroot' => realpath(base_path()),
        'isRemoteEnabled' => true,
        'isHtml5ParserEnabled' => true,
        'isFontSubsettingEnabled' => true,
        'debugPng' => false,
        'debugKeepTemp' => false,
        'debugCss' => false,
        'debugLayout' => false,
        'debugLayoutLines' => false,
        'debugLayoutBlocks' => false,
        'debugLayoutInline' => false,
        'debugLayoutPaddingBox' => false,
        'pdfBackend' => 'CPDF',
        'pdflibLicense' => '',
        'adminUsername' => '',
        'adminPassword' => '',
    ],
];
