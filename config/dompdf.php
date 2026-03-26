<?php

return [
    'show_warnings' => false,
    'public_path' => null,
    'convert_entities' => true,

    'options' => [
        'font_dir' => storage_path('fonts'),
        'font_cache' => storage_path('fonts'),
        'temp_dir' => sys_get_temp_dir(),
        'chroot' => realpath(base_path()),

        'allowed_protocols' => [
            'data://' => ['rules' => []],
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],

        'artifactPathValidation' => null,
        'log_output_file' => null,
        'enable_font_subsetting' => false,

        // ✅ ВАЖНО: Используем встроенные базовые шрифты PDF
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'default_paper_orientation' => 'portrait',

        // ❌ ИЗМЕНЕНО: Используем helvetica вместо serif
        'default_font' => 'helvetica',

        'dpi' => 96,
        'font_height_ratio' => 1.1,

        'enable_php' => false,
        'enable_javascript' => true,
        'enable_remote' => false,
        'allowed_remote_hosts' => null,
        'enable_html5_parser' => true,
    ],

    /**
     * ============================================
     * 🔧 РЕШЕНИЕ ДЛЯ КИРИЛЛИЦЫ
     * ============================================
     *
     * Если у вас сохраняются проблемы с кириллицей:
     *
     * 1. Самый простой способ - использовать HTML entities:
     *    ✅ В blade используйте: htmlspecialchars($text, ENT_QUOTES, 'UTF-8')
     *    ✅ Или в контроллере: str_replace(['ы', 'й'], ['i', 'j'], $text)
     *
     * 2. Установите системные шрифты и загрузите их:
     *    - Запустите: php load_fonts.php
     *    - Перегенерируйте отчеты
     *
     * 3. Или используйте специальную конфигурацию в CSS:
     *    - font-family: Helvetica, 'Times New Roman', serif;
     *    - Helvetica - встроенный PDF шрифт, поддерживает базовый Latin
     */

];
