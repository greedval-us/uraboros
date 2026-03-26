<?php

namespace Tests\Unit\Modules\Report\Helpers;

use App\Modules\Report\Helpers\EncodingHelper;
use Tests\TestCase;

class EncodingHelperTest extends TestCase
{
    public function test_ensure_utf8_with_ascii_string()
    {
        $input = 'Hello World';
        $result = EncodingHelper::ensureUtf8($input);

        $this->assertIsString($result);
        $this->assertEquals('Hello World', $result);
        $this->assertTrue(mb_check_encoding($result, 'UTF-8'));
    }

    public function test_ensure_utf8_with_cyrillic_string()
    {
        $input = 'Привет Мир';
        $result = EncodingHelper::ensureUtf8($input);

        $this->assertIsString($result);
        $this->assertEquals('Привет Мир', $result);
        $this->assertTrue(mb_check_encoding($result, 'UTF-8'));
    }

    public function test_ensure_utf8_with_mixed_string()
    {
        $input = 'Hello Привет 你好';
        $result = EncodingHelper::ensureUtf8($input);

        $this->assertIsString($result);
        $this->assertEquals('Hello Привет 你好', $result);
        $this->assertTrue(mb_check_encoding($result, 'UTF-8'));
    }

    public function test_ensure_utf8_with_array()
    {
        $input = [
            'name' => 'Тестовое имя',
            'value' => 'Значение',
            'nested' => [
                'key' => 'Вложенное значение',
            ],
        ];

        $result = EncodingHelper::ensureUtf8($input);

        $this->assertIsArray($result);
        $this->assertEquals('Тестовое имя', $result['name']);
        $this->assertEquals('Значение', $result['value']);
        $this->assertEquals('Вложенное значение', $result['nested']['key']);
        $this->assertTrue(mb_check_encoding($result['name'], 'UTF-8'));
        $this->assertTrue(mb_check_encoding($result['nested']['key'], 'UTF-8'));
    }

    public function test_ensure_utf8_with_object()
    {
        $object = new \stdClass();
        $object->title = 'Заголовок';
        $object->description = 'Описание на русском';

        $result = EncodingHelper::ensureUtf8($object);

        $this->assertIsObject($result);
        $this->assertEquals('Заголовок', $result->title);
        $this->assertEquals('Описание на русском', $result->description);
        $this->assertTrue(mb_check_encoding($result->title, 'UTF-8'));
    }

    public function test_ensure_utf8_with_nested_object()
    {
        $nested = new \stdClass();
        $nested->text = 'Вложенный текст';

        $parent = new \stdClass();
        $parent->name = 'Родительский объект';
        $parent->child = $nested;

        $result = EncodingHelper::ensureUtf8($parent);

        $this->assertIsObject($result);
        $this->assertEquals('Родительский объект', $result->name);
        $this->assertEquals('Вложенный текст', $result->child->text);
        $this->assertTrue(mb_check_encoding($result->name, 'UTF-8'));
        $this->assertTrue(mb_check_encoding($result->child->text, 'UTF-8'));
    }

    public function test_ensure_utf8_with_numeric_values()
    {
        $input = [
            'count' => 42,
            'price' => 99.99,
            'active' => true,
            'description' => 'Русский текст',
        ];

        $result = EncodingHelper::ensureUtf8($input);

        $this->assertIsArray($result);
        $this->assertEquals(42, $result['count']);
        $this->assertEquals(99.99, $result['price']);
        $this->assertTrue($result['active']);
        $this->assertEquals('Русский текст', $result['description']);
    }

    public function test_ensure_utf8_with_null_values()
    {
        $input = [
            'name' => 'Имя',
            'empty' => null,
            'text' => 'Текст',
        ];

        $result = EncodingHelper::ensureUtf8($input);

        $this->assertIsArray($result);
        $this->assertEquals('Имя', $result['name']);
        $this->assertNull($result['empty']);
        $this->assertEquals('Текст', $result['text']);
    }

    public function test_sanitize_for_html_with_special_characters()
    {
        $input = 'Test <script>alert("XSS")</script> with русский текст';
        $result = EncodingHelper::sanitizeForHtml($input);

        $this->assertIsString($result);
        $this->assertStringNotContainsString('<script>', $result);
        $this->assertStringContainsString('&lt;script&gt;', $result);
        $this->assertTrue(mb_check_encoding($result, 'UTF-8'));
    }

    public function test_sanitize_for_html_with_array()
    {
        $input = [
            'title' => 'Заголовок <b>с тегом</b>',
            'content' => 'Содержание с & символом',
        ];

        $result = EncodingHelper::sanitizeForHtml($input);

        $this->assertIsArray($result);
        $this->assertStringContainsString('&lt;b&gt;', $result['title']);
        $this->assertStringContainsString('&amp;', $result['content']);
    }

    public function test_ensure_utf8_preserves_encoding_for_already_utf8()
    {
        // Строка уже в UTF-8
        $input = 'Чебурашка';
        $result = EncodingHelper::ensureUtf8($input);

        $this->assertEquals('Чебурашка', $result);
        $this->assertTrue(mb_check_encoding($result, 'UTF-8'));
    }

    public function test_ensure_utf8_with_empty_array()
    {
        $input = [];
        $result = EncodingHelper::ensureUtf8($input);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function test_ensure_utf8_with_complex_structure()
    {
        $input = [
            'user' => [
                'name' => 'Иван Петров',
                'email' => 'ivan@example.com',
                'profile' => [
                    'bio' => 'Разработчик на PHP',
                    'location' => 'Москва, Россия',
                ],
            ],
            'posts' => [
                [
                    'title' => 'Первый пост',
                    'content' => 'Содержание поста',
                ],
                [
                    'title' => 'Второй пост',
                    'content' => 'Ещё одно содержание',
                ],
            ],
        ];

        $result = EncodingHelper::ensureUtf8($input);

        $this->assertIsArray($result);
        $this->assertEquals('Иван Петров', $result['user']['name']);
        $this->assertEquals('Разработчик на PHP', $result['user']['profile']['bio']);
        $this->assertEquals('Первый пост', $result['posts'][0]['title']);
        $this->assertEquals('Ещё одно содержание', $result['posts'][1]['content']);

        // Проверяем кодировку всех строк
        $this->assertTrue(mb_check_encoding($result['user']['name'], 'UTF-8'));
        $this->assertTrue(mb_check_encoding($result['user']['profile']['bio'], 'UTF-8'));
    }
}
