<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadPdfFonts extends Command
{
    protected $signature = 'pdf:load-fonts';
    protected $description = 'Загрузить кириллические шрифты в DOMPDF для корректного отображения текста';

    public function handle()
    {
        $this->info('🔄 Загрузка шрифтов для DOMPDF...');

        $dompdf_root = base_path('vendor/dompdf/dompdf');
        $script = $dompdf_root . '/bin/load_font.php';

        if (!file_exists($script)) {
            $this->error('❌ Скрипт load_font.php не найден!');
            return Command::FAILURE;
        }

        // Встроенные шрифты Windows/Linux
        $fonts = [
            'DejaVu Sans' => 'DejaVuSans.ttf',
            'DejaVu Sans Bold' => 'DejaVuSans-Bold.ttf',
            'DejaVu Sans Oblique' => 'DejaVuSans-Oblique.ttf',
            'DejaVu Sans Bold Oblique' => 'DejaVuSans-BoldOblique.ttf',
        ];

        // Пути где искать шрифты
        $font_paths = [
            '/usr/share/fonts/truetype/dejavu/',
            '/System/Library/Fonts/',
            'C:/Windows/Fonts/',
            '/opt/fonts/',
        ];

        $loaded_count = 0;
        $failed_count = 0;

        foreach ($fonts as $font_name => $font_file) {
            $font_path = null;

            // Ищем шрифт в системе
            foreach ($font_paths as $path) {
                $full_path = $path . $font_file;
                if (file_exists($full_path)) {
                    $font_path = $full_path;
                    break;
                }
            }

            if (!$font_path) {
                $this->warn("⏭️  Пропущен: $font_name (не найден в системе)");
                $failed_count++;
                continue;
            }

            $this->line("📦 Загрузка: $font_name...");

            try {
                $output = shell_exec("php $script '$font_name' '$font_path' 2>&1");

                if ($output && strpos($output, 'Error') === false && strpos($output, 'error') === false) {
                    $this->info("   ✅ OK");
                    $loaded_count++;
                } else {
                    $this->error("   ❌ Ошибка при загрузке");
                    if ($output) {
                        $this->line("   Детали: $output");
                    }
                    $failed_count++;
                }
            } catch (\Exception $e) {
                $this->error("   ❌ Exception: " . $e->getMessage());
                $failed_count++;
            }
        }

        $this->newLine();
        $this->info("📊 Результат:");
        $this->line("   Загружено: $loaded_count");
        $this->line("   Ошибок: $failed_count");

        if ($loaded_count > 0) {
            $this->info("\n✅ Шрифты успешно загружены!");
            $this->line("📝 Теперь перегенерируйте отчеты для применения изменений.");
            return Command::SUCCESS;
        } else {
            $this->warn("\n⚠️  Шрифты не загружены. Проверьте наличие системных шрифтов.");
            $this->line("Попробуйте установить: sudo apt-get install fonts-dejavu");
            return Command::FAILURE;
        }
    }
}
