<div class="section page-break">

    <div class="section-title">2. Воронка вовлечённости</div>

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


{{-- 2.1 --}}
<div class="section page-break">

<div class="subsection-title">2.1 Просмотр публикаций (по дням)</div>

<p><strong>(ViewRate)</strong></p>

@if(!empty($viewRateChart))
<div class="chart-container">
<div class="chart-block-title">График ViewRate</div>
<img src="{{ $viewRateChart }}" style="width:100%; margin-top:10px;">
</div>
@endif

</div>


{{-- 2.2 --}}
<div class="section page-break">

<div class="subsection-title">2.2 Доля реакций (по дням)</div>

<p><strong>(ReactionRate)</strong></p>

@if(!empty($reactionRateChart))
<div class="chart-container">
<div class="chart-block-title">График ReactionRate</div>
<img src="{{ $reactionRateChart }}" style="width:100%; margin-top:10px;">
</div>
@endif

</div>


{{-- 2.3 --}}
<div class="section page-break">

<div class="subsection-title">2.3 Доля комментариев (по дням)</div>

<p><strong>(CommentRate)</strong></p>

@if(!empty($commentRateChart))
<div class="chart-container">
<div class="chart-block-title">График CommentRate</div>
<img src="{{ $commentRateChart }}" style="width:100%; margin-top:10px;">
</div>
@endif

</div>


{{-- 2.4 --}}
<div class="section page-break">

<div class="subsection-title">2.4 Вовлеченность от просмотров</div>

<p><strong>(ERview)</strong></p>

@if(!empty($erViewChart))
<div class="chart-container">
<div class="chart-block-title">График ERview</div>
<img src="{{ $erViewChart }}" style="width:100%; margin-top:10px;">
</div>
@endif

</div>


{{-- Таблица --}}
<div class="section page-break">

<div class="section-title">Таблица 2. Воронка вовлечённости по дням</div>

@if(is_array($funnelByDay) && count($funnelByDay))

<table class="leaders-table">

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
