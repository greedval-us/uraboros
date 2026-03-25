<!-- ============================================================================
     КРАТКАЯ СПРАВКА ПО СТИЛЯМ PDF ОТЧЕТОВ
     Используйте эти готовые примеры при создании новых разделов
     ============================================================================ -->

<!-- 1. БАЗОВЫЙ РАЗДЕЛ С ЗАГОЛОВКОМ -->
<div class="report-section">
    <div class="report-section-title">Название раздела</div>
    <p>Текст содержания раздела...</p>
</div>


<!-- 2. РАЗДЕЛ С МЕТРИКАМИ -->
<div class="report-section">
    <div class="report-section-title">Ключевые показатели</div>

    <div class="metrics-box">
        <div style="font-weight: 700; color: #1f2937; margin-bottom: 12px;">
            Общие данные
        </div>
        <div class="metric-row">
            <span class="metric-label">Показатель 1</span>
            <span class="metric-value">123</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Показатель 2</span>
            <span class="metric-value">456</span>
        </div>
    </div>
</div>


<!-- 3. РАЗДЕЛ С ДИАГРАММОЙ -->
<div class="report-section">
    <div class="report-section-title">Анализ динамики</div>

    <div class="report-chart">
        <div class="report-chart-title">📊 Названием диаграммы</div>
        <img src="{{ $chartPath }}" style="width:100%; margin-top:10px;">
    </div>
</div>


<!-- 4. РАЗДЕЛ С ТАБЛИЦЕЙ -->
<div class="report-section">
    <div class="report-section-title">Детальные данные</div>

    <div class="report-table-title">Таблица №1 — Название</div>
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
</div>


<!-- 5. РАЗДЕЛ НА НОВОЙ СТРАНИЦЕ С ПОДЗАГОЛОВКАМИ -->
<div class="report-section page-break">
    <div class="report-section-title">Новый раздел</div>

    <div class="report-subsection-title">2.1 Подраздел</div>
    <p>Текст подраздела...</p>

    <div class="report-subsection-title">2.2 Другой подраздел</div>
    <p>Текст другого подраздела...</p>
</div>


<!-- 6. РАЗДЕЛ С ПРИМЕЧАНИЕМ -->
<div class="report-section">
    <div class="report-section-title">Важно</div>

    <p>Основной текст...</p>

    <p style="margin-top: 15px; padding: 12px; background-color: #f0f9ff;
        border-left: 4px solid #0ea5e9; border-radius: 4px;">
        💡 <strong>Примечание:</strong> Важная информация для пользователя.
    </p>
</div>


<!-- 7. КОМБИНИРОВАННЫЙ РАЗДЕЛ (ДИАГРАММА + МЕТРИКИ + ТАБЛИЦА) -->
<div class="report-section page-break">
    <div class="report-section-title">3. Полный анализ</div>

    <p>Описание раздела...</p>

    <!-- Диаграмма -->
    <div class="report-chart">
        <div class="report-chart-title">📈 Траектория развития</div>
        <img src="{{ $chartImage }}" style="width:100%; margin-top:10px;">
    </div>

    <!-- Метрики -->
    <div class="metrics-box">
        <div style="font-weight: 700; color: #1f2937; margin-bottom: 12px;">
            Итоговые показатели
        </div>
        <div class="metric-row">
            <span class="metric-label">Минимум</span>
            <span class="metric-value">15</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Максимум</span>
            <span class="metric-value">87</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Среднее</span>
            <span class="metric-value">51</span>
        </div>
    </div>

    <!-- Подзаголовок для следующей части -->
    <div class="report-subsection-title">3.1 Детальный анализ</div>

    <!-- Таблица -->
    <div class="report-table-title">Таблица №3 — Дневные значения</div>
    <table class="report-table">
        <thead>
            <tr>
                <th>День</th>
                <th>Значение</th>
                <th>Изменение</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyData as $row)
                <tr>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['value'] }}</td>
                    <td>{{ $row['change'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- 8. ПРИМЕРЫ ИКОНОК ДЛЯ ДИАГРАММ -->
📊 Общая статистика / Диаграмма
📈 График роста / Восходящая тенденция
📉 График падения / Нисходящая тенденция
📋 Отчет / Список
⚠️ Важное предупреждение
💡 Совет / Примечание
✅ Успех / Завершено
❌ Ошибка / Проблема
🔍 Анализ / Исследование
👥 Пользователи / Аудитория
💰 Финансы / Бюджет
🎯 Цели / Задачи
📱 Мобильное
🖥️ Десктоп
🌐 Веб
📲 Приложение


<!-- ЛУЧШИЕ ПРАКТИКИ:

1. ВСЕГДА используйте .report-section для основных блоков
2. НАЗНАЧЬТЕ заголовок каждому разделу с .report-section-title
3. ДЛЯ больших разделов используйте .page-break
4. МЕТРИКИ оформляйте в .metrics-box
5. ДИАГРАММЫ помещайте в .report-chart с иконкой в заголовке
6. ТАБЛИЦЫ оформляйте правильно с .report-table-title
7. ПРИМЕЧАНИЯ/ВАЖНОЕ оформляйте голубым блоком
8. НЕ используйте встроенные стили, кроме как в исключениях

ПРОВЕРКА:
✓ Все тексты на кириллице отображаются правильно
✓ Изображения высокого разрешения (300+ DPI)
✓ Разрывы страниц на нужных местах
✓ Таблицы не разбиваются через страницы
✓ Цвета печатаются корректно в B&W режиме
-->
