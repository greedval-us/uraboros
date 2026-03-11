<div class="report-section page-break">

    <div class="report-section-title">3. Качество аудитории</div>

    <p>
        Раздел направлен на анализ структуры активности аудитории и выявление признаков искусственной
        или аномальной активности пользователей. Показатели позволяют оценить распределение ролей внутри
        сообщества, определить соотношение читателей и авторов контента, а также выявить возможные
        неестественные паттерны поведения аудитории.
    </p>

    <p>
        Числовые значения метрики по сообщениям отображены в конце отчета
        в таблице №3 «Качество аудитории».
    </p>

    <p>
        Общая активность аудитории за период
        с {{ $periodStart ?? '****' }} по {{ $periodEnd ?? '****' }}:
    </p>

    <ul>
        <li>Доля пишущих от аудитории (WriterToMembers) – {{ $writerToMembers ?? 0 }} %</li>
        <li>Доля пишущих среди активных (WriterShare) – {{ $writerShare ?? 0 }} %</li>
    </ul>

    <p>
        Значения данных показателей свидетельствуют о структуре взаимодействия пользователей
        внутри сообщества и позволяют оценить степень вовлеченности аудитории
        в создание и обсуждение контента.
    </p>

    @if(!empty($writerToMembersAllChart))
        <div class="report-chart">
            <div class="report-chart-title">Структура аудитории (WriterToMembers)</div>
            <img src="{{ $writerToMembersAllChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    @if(!empty($writerToShareAllChart))
        <div class="report-chart">
            <div class="report-chart-title">Структура активной аудитории (WriterShare)</div>
            <img src="{{ $writerToShareAllChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

</div>


<div class="report-section page-break">

    <div class="report-subsection-title">
        3.1 Доля пишущих от всей аудитории (WriterToMembers)
    </div>

    <p>
        Метрика отражает долю пользователей, которые публикуют сообщения
        или комментарии относительно общего числа участников сообщества.
    </p>

    <p>Показатель используется для оценки:</p>

    <ul>
        <li>уровня вовлеченности аудитории в создание контента</li>
        <li>доли пользователей, участвующих в обсуждениях</li>
        <li>соотношения активных авторов и пассивных читателей</li>
    </ul>

    <p>
        Числовые значения метрики по сообщениям отображены
        в конце отчета в таблице №3.1 «Доля пишущих от аудитории».
    </p>

    <p>Значения показателя могут свидетельствовать о:</p>

    <ul>
        <li>высокой вовлеченности аудитории при значительной доле пользователей, участвующих в обсуждениях</li>
        <li>преобладании пассивного потребления контента при низких значениях показателя</li>
        <li>особенностях формата сообщества (информационный канал, дискуссионная группа и др.)</li>
    </ul>

    @if(!empty($writerToMembersChart))
        <div class="report-chart">
            <div class="report-chart-title">
                График доли пишущих от аудитории
            </div>

            <img src="{{ $writerToMembersChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

</div>


<div class="report-section page-break">

    <div class="report-subsection-title">
        3.2 Доля пишущих среди активных пользователей (WriterShare)
    </div>

    <p>
        Метрика показывает долю пользователей, которые создают контент
        (пишут сообщения или комментарии) среди всех активных пользователей.
    </p>

    <p>
        Показатель позволяет определить структуру активности аудитории
        и баланс между пользователями, потребляющими контент,
        и пользователями, участвующими в его создании.
    </p>

    <p>
        Числовые значения метрики по сообщениям отображены
        в конце отчета в таблице №3.2 «Доля пишущих среди активных».
    </p>

    <p>Значения показателя свидетельствуют о:</p>

    <ul>
        <li>структуре распределения активности пользователей внутри сообщества</li>
        <li>степени вовлеченности активной аудитории в обсуждение контента</li>
        <li>сформированной модели взаимодействия пользователей при стабильных значениях показателя</li>
        <li>возможных всплесках активности отдельных пользователей при значительных отклонениях</li>
    </ul>

    @if(!empty($writerShareChart))
        <div class="report-chart">
            <div class="report-chart-title">
                График доли пишущих среди активных
            </div>

            <img src="{{ $writerShareChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

</div>


<div class="report-section page-break">

    <div class="report-subsection-title">
        3.3 Индекс временных всплесков (TimeBurstIndex)
    </div>

    <p>
        Метрика предназначена для выявления неестественных всплесков активности
        пользователей во времени. Анализ выполняется на основе распределения
        активности пользователей по дням.
    </p>

    <p>
        Показатель позволяет выявить аномальные концентрации активности,
        нехарактерные для естественного поведения аудитории.
    </p>

    <p>
        Числовые значения метрики по сообщениям отображены
        в конце отчета в таблице №3.3 «Индекс временных всплесков».
    </p>

    <p>Подобные всплески могут свидетельствовать о:</p>

    <ul>
        <li>массовых автоматизированных действиях пользователей</li>
        <li>использовании ботов или автоматических скриптов</li>
        <li>искусственном увеличении активности пользователей</li>
        <li>координированных действиях группы аккаунтов</li>
    </ul>

    @if(!empty($timeBurstIndexChart))
        <div class="report-chart">
            <div class="report-chart-title">
                График индекса временных всплесков
            </div>

            <img src="{{ $timeBurstIndexChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

</div>


<div class="report-section page-break">

    <div class="report-section-title">
        Таблицы с числовыми значениями
    </div>
    <div class="report-table-title">
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
</div>

<div class="report-section page-break">

    <div class="report-table-title">
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

</div>


<div class="report-section page-break">

    <div class="report-table-title">
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

</div>


<div class="report-section page-break">

    <div class="report-table-title">
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
