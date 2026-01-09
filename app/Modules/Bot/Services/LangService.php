<?php

namespace App\Modulses\Bot\Services;

class LangService
{
    protected static array $translations = [];

    public static function get(string $lang, string $key, array $replace = []): string
    {
        if (!isset(self::$translations[$lang])) {
            $path = base_path("app/Modulses/Bot/Lang/{$lang}.json");

            if (!file_exists($path)) {
                $path = base_path("app/Modulses/Bot/Lang/en.json");
            }

            self::$translations[$lang] = json_decode(file_get_contents($path), true);
        }

        $value = self::arrayGet(self::$translations[$lang], $key, $key);

        foreach ($replace as $k => $v) {
            $value = str_replace(":$k", $v, $value);
        }

        return $value;
    }

    protected static function arrayGet(array $array, string $key, $default = null)
    {
        foreach (explode('.', $key) as $segment) {
            if (!isset($array[$segment])) {
                return $default;
            }
            $array = $array[$segment];
        }

        return $array;
    }

}
