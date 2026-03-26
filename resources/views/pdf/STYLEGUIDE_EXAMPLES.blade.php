<!-- ============================================================================
     СПРАВКА ПО СТИЛЯМ PDF ОТЧЕТОВ
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
        <div class="metrics-box-title">Общие данные</div>
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
        <div class="report-chart-title">Название диаграммы</div>
        <img src="{{ $chartPath }}" style="width:100%;">
    </div>
</div>


<!-- 4. РАЗДЕЛ С ТАБЛИЦЕЙ -->
<div class="report-section">
    <div class="report-section-title">Детальные данные</div>

    <div class="report-table-title">Таблица 1 - Название</div>
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

    <div class="note-box">
        <strong>Примечание:</strong> Важная информация для пользователя.
    </div>
</div>


<!-- 7. КОМБИНИРОВАННЫЙ РАЗДЕЛ -->
<div class="report-section page-break">
    <div class="report-section-title">3. Полный анализ</div>

    <p>Описание раздела...</p>

    <!-- Диаграмма -->
    <div class="report-chart">
        <div class="report-chart-title">Траектория развития</div>
        <img src="{{ $chartImage }}" style="width:100%;">
    </div>

    <!-- Метрики -->
    <div class="metrics-box">
        <div class="metrics-box-title">Итоговые показатели</div>
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

    <!-- Подзаголовок -->
    <div class="report-subsection-title">3.1 Детальный анализ</div>

    <!-- Таблица -->
    <div class="report-table-title">Таблица 3 - Дневные значения</div>
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


<!-- ЛУЧШИЕ ПРАКТИКИ:

1. ВСЕГДА используйте .report-section для основных блоков
2. НАЗНАЧАЙТЕ заголовок каждому разделу с .report-section-title
3. ДЛЯ больших разделов используйте .page-break
4. МЕТРИКИ оформляйте в .metrics-box с .metrics-box-title
5. ДИАГРАММЫ помещайте в .report-chart
6. ТАБЛИЦЫ оформляйте с .report-table-title
7. ПРИМЕЧАНИЯ оформляйте через .note-box
8. НЕ используйте inline стили

ШРИФТЫ:
- Основной шрифт: DejaVu Sans (поддержка кириллицы)
- Моноширинный: DejaVu Sans Mono

ПРОВЕРКА:
- Все тексты на кириллице отображаются правильно
- Разрывы страниц на нужных местах
- Таблицы не разбиваются через страницы
-->
