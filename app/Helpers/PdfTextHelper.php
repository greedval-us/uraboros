<?php

namespace App\Helpers;

/**
 * Helper для корректного отображения кириллицы в DOMPDF
 *
 * DOMPDF имеет ограничения с некоторыми Unicode символами,
 * этот Helper помогает преобразовать текст в совместимый формат
 */
class PdfTextHelper
{
    /**
     * Подготовить текст для DOMPDF
     * Преобразует проблемные символы в совместимые
     */
    public static function prepare($text)
    {
        if (empty($text)) {
            return $text;
        }

        // Убедимся, что используем UTF-8
        if (mb_detect_encoding($text) !== 'UTF-8') {
            $text = utf8_encode($text);
        }

        // Для DOMPDF используем HTML entities для спецсимволов
        $text = mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8');

        return $text;
    }

    /**
     * Очистить и подготовить для DOMPDF
     */
    public static function clean($text)
    {
        return strip_tags(self::prepare($text));
    }

    /**
     * Преобразовать проблемные диакритические символы
     */
    public static function normalizeChars($text)
    {
        // Замены проблемных символов
        $replacements = [
            'ё' => 'ё',  // Кириллическая ё
            'Ё' => 'Ё',  // Кириллическая Ё (заглавная)
            '–' => '-',   // En dash на обычный дефис
            '—' => '-',   // Em dash на обычный дефис
            '«' => '"',   // Левая кавычка на обычную
            '»' => '"',   // Правая кавычка на обычную
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }

    /**
     * Преобразовать для вывода в таблицы DOMPDF
     */
    public static function tableCell($value)
    {
        return htmlspecialchars(self::prepare($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
