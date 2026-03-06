<style>

body{
font-family: DejaVu Sans, Arial, sans-serif;
font-size:14px;
line-height:1.6;
color:#1f2937;
}

.section{
margin-top:35px;
}

.section-title{
font-size:26px;
font-weight:700;
border-bottom:2px solid #e5e7eb;
padding-bottom:8px;
margin-bottom:20px;
}

.subsection-title{
font-size:20px;
font-weight:600;
margin-top:25px;
margin-bottom:10px;
color:#111827;
}

.metric-box{
background:#f9fafb;
border:1px solid #e5e7eb;
border-radius:8px;
padding:15px;
margin:15px 0;
}

.metric-number{
font-size:22px;
font-weight:700;
color:#111827;
}

.chart-container{
margin-top:15px;
text-align:center;
}

.chart-caption{
font-size:12px;
color:#6b7280;
margin-top:5px;
}

table{
width:100%;
border-collapse:collapse;
margin-top:15px;
font-size:13px;
}

th,td{
border:1px solid #e5e7eb;
padding:8px;
text-align:center;
}

th{
background:#f3f4f6;
font-weight:600;
}

.table-title{
font-size:16px;
font-weight:600;
margin-top:30px;
margin-bottom:8px;
}

.page-break{
page-break-before:always;
}

ul{
margin-top:5px;
}

</style>


<div class="section">

<div class="section-title">
1. Базовые метрики
</div>


{{-- 1.1 Активные пользователи --}}

<div class="subsection-title">
1.1 Активные пользователи за период {{ $periodStart }} – {{ $periodEnd }}
</div>

<p>
Метрика отражает количество уникальных пользователей,
принимавших участие в активности сообщества за анализируемый период.
Позволяет оценить реальный размер вовлечённой аудитории
и уровень активности внутри сообщества.
</p>

<p>Учитывающиеся активности:</p>

<ul>
<li>публикация сообщения</li>
<li>написание комментария</li>
<li>постановка реакции</li>
<li>отправка подарка</li>
<li>другое взаимодействие системы</li>
</ul>


<div class="metric-box">

<p>
Всего активных пользователей:
<span class="metric-number">{{ $totalActive }}</span>
</p>

<p>
Оставили хотя бы один комментарий:
<strong>{{ $commenters }}</strong>
</p>

<p>
Оставили хотя бы одну реакцию:
<strong>{{ $reactors }}</strong>
</p>

<p>
Оставили комментарий и реакцию:
<strong>{{ $both }}</strong>
</p>

</div>


@if(!empty($activityChart))

<div class="chart-container">
<img src="{{ $activityChart }}" style="width:100%">
<div class="chart-caption">
Рисунок 1.1 — Динамика активности пользователей
</div>
</div>

@endif


<p style="margin-top:15px">
Числовые значения метрики по дням представлены
в таблице <strong>1.1 «Активность пользователей»</strong> в конце отчета.
</p>



{{-- 1.2 Частота публикаций --}}

<div class="subsection-title">
1.2 Частота публикаций
</div>

<p>
Метрика характеризует интенсивность публикационной активности
в сообществе и позволяет оценить регулярность появления контента.
</p>

<ul>
<li>публикации администраторов</li>
<li>публикации пользователей</li>
</ul>


<div class="metric-box">

<p>
Общее количество публикаций:
<span class="metric-number">{{ $totalPosts }}</span>
</p>

<p>
Публикации администратора:
<strong>{{ $adminPosts }}</strong>
</p>

<p>
Публикации пользователей:
<strong>{{ $userPosts }}</strong>
</p>

</div>


@if(!empty($postsChart))

<div class="chart-container">
<img src="{{ $postsChart }}" style="width:100%">
<div class="chart-caption">
Рисунок 1.2 — Динамика публикаций
</div>
</div>

@endif


<p>
Числовые значения представлены
в таблице <strong>1.2 «Частота публикаций»</strong>.
</p>



{{-- 1.3 Вовлеченность --}}

<div class="subsection-title">
1.3 Средняя вовлеченность на пост
</div>

<p>
Метрика отражает степень взаимодействия аудитории
с публикациями сообщества.
</p>

<ul>
<li>ReactionsPerPost — реакции на пост</li>
<li>CommentsPerPost — комментарии на пост</li>
<li>EngagementRate — общий уровень взаимодействия</li>
</ul>


<div class="metric-box">

<p>
Средняя вовлеченность:
<span class="metric-number">{{ $engagementRate }}</span>
</p>

<p>
Комментарии на пост:
<strong>{{ $avgCommentsPerPost }}</strong>
</p>

<p>
Реакции на пост:
<strong>{{ $avgReactionsPerPost }}</strong>
</p>

</div>


@if(!empty($engagementChart))

<div class="chart-container">
<img src="{{ $engagementChart }}" style="width:100%">
<div class="chart-caption">
Рисунок 1.3 — Динамика вовлеченности
</div>
</div>

@endif


<p>
Числовые значения представлены
в таблице <strong>1.3 «Средняя вовлеченность»</strong>.
</p>



{{-- 1.4 Изменение аудитории --}}

<div class="subsection-title">
1.4 Изменение аудитории
</div>

<p>
Раздел отражает динамику численности аудитории
сообщества за анализируемый период.
</p>

<ul>
<li>приток пользователей</li>
<li>отток пользователей</li>
<li>общая динамика аудитории</li>
</ul>

@if(!empty($audienceChart))

<div class="chart-container">
<img src="{{ $audienceChart }}" style="width:100%">
<div class="chart-caption">
Рисунок 1.4 — Динамика аудитории
</div>
</div>

@endif

<p>
Подробные данные представлены
в таблице <strong>1.4 «Изменения аудитории»</strong>.
</p>

</div>



{{-- ========================= --}}
{{-- ТАБЛИЦЫ В КОНЦЕ ОТЧЕТА --}}
{{-- ========================= --}}

<div class="page-break"></div>

<div class="section-title">
Таблицы и сноски
</div>



{{-- Таблица 1.1 --}}

<div class="table-title">
Таблица 1.1 — Активность пользователей
</div>

<table>
<thead>
<tr>
<th>День</th>
<th>Публикация или реакция</th>
<th>Публикация</th>
<th>Реакция</th>
<th>Публикация и реакция</th>
</tr>
</thead>

<tbody>

@foreach($activityByDay as $row)

<tr>
<td>{{ $row['day'] }}</td>
<td>{{ $row['total'] }}</td>
<td>{{ $row['posts'] }}</td>
<td>{{ $row['reactions'] }}</td>
<td>{{ $row['both'] }}</td>
</tr>

@endforeach

</tbody>
</table>



{{-- Таблица 1.2 --}}

<div class="table-title">
Таблица 1.2 — Частота публикаций
</div>

<table>

<thead>
<tr>
<th>День</th>
<th>Общее</th>
<th>Администратор</th>
<th>Пользователи</th>
</tr>
</thead>

<tbody>

@foreach($postsByDay as $row)

<tr>
<td>{{ $row['day'] }}</td>
<td>{{ $row['total'] }}</td>
<td>{{ $row['admin'] }}</td>
<td>{{ $row['users'] }}</td>
</tr>

@endforeach

</tbody>

</table>



{{-- Таблица 1.3 --}}

<div class="table-title">
Таблица 1.3 — Средняя вовлеченность
</div>

<table>

<thead>
<tr>
<th>День</th>
<th>Вовлеченность</th>
<th>Комментарии / пост</th>
<th>Реакции / пост</th>
</tr>
</thead>

<tbody>

@foreach($engagementByDay as $row)

<tr>
<td>{{ $row['day'] }}</td>
<td>{{ $row['engagement'] }}</td>
<td>{{ $row['commentsPerPost'] }}</td>
<td>{{ $row['reactionsPerPost'] }}</td>
</tr>

@endforeach

</tbody>

</table>



{{-- Таблица 1.4 --}}

<div class="table-title">
Таблица 1.4 — Изменение аудитории
</div>

<table>

<thead>
<tr>
<th>Отсечка</th>
<th>Количество участников</th>
</tr>
</thead>

<tbody>

@foreach($audienceChanges as $row)

<tr>
<td>{{ $row['point'] }}</td>
<td>{{ $row['count'] }}</td>
</tr>

@endforeach

</tbody>

</table>
