<?php

namespace App\Modules\Report\Helpers;

class EncodingHelper
{
    /**
     * Рекурсивно преобразует все строки в входных данных в UTF-8 кодировку.
     * Обрабатывает массивы, объекты и скалярные значения.
     *
     * @param mixed $data Данные для обработки
     * @param array $processed Массив для отслеживания обработанных объектов (защита от циклических ссылок)
     *
     * @return mixed Данные с преобразованной кодировкой
     */
    public static function ensureUtf8(mixed $data, array &$processed = []): mixed
    {
        // Обработка строк
        if (is_string($data)) {
            return self::convertStringToUtf8($data);
        }

        // Обработка массивов
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = self::ensureUtf8($value, $processed);
            }
            return $result;
        }

        // Обработка объектов
        if (is_object($data)) {
            // Защита от циклических ссылок
            $objectId = spl_object_id($data);
            if (isset($processed[$objectId])) {
                return $data;
            }

            $processed[$objectId] = true;

            // Получаем рефлексионный класс для обработки приватных и защищённых свойств
            $reflection = new \ReflectionObject($data);

            foreach ($reflection->getProperties() as $property) {
                $property->setAccessible(true);

                try {
                    $value = $property->getValue($data);
                    $convertedValue = self::ensureUtf8($value, $processed);
                    $property->setValue($data, $convertedValue);
                } catch (\Throwable $e) {
                    // Пропускаем свойства, которые не можно устанавливать
                    continue;
                }
            }

            return $data;
        }

        // Для других типов (int, float, bool, null) просто возвращаем как есть
        return $data;
    }

    /**
     * Преобразует строку в UTF-8 кодировку с проверкой текущей кодировки.
     * Защита от двойного кодирования.
     *
     * @param string $string Строка для преобразования
     *
     * @return string Строка в UTF-8 кодировке
     */
    private static function convertStringToUtf8(string $string): string
    {
        // Если строка уже в UTF-8, не преобразуем
        if (mb_check_encoding($string, 'UTF-8')) {
            return $string;
        }

        // Пытаемся определить текущую кодировку
        $detectedEncoding = mb_detect_encoding($string, ['UTF-8', 'Windows-1251', 'ISO-8859-1', 'ASCII'], true);

        // Если кодировка не определена или уже UTF-8, возвращаем как есть
        if (!$detectedEncoding || $detectedEncoding === 'UTF-8') {
            return $string;
        }

        // Преобразуем из обнаруженной кодировки в UTF-8
        $converted = mb_convert_encoding($string, 'UTF-8', $detectedEncoding);

        // Если преобразование не удалось, возвращаем оригинальную строку
        return $converted !== false ? $converted : $string;
    }

    /**
     * Преобразует массив или объект для использования в HTML/XML контексте.
     * Применяет htmlspecialchars к строковым значениям, сохраняя UTF-8.
     *
     * @param mixed $data Данные для экранирования
     * @param array $processed Массив для отслеживания обработанных объектов
     *
     * @return mixed Экранированные данные
     */
    public static function sanitizeForHtml(mixed $data, array &$processed = []): mixed
    {
        // Обработка строк
        if (is_string($data)) {
            // Сначала убеждаемся, что строка в UTF-8
            $utf8String = self::convertStringToUtf8($data);
            // Экранируем специальные HTML-символы
            return htmlspecialchars($utf8String, ENT_QUOTES, 'UTF-8');
        }

        // Обработка массивов
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = self::sanitizeForHtml($value, $processed);
            }
            return $result;
        }

        // Обработка объектов
        if (is_object($data)) {
            $objectId = spl_object_id($data);
            if (isset($processed[$objectId])) {
                return $data;
            }

            $processed[$objectId] = true;

            $reflection = new \ReflectionObject($data);

            foreach ($reflection->getProperties() as $property) {
                $property->setAccessible(true);

                try {
                    $value = $property->getValue($data);
                    $sanitizedValue = self::sanitizeForHtml($value, $processed);
                    $property->setValue($data, $sanitizedValue);
                } catch (\Throwable $e) {
                    continue;
                }
            }

            return $data;
        }

        // Для других типов просто возвращаем как есть
        return $data;
    }
}
