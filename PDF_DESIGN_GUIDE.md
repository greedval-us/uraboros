# 📄 Руководство по дизайну PDF отчетов

## Обзор

Система стилей для PDF отчетов обеспечивает профессиональный, современный и читаемый дизайн с полной поддержкой красивого отображения в PDF.

---

## 🎨 Основные компоненты

### 1. **Document Header** (Шапка документа)
Красивый заголовок с градиентом на странице отчета.

```html
<div class="document-header">
    <div class="header-top">
        <div style="flex: 1;">
            <div class="header-title">Название отчета</div>
            <div class="header-subtitle">Подзаголовок</div>
        </div>
        <div style="text-align: right; font-size: 12px; font-weight: 500;">
            📊 ОТЧЕТ
        </div>
    </div>

    <table class="header-meta">
        <tr>
            <td style="width: 50%;">
                <span style="opacity: 0.8; display: block; font-size: 9px; margin-bottom: 2px;">ПЕРИОД</span>
                <span class="header-period">{{ $periodStart }} — {{ $periodEnd }}</span>
            </td>
            <td style="width: 50%;">
                <span style="opacity: 0.8; display: block; font-size: 9px; margin-bottom: 2px;">ДАТА</span>
                <span class="header-date">{{ now()->format('d.m.Y') }}</span>
            </td>
        </tr>
    </table>
</div>
```

---

### 2. **Report Section** (Основной раздел)
Основная единица содержания с белым фоном и тонкой тенью.

```html
<div class="report-section">
    <div class="report-section-title">1. Название раздела</div>

    <p>Описание раздела...</p>

    <!-- Содержание раздела -->
</div>
```

---

### 3. **Section Titles** (Заголовки разделов)

#### Основной заголовок
```html
<div class="report-section-title">1. Название основного раздела</div>
```

#### Подзаголовок
```html
<div class="report-subsection-title">1.1 Название подраздела</div>
```

---

### 4. **Metrics Box** (Блок с метриками)
Красивый блок для отображения числовых данных.

```html
<div class="metrics-box">
    <div style="font-weight: 700; color: #1f2937; margin-bottom: 12px;">
        Общие данные за период
    </div>

    <div class="metric-row">
        <span class="metric-label">Ключевой показатель</span>
        <span class="metric-value">{{ $value }}</span>
    </div>

    <div class="metric-row">
        <span class="metric-label">Другой показатель</span>
        <span class="metric-value">{{ $anotherValue }}</span>
    </div>
</div>
```

**Стили:**
- `metric-label` — название метрики (серый цвет, 500px вес)
- `metric-value` — значение (черный цвет, 700px вес)
- Пунктирная линия между строками

---

### 5. **Charts** (Диаграммы и графики)
Контейнер для изображений диаграмм.

```html
<div class="report-chart">
    <div class="report-chart-title">📊 Название диаграммы</div>
    <img src="{{ $chartImage }}" style="width:100%; margin-top:10px;">
</div>
```

**Рекомендациями для диаграмм:**
- Первая диаграмма раздела: `📊`
- Второй и последующие: `📈`, `📉` или специфичные иконки
- Высокое разрешение (минимум 300 DPI)
- Поддерживаемые форматы: PNG, JPG

---

### 6. **Tables** (Таблицы)
Красивые таблицы с чередующимся цветом строк.

```html
<div class="report-table-title">Таблица №1 — Название таблицы</div>

<table class="report-table">
    <thead>
        <tr>
            <th>Колонка 1</th>
            <th>Колонка 2</th>
            <th>Колонка 3</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
            <tr>
                <td>{{ $row['col1'] }}</td>
                <td>{{ $row['col2'] }}</td>
                <td>{{ $row['col3'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
```

**Особенности:**
- Синий градиент для заголовков
- Чередующиеся цвета строк (белый/серый)
- Синяя нижняя граница в конце таблицы

---

### 7. **Badges** (Значки/Метки)
Для выделения статусов или категорий.

```html
<span class="badge">Info</span>
<span class="badge success">✓ Success</span>
<span class="badge warning">⚠ Warning</span>
<span class="badge danger">✗ Error</span>
```

---

### 8. **Note Box** (Информационный блок)
Для важных замечаний и примечаний.

```html
<p style="margin-top: 15px; padding: 12px; background-color: #f0f9ff;
    border-left: 4px solid #0ea5e9; border-radius: 4px;">
    💡 <strong>Примечание:</strong> Текст примечания...
</p>
```

---

### 9. **Page Break** (Разрыв страницы)
Для начала нового раздела на новой странице.

```html
<div class="report-section page-break">
    <!-- Содержание следующей страницы -->
</div>
```

---

### 10. **Footer** (Подвал)
Финальная информация в конце отчета.

```html
<div class="report-section-footer">
    <div class="footer-date">
        <strong>{{ config('app.name') }}</strong> • Аналитический отчет
    </div>
    <div style="margin-top: 8px; line-height: 1.8; opacity: 0.8; font-size: 9px;">
        Документ создан: {{ now()->format('d.m.Y в H:i') }}<br>
        Этот отчет содержит конфиденциальную информацию.<br>
        © {{ now()->year }} Все права защищены.
    </div>
</div>
```

---

## 🎨 Цветовая схема

| Элемент | Цвет | Hex код |
|---------|------|---------|
| Основной цвет | Синий | `#1e3a8a` |
| Акцент | Голубой | `#3b82f6` |
| Текст основной | Серый | `#374151` |
| Текст заголовков | Черный | `#111827` |
| Фон разделов | Белый | `#ffffff` |
| Фон примечаний | Голубой light | `#f0f9ff` |
| Граница | Серый light | `#e5e7eb` |

---

## 📏 Типография

```
Font Family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'DejaVu Sans'
Base Font Size: 11px
Line Height: 1.6

Заголовки разделов: 18px, 700 weight
Подзаголовки: 13px, 700 weight
Подписи к диаграммам: 12px, 700 weight
Текст основной: 11px, 400 weight
Footer: 10px, 400 weight
```

---

## 📋 Примеры использования

### Пример 1: Простой раздел с метриками

```html
<div class="report-section">
    <div class="report-section-title">Основные показатели</div>

    <p>Ключевые метрики работы системы за анализируемый период.</p>

    <div class="metrics-box">
        <div style="font-weight: 700; color: #1f2937; margin-bottom: 12px;">
            Статистика
        </div>
        <div class="metric-row">
            <span class="metric-label">Всего пользователей</span>
            <span class="metric-value">1,234</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Активных пользователей</span>
            <span class="metric-value">789</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Процент активности</span>
            <span class="metric-value">64%</span>
        </div>
    </div>
</div>
```

### Пример 2: Раздел с диаграммой и таблицей

```html
<div class="report-section page-break">
    <div class="report-section-title">Анализ динамики</div>

    <div class="report-subsection-title">Визуализация</div>

    <div class="report-chart">
        <div class="report-chart-title">📈 График роста</div>
        <img src="{{ $growthChart }}" style="width:100%; margin-top:10px;">
    </div>

    <div class="report-subsection-title">Детальные данные</div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Период</th>
                <th>Значение</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Январь</td>
                <td>1,200</td>
            </tr>
            <tr>
                <td>Февраль</td>
                <td>1,450</td>
            </tr>
        </tbody>
    </table>
</div>
```

---

## ⚙️ Оптимизация для PDF

### Важные правила:

1. **Размеры изображений**
   - Максимальная ширина: 100% (приспосабливается к ширине страницы)
   - DPI: 300+ для четкого отображения
   - Формат: PNG (без потерь) или качественный JPG

2. **Разрывы страниц**
   - Используйте класс `page-break` перед крупными разделами
   - Не давайте разбивать таблицы через разрыв стр.

3. **Шрифты**
   - Используются стандартные системные шрифты (поддержка во всех ОС)
   - DejaVu для кириллицы (поддерживается в DOMPDF)

4. **Печать**
   - Документы оптимизированы для печати
   - Идеально подходят для А4 формата

---

## 🚀 Применение стилей

Все стили определены в `resources/views/pdf/layout.blade.php` в теге `<style>`.

При добавлении нового раздела просто используйте правильные классы CSS:
- `.report-section` — основной контейнер раздела
- `.report-section-title` — заголовок раздела
- `.report-subsection-title` — подзаголовок
- `.metrics-box` — блок метрик
- `.report-chart` — диаграмма
- `.report-table` — таблица

И они автоматически получат профессиональный стиль! ✨

---

## 📝 Рекомендации

✅ **Делайте:**
- Используйте эмодзи в заголовках диаграмм
- Добавляйте примечания для важной информации
- Разбивайте большие разделы на подразделы
- Используйте таблицы для детальных данных

❌ **Избегайте:**
- Слишком много текста без разделения
- Маленькие диаграммы (минимум 400px ширина)
- Яркие цвета без необходимости
- Переполнение информацией на одной странице

---

## 📞 Поддержка

При возникновении проблем с отображением:
1. Проверьте наличие всех необходимых данных
2. Убедитесь в верности пути к изображениям
3. Проверьте кодировку (UTF-8)
4. Используйте DOMPDF версии 2.0+

**Созданий:** 2024
**Версия:** 1.0
