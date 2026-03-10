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

<div class="subsection-title">2.1 Просмотр публикаций (по публикациям)</div>

<p><strong>(ViewRate)</strong></p>

<p>
Метрика характеризует долю аудитории сообщества, которая фактически просматривает публикуемый контент.
</p>

<p>Показатель используется для оценки:</p>

<ul>
<li>реального охвата публикаций</li>
<li>эффективности распространения контента внутри аудитории</li>
<li>резкий пиковый рост или спад просмотров может свидетельствовать о информационных событиях или внешнем распространении</li>
</ul>

@if(!empty($viewRateChart))
<div class="chart-container">
<div class="chart-block-title">График ViewRate</div>
<img src="{{ $viewRateChart }}" style="width:100%; margin-top:10px;">
</div>
@endif

<p>
Числовые значения метрики по сообщениям представлены в конце отчета
в таблице №2.1 «Просмотр публикаций (по публикациям)».
</p>

<p>Значения показателя свидетельствуют о:</p>

<ul>
<li>реальном уровне охвата публикуемого контента среди аудитории сообщества</li>
<li>степени заинтересованности подписчиков в публикуемых материалах</li>
<li>стабильные значения могут говорить о сформированной аудитории</li>
<li>значительные колебания могут быть связаны с информационными событиями или искусственным увеличением просмотров</li>
</ul>

</div>


{{-- 2.2 --}}
<div class="section page-break">

<div class="subsection-title">2.2 Доля реакций (по публикациям)</div>

<p><strong>(ReactionRate)</strong></p>

<p>
Метрика отражает долю пользователей, просмотревших публикацию и поставивших реакцию на неё.
Показатель позволяет определить, насколько контент стимулирует быстрые эмоциональные реакции аудитории.
</p>

@if(!empty($reactionRateChart))
<div class="chart-container">
<div class="chart-block-title">График ReactionRate</div>
<img src="{{ $reactionRateChart }}" style="width:100%; margin-top:10px;">
</div>
@endif

<p>
Числовые значения метрики по сообщениям представлены
в таблице №2.2 «Доля реакций (по публикациям)».
</p>

<ul>
<li>высокий или низкий эмоциональный отклик контента</li>
<li>редкие пики могут свидетельствовать о накрутке реакций</li>
</ul>

</div>


{{-- 2.3 --}}
<div class="section page-break">

<div class="subsection-title">2.3 Доля комментариев (по публикациям)</div>

<p><strong>(CommentRate)</strong></p>

<p>
Метрика показывает частоту перехода аудитории от пассивного просмотра контента
к активному обсуждению.
</p>

@if(!empty($commentRateChart))
<div class="chart-container">
<div class="chart-block-title">График CommentRate</div>
<img src="{{ $commentRateChart }}" style="width:100%; margin-top:10px;">
</div>
@endif

<p>
Числовые значения метрики представлены
в таблице №2.3 «Доля комментариев (по публикациям)».
</p>

<ul>
<li>дискуссионность контента</li>
<li>вовлеченность аудитории в обсуждение</li>
<li>заинтересованность пользователей</li>
<li>редкие пики могут свидетельствовать о резонансных публикациях</li>
</ul>

</div>


{{-- 2.4 --}}
<div class="section page-break">

<div class="subsection-title">2.4 Вовлеченность от просмотров</div>

<p><strong>(ERview)</strong></p>

<p>
Метрика отражает долю пользователей, которые совершили действие
(реакцию или комментарий) после просмотра публикации.
Показатель позволяет оценить конверсию просмотров в активное взаимодействие.
</p>

@if(!empty($erViewChart))
<div class="chart-container">
<div class="chart-block-title">График ERview</div>
<img src="{{ $erViewChart }}" style="width:100%; margin-top:10px;">
</div>
@endif

<p>
Числовые значения метрики представлены
в таблице №2.4 «Вовлеченность от просмотров (по публикациям)».
</p>

<ul>
<li>степень вовлеченности аудитории</li>
<li>эффективность публикаций</li>
<li>стабильные значения могут говорить о сформированной аудитории</li>
<li>значительные отклонения могут быть связаны с резонансным контентом</li>
</ul>

</div>


{{-- Таблицы --}}
<div class="section page-break">

<div class="section-title">Таблицы и сноски</div>

@if(!empty($funnelByDay))

<div class="chart-block-title">Таблица 2. Воронка вовлечённости</div>

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

@foreach($funnelByDay as $index => $row)

<tr>
<td>{{ $index + 1 }} день</td>
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
