<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PDF Configuration for DomPDF
    |--------------------------------------------------------------------------
    |
    | This configuration file contains the various options that can be used
    | when generating PDFs using the DomPDF library. Ensure UTF-8 encoding
    | is properly handled for multi-byte characters (Cyrillic, etc).
    |
    */

    'public_path' => env('DOMPDF_PUBLIC_PATH', public_path()),

    'storage_path' => env('DOMPDF_STORAGE_PATH', storage_path('app')),

    'temp_dir' => env('DOMPDF_TEMP_DIR', sys_get_temp_dir()),

    'font_dir' => env('DOMPDF_FONT_DIR', storage_path('fonts')),

    'font_cache' => env('DOMPDF_FONT_CACHE', storage_path('fonts')),

    'pdf_backend' => env('DOMPDF_PDF_BACKEND', 'CPDF'),

    'default_paper_size' => env('DOMPDF_DEFAULT_PAPER_SIZE', 'A4'),

    'default_font' => env('DOMPDF_DEFAULT_FONT', 'DejaVu Sans'),

    'dpi' => env('DOMPDF_DPI', 96),

    'enable_php' => env('DOMPDF_ENABLE_PHP', false),

    'enable_javascript' => env('DOMPDF_ENABLE_JAVASCRIPT', true),

    'enable_remote' => env('DOMPDF_ENABLE_REMOTE', false),

    'enable_css_float' => env('DOMPDF_ENABLE_CSS_FLOAT', false),

    'enable_html5_parser' => env('DOMPDF_ENABLE_HTML5_PARSER', true),

    'enable_font_subsetting' => env('DOMPDF_ENABLE_FONT_SUBSETTING', false),

    'allowed_protocols' => ['file://', 'http://', 'https://', 'data://'],

    'base_path' => env('DOMPDF_BASE_PATH', base_path()),

    'defines' => [
        'DOMPDF_ENABLE_AUTOLOAD' => false,
        'DOMPDF_FONT_HEIGHT_RATIO' => 1.15,
        'DOMPDF_DEFAULT_MEDIA_TYPE' => 'print',
    ],

    /*
    |--------------------------------------------------------------------------
    | UTF-8 and Encoding Settings
    |--------------------------------------------------------------------------
    | These settings ensure proper handling of multi-byte characters
    */

    'encoding' => 'UTF-8',

    'is_utf8_enabled' => true,

    'charset' => 'utf-8',
];
