<div class="report-section page-break">

    <div class="report-section-title">2. Воронка вовлечённости</div>

    <p>
        участники → просмотры → реакции → комментарии <br>
        (ViewRate, ReactionRate, CommentRate, ERview)
    </p>

    <p>
        Данный раздел анализирует поведенческую воронку взаимодействия пользователей с контентом.
        Показывает эффективность контента, глубину вовлеченности аудитории и как аудитория проходит
        последовательные этапы взаимодействия:
    </p>

    <ol>
        <li>просмотр публикации (ViewRate)</li>
        <li>реакция на публикацию (ReactionRate)</li>
        <li>участие в обсуждении (CommentRate)</li>
        <li>охват просмотров (ERview)</li>
    </ol>

    <p>
        Общие данные за период с {{ $periodStart ?? '****' }} по {{ $periodEnd ?? '****' }}:
    </p>

    <ul>
        <li>общее количество просмотра публикаций (ViewRate) – <strong>{{ $avgViewRate ?? 0 }}</strong></li>
        <li>среднее количество реакций на публикации (ReactionRate) – <strong>{{ $avgReactionRate ?? 0 }}</strong></li>
        <li>среднее количество участий в обсуждении (CommentRate) – <strong>{{ $avgCommentRate ?? 0 }}</strong></li>
        <li>общий охват просмотров (ERview) – <strong>{{ $avgERview ?? 0 }}</strong></li>
    </ul>

</div>

{{-- 2.1 Просмотр публикаций --}}
<div class="report-section page-break">
    <div class="report-subsection-title">2.1 Просмотр публикаций (по публикациям)</div>
    <p><strong>(ViewRate)</strong></p>

    <p>
        Метрика характеризует долю аудитории сообщества, которая фактически просматривает публикуемый контент.
        Показатель используется для оценки:
        реального охвата публикаций, эффективности распространения контента внутри аудитории.
        Резкий, пиковый рост или спад просмотров может свидетельствовать о изменении интереса аудитории.
    </p>

    @if(!empty($viewRateChart))
        <div class="report-chart">
            <div class="report-chart-title">График ViewRate</div>
            <img src="{{ $viewRateChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif
</div>

{{-- 2.2 Доля реакций --}}
<div class="report-section page-break">
    <div class="report-subsection-title">2.2 Доля реакций (по публикациям)</div>
    <p><strong>(ReactionRate)</strong></p>

    <p>
        Метрика отражает долю пользователей, просмотревших публикацию и поставивших реакцию на нее.
        Показатель позволяет определить, насколько контент стимулирует быстрые эмоциональные реакции аудитории.
    </p>

    @if(!empty($reactionRateChart))
        <div class="report-chart">
            <div class="report-chart-title">График ReactionRate</div>
            <img src="{{ $reactionRateChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif
</div>

{{-- 2.3 Доля комментариев --}}
<div class="report-section page-break">
    <div class="report-subsection-title">2.3 Доля комментариев (по публикациям)</div>
    <p><strong>(CommentRate)</strong></p>

    <p>
        Метрика показывает частоту перехода аудитории от пассивного просмотра контента к активному обсуждению.
        Показатель позволяет оценить дискуссионность контента и вовлеченность аудитории.
    </p>

    @if(!empty($commentRateChart))
        <div class="report-chart">
            <div class="report-chart-title">График CommentRate</div>
            <img src="{{ $commentRateChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif
</div>

{{-- 2.4 Вовлеченность от просмотров --}}
<div class="report-section page-break">
    <div class="report-subsection-title">2.4 Вовлеченность от просмотров</div>
    <p><strong>(ERview)</strong></p>

    <p>
        Метрика отражает долю пользователей, которые совершили действие (реакцию или комментарий) после просмотра публикации.
        Показатель позволяет оценить конверсию просмотров в активное взаимодействие.
    </p>

    @if(!empty($erViewChart))
        <div class="report-chart">
            <div class="report-chart-title">График ERview</div>
            <img src="{{ $erViewChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif
</div>

{{-- Таблицы по дням --}}
<div class="report-section page-break">
    <div class="report-section-title">Таблица 2. Воронка вовлечённости по дням</div>

    @if(is_array($funnelByDay) && count($funnelByDay))
        <table class="report-table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>ViewRate</th>
                    <th>ReactionRate</th>
                    <th>CommentRate</th>
                    <th>ERview</th>
                </tr>
            </thead>
            <tbody>
                @foreach($funnelByDay as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '-' }}</td>
                        <td>{{ $row['viewRate'] ?? 0 }}</td>
                        <td>{{ $row['reactionRate'] ?? 0 }}</td>
                        <td>{{ $row['commentRate'] ?? 0 }}</td>
                        <td>{{ $row['erView'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
