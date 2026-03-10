<div class="section page-break">

    <div class="section-title">2. Воронка вовлечённости</div>

    <p>
        Данный раздел анализирует поведенческую воронку взаимодействия пользователей с контентом.
        Показывает эффективность контента, глубину вовлеченности аудитории и как аудитория проходит
        последовательные этапы взаимодействия:
    </p>

    <ul>
        <li>просмотр публикации (ViewRate)</li>
        <li>реакция на публикацию (ReactionRate)</li>
        <li>участие в обсуждении (CommentRate)</li>
        <li>вовлеченность от просмотров (ERview)</li>
    </ul>

    <p>
        Общие данные за период {{ $periodStart ?? '****' }} – {{ $periodEnd ?? '****' }}:
        <br>Просмотры публикаций (ViewRate): <strong>{{ $avgViewRate ?? 0 }}</strong>
        <br>Реакции на публикации (ReactionRate): <strong>{{ $avgReactionRate ?? 0 }}</strong>
        <br>Участия в обсуждении (CommentRate): <strong>{{ $avgCommentRate ?? 0 }}</strong>
        <br>Вовлеченность от просмотров (ERview): <strong>{{ $avgERview ?? 0 }}</strong>
    </p>

</div>


{{-- 2.1 Просмотры --}}
<div class="section page-break">

    <div class="subsection-title">
        2.1 Просмотр публикаций (ViewRate)
    </div>

    <p>
        Метрика характеризует долю аудитории сообщества, которая фактически просматривает
        публикуемый контент. Показатель используется для оценки реального охвата публикаций
        и эффективности распространения контента внутри аудитории.
    </p>

    @if(!empty($viewRateChart))
        <div class="chart-container">
            <div class="chart-block-title">График просмотров публикаций</div>

            <img
                src="{{ $viewRateChart }}"
                style="width:100%; margin-top:10px;"
            >
        </div>
    @endif

    <p>
        Числовые значения метрики представлены в таблице №2.1
        «Просмотр публикаций (по публикациям)».
    </p>

</div>


{{-- 2.2 Реакции --}}
<div class="section page-break">

    <div class="subsection-title">
        2.2 Доля реакций (ReactionRate)
    </div>

    <p>
        Метрика отражает долю пользователей, просмотревших публикацию и поставивших реакцию на неё.
        Показатель позволяет определить, насколько контент стимулирует эмоциональные реакции аудитории.
    </p>

    @if(!empty($reactionRateChart))
        <div class="chart-container">
            <div class="chart-block-title">График реакций</div>

            <img
                src="{{ $reactionRateChart }}"
                style="width:100%; margin-top:10px;"
            >
        </div>
    @endif

    <p>
        Числовые значения метрики представлены в таблице №2.2
        «Доля реакций (по публикациям)».
    </p>

</div>


{{-- 2.3 Комментарии --}}
<div class="section page-break">

    <div class="subsection-title">
        2.3 Доля комментариев (CommentRate)
    </div>

    <p>
        Метрика показывает частоту перехода аудитории от пассивного просмотра контента
        к активному обсуждению публикаций.
    </p>

    @if(!empty($commentRateChart))
        <div class="chart-container">
            <div class="chart-block-title">График комментариев</div>

            <img
                src="{{ $commentRateChart }}"
                style="width:100%; margin-top:10px;"
            >
        </div>
    @endif

    <p>
        Числовые значения метрики представлены в таблице №2.3
        «Доля комментариев (по публикациям)».
    </p>

</div>


{{-- 2.4 Вовлеченность --}}
<div class="section page-break">

    <div class="subsection-title">
        2.4 Вовлеченность от просмотров (ERview)
    </div>

    <p>
        Метрика отражает долю пользователей, которые совершили действие
        (реакцию или комментарий) после просмотра публикации.
        Показатель позволяет оценить конверсию просмотров в активное взаимодействие.
    </p>

    @if(!empty($erViewChart))
        <div class="chart-container">
            <div class="chart-block-title">График вовлеченности</div>

            <img
                src="{{ $erViewChart }}"
                style="width:100%; margin-top:10px;"
            >
        </div>
    @endif

    <p>
        Числовые значения метрики представлены в таблице №2.4
        «Вовлеченность от просмотров (по публикациям)».
    </p>

</div>


{{-- Таблицы --}}
<div class="section page-break">

    <div class="section-title">
        Таблицы с числовыми значениями
    </div>

    @if(!empty($funnelByDay))

        <div class="chart-block-title">
            Таблица №2 «Воронка вовлечённости»
        </div>

        <table class="leaders-table">

            <thead>
                <tr>
                    <th>День</th>
                    <th>ViewRate</th>
                    <th>ReactionRate</th>
                    <th>CommentRate</th>
                    <th>ERview</th>
                </tr>
            </thead>

            <tbody>

                @foreach($funnelByDay as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ $row['total'] ?? 0 }}</td>
                        <td>{{ $row['reactionRate'] ?? 0 }}</td>
                        <td>{{ $row['commentRate'] ?? 0 }}</td>
                        <td>{{ $row['erView'] ?? 0 }}</td>
                    </tr>
                @endforeach

            </tbody>

        </table>

    @endif

</div>
