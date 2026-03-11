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

    @if(!empty($funnelByDay))
        <div class="report-chart">
            <div class="report-chart-title">Воронка вовлечённости</div>
            <img src="{{ $funnelByDay }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <ul>
        <li>общее количество просмотра публикаций (ViewRate) – <strong>{{ $avgViewRate ?? 0 }}</strong></li>
        <li>среднее количество реакций на публикации (ReactionRate) – <strong>{{ $avgReactionRate ?? 0 }}</strong></li>
        <li>среднее количество участий в обсуждении (CommentRate) – <strong>{{ $avgCommentRate ?? 0 }}</strong></li>
        <li>общий охват просмотров (ERview) – <strong>{{ $avgERview ?? 0 }}</strong></li>
    </ul>

</div>

