<div class="section page-break">

    <div class="section-title">3. Качество аудитории</div>

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

    {{-- ===== Круговые графики общей структуры ===== --}}

    @if(!empty($writerToMembersAllChart))
        <div class="chart-container">
            <div class="chart-block-title">Структура аудитории (WriterToMembers)</div>
            <img src="{{ $writerToMembersAllChart }}" style="width:100%; margin-top:10px;">
            <div class="mini-description">Таблица № 3 «Качество аудитории»</div>
        </div>
    @endif

    @if(!empty($writerToShareAllChart))
        <div class="chart-container">
            <div class="chart-block-title">Структура активной аудитории (WriterShare)</div>
            <img src="{{ $writerToShareAllChart }}" style="width:100%; margin-top:10px;">
            <div class="mini-description">Таблица № 3 «Качество аудитории»</div>
        </div>
    @endif


    {{-- 3.1 Доля пишущих от всей аудитории --}}
    <div class="subsection-title">3.1 Доля пишущих от всей аудитории (WriterToMembers)</div>

    <p>
        Метрика отражает долю пользователей, которые публикуют сообщения или комментарии относительно общего числа участников сообщества.
        Показатель используется для оценки:
    </p>

    <ul>
        <li>уровня вовлеченности аудитории в создание контента;</li>
        <li>доли пользователей, участвующих в обсуждениях;</li>
        <li>соотношения активных авторов и пассивных читателей.</li>
    </ul>

    @if(!empty($writerToMembersChart))
        <div class="chart-container">
            <div class="chart-block-title">График доли пишущих от аудитории</div>
            <img src="{{ $writerToMembersChart }}" style="width:100%; margin-top:10px;">
            <div class="mini-description">Таблица № 3.1 «Доля пишущих от аудитории»</div>
        </div>
    @endif


    {{-- 3.2 Доля пишущих среди активных --}}
    <div class="subsection-title">3.2 Доля пишущих среди активных пользователей (WriterShare)</div>

    <p>
        Метрика показывает долю пользователей, которые создают контент среди всех активных пользователей.
        Показатель позволяет определить структуру активности аудитории и баланс между пользователями,
        потребляющими контент, и пользователями, участвующими в его создании.
    </p>

    @if(!empty($writerShareChart))
        <div class="chart-container">
            <div class="chart-block-title">График доли пишущих среди активных</div>
            <img src="{{ $writerShareChart }}" style="width:100%; margin-top:10px;">
            <div class="mini-description">Таблица № 3.2 «Доля пишущих среди активных»</div>
        </div>
    @endif


    {{-- 3.3 Индекс временных всплесков --}}
    <div class="subsection-title">3.3 Индекс временных всплесков (TimeBurstIndex)</div>

    <p>
        Метрика предназначена для выявления неестественных всплесков активности пользователей во времени.
        Анализ выполняется на основе распределения активности пользователей по дням.
        Показатель позволяет выявить аномальные концентрации активности,
        нехарактерные для естественного поведения аудитории.
    </p>

    @if(!empty($timeBurstIndexChart))
        <div class="chart-container">
            <div class="chart-block-title">График индекса временных всплесков</div>
            <img src="{{ $timeBurstIndexChart }}" style="width:100%; margin-top:10px;">
            <div class="mini-description">Таблица № 3.3 «Индекс временных всплесков»</div>
        </div>
    @endif


    {{-- ===== Все таблицы в конце секции ===== --}}
    <div class="section page-break">

        <div class="section-title">Таблицы с числовыми значениями</div>

        {{-- Таблица 3 --}}
        <div class="chart-block-title">Таблица № 3 «Качество аудитории»</div>

        <table class="leaders-table">
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


        {{-- Таблица 3.1 --}}
        <div class="chart-block-title">Таблица № 3.1 «Доля пишущих от аудитории»</div>

        <table class="leaders-table">
            <thead>
                <tr>
                    <th>День</th>
                    <th>WriterToMembers</th>
                </tr>
            </thead>
            <tbody>
                @foreach($writerToMembersByDay as $day => $value)
                    <tr>
                        <td>{{ $day }}</td>
                        <td>{{ $value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        {{-- Таблица 3.2 --}}
        <div class="chart-block-title">Таблица № 3.2 «Доля пишущих среди активных»</div>

        <table class="leaders-table">
            <thead>
                <tr>
                    <th>День</th>
                    <th>WriterShare</th>
                </tr>
            </thead>
            <tbody>
                @foreach($writerShareByDay as $day => $value)
                    <tr>
                        <td>{{ $day }}</td>
                        <td>{{ $value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        {{-- Таблица 3.3 --}}
        <div class="chart-block-title">Таблица № 3.3 «Индекс временных всплесков»</div>

        <table class="leaders-table">
            <thead>
                <tr>
                    <th>День</th>
                    <th>TimeBurstIndex</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timeBurstIndexByDay as $day => $value)
                    <tr>
                        <td>{{ $day }}</td>
                        <td>{{ $value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>
