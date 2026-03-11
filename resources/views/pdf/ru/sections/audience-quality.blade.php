<div class="report-section page-break">

    <div class="report-section-title">3. Качество аудитории</div>

    <p>
        Раздел направлен на анализ структуры активности аудитории и выявление признаков искусственной или аномальной активности пользователей.
        Показатели позволяют оценить распределение ролей внутри сообщества, определить соотношение читателей и авторов контента,
        а также выявить возможные неестественные паттерны поведения аудитории.
        Числовые значения метрики отображены в конце отчета в таблице № 3 «Качество аудитории».
    </p>

    <p>
        Общая активность аудитории за период с {{ $periodStart ?? '****' }} по {{ $periodEnd ?? '****' }}:
    </p>

    <ul>
        <li>Доля пишущих от аудитории (WriterToMembers) – {{ $writerToMembers ?? 0 }} %</li>
        <li>Доля пишущих среди активных (WriterShare) – {{ $writerShare ?? 0 }} %</li>
    </ul>

    <p>
        Значения данных показателей свидетельствуют о структуре взаимодействия пользователей внутри сообщества
        и позволяют оценить степень вовлеченности аудитории в создание и обсуждение контента.
    </p>

    @if(!empty($writerToMembersAllChart))
        <div class="report-chart">
            <div class="report-chart-title">Структура аудитории (WriterToMembers)</div>
            <img src="{{ $writerToMembersAllChart }}" style="width:100%; margin-top:10px;">
            <div class="report-caption">Таблица №3 «Качество аудитории»</div>
        </div>
    @endif

    @if(!empty($writerToShareAllChart))
        <div class="report-chart">
            <div class="report-chart-title">Структура активной аудитории (WriterShare)</div>
            <img src="{{ $writerToShareAllChart }}" style="width:100%; margin-top:10px;">
            <div class="report-caption">Таблица №3 «Качество аудитории»</div>
        </div>
    @endif

    <div class="report-subsection-title">
        3.1 Доля пишущих от всей аудитории
    </div>

    <p>
        Метрика отражает долю пользователей, которые публикуют сообщения или комментарии
        относительно общего числа участников сообщества.
    </p>

    @if(!empty($writerToMembersChart))
        <div class="report-chart">
            <div class="report-chart-title">
                График доли пишущих от аудитории
            </div>

            <img src="{{ $writerToMembersChart }}" style="width:100%; margin-top:10px;">

            <div class="report-caption">
                Таблица №3.1 «Доля пишущих от аудитории»
            </div>
        </div>
    @endif

    <div class="report-subsection-title">
        3.2 Доля пишущих среди активных пользователей
    </div>

    <p>
        Метрика показывает долю пользователей, которые создают контент среди всех активных пользователей.
    </p>

    @if(!empty($writerShareChart))
        <div class="report-chart">
            <div class="report-chart-title">
                График доли пишущих среди активных
            </div>

            <img src="{{ $writerShareChart }}" style="width:100%; margin-top:10px;">

            <div class="report-caption">
                Таблица №3.2 «Доля пишущих среди активных»
            </div>
        </div>
    @endif

    <div class="report-subsection-title">
        3.3 Индекс временных всплесков (по дням)
    </div>

    <p>
        Метрика предназначена для выявления неестественных всплесков активности пользователей во времени.
        Анализ выполняется на основе распределения активности пользователей по дням.
    </p>

    @if(!empty($timeBurstIndexChart))
        <div class="report-chart">
            <div class="report-chart-title">
                График индекса временных всплесков
            </div>

            <img src="{{ $timeBurstIndexChart }}" style="width:100%; margin-top:10px;">

            <div class="report-caption">
                Таблица №3.3 «Индекс временных всплесков»
            </div>
        </div>
    @endif

</div>


<div class="report-section page-break">

    <div class="report-section-title">
        Таблицы с числовыми значениями
    </div>

    <div class="report-chart-title">
        Таблица №3 «Качество аудитории»
    </div>
    <table class="report-table">
        <thead>
            <tr>
                <th>WriterToMembers</th>
                <th>WriterShare</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $writerToMembers ?? 0 }}</td>
                <td>{{ $writerShare ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

    <div class="report-chart-title">
        Таблица №3.1 «Доля пишущих от аудитории»
    </div>
    <table class="report-table">
        <thead>
            <tr>
                <th>День</th>
                <th>WriterToMembers</th>
            </tr>
        </thead>
        <tbody>
            @foreach($writerToMembersByDay ?? [] as $row)
                <tr>
                    <td>{{ $row['day'] }}</td>
                    <td>{{ $row['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="report-chart-title">
        Таблица №3.2 «Доля пишущих среди активных»
    </div>
    <table class="report-table">
        <thead>
            <tr>
                <th>День</th>
                <th>WriterShare</th>
            </tr>
        </thead>
        <tbody>
            @foreach($writerShareByDay ?? [] as $row)
                <tr>
                    <td>{{ $row['day'] }}</td>
                    <td>{{ $row['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="report-chart-title">
        Таблица №3.3 «Индекс временных всплесков»
    </div>
    <table class="report-table">
        <thead>
            <tr>
                <th>День</th>
                <th>TimeBurstIndex</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timeBurstIndexByDay ?? [] as $row)
                <tr>
                    <td>{{ $row['day'] }}</td>
                    <td>{{ $row['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
