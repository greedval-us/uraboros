#!/usr/bin/env php
<?php
/**
 * Скрипт для загрузки шрифтов в DOMPDF
 * Использование: php load_fonts.php
 */

// Найдите правильный путь к DOMPDF
$dompdf_root = __DIR__ . '/vendor/dompdf/dompdf';

if (!file_exists($dompdf_root)) {
    echo "❌ Ошибка: DOMPDF не найден в " . $dompdf_root . "\n";
    exit(1);
}

// Загрузим консоль скрипт DOMPDF для регистрации шрифтов
$script = $dompdf_root . '/bin/load_font.php';

if (!file_exists($script)) {
    echo "❌ Ошибка: Скрипт load_font.php не найден\n";
    exit(1);
}

// Системные шрифты с поддержкой кириллицы
$fonts_to_load = [
    // DejaVu (обычно доступен в Linux системах)
    'DejaVu Sans' => '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
    'DejaVu Sans Bold' => '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
    'DejaVu Sans Oblique' => '/usr/share/fonts/truetype/dejavu/DejaVuSans-Oblique.ttf',
    'DejaVu Sans Bold Oblique' => '/usr/share/fonts/truetype/dejavu/DejaVuSans-BoldOblique.ttf',

    // Liberation (альтернатива)
    'Liberation Sans' => '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
    'Liberation Sans Bold' => '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
];

echo "🔄 Загрузка шрифтов в DOMPDF...\n\n";

$loaded = 0;
$failed = 0;

foreach ($fonts_to_load as $name => $path) {
    // Проверяем доступность шрифта
    if (!file_exists($path)) {
        echo "⏭️  Пропущен (не найден): $name\n";
        $failed++;
        continue;
    }

    echo "📦 Загрузка: $name... ";

    // Используем exec потому что load_font.php требует вызова через командную строку
    $output = shell_exec("php $script '$name' '$path' 2>&1");

    if ($output && strpos($output, 'Error') === false) {
        echo "✅ OK\n";
        $loaded++;
    } else {
        echo "❌ ОШИБКА\n";
        if ($output) {
            echo "   Детали: $output\n";
        }
        $failed++;
    }
}

echo "\n📊 Результат: Загружено $loaded, Ошибок $failed\n";

if ($loaded > 0) {
    echo "\n✅ Шрифты успешно загружены! Перегенерируйте PDF отчеты.\n";
    exit(0);
} else {
    echo "\n⚠️  Не удалось загрузить шрифты. Попробуйте вариант ниже.\n";
    exit(1);
}
