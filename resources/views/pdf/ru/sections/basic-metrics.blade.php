<div class="section page-break">

    <div class="section-title">1. Базовые метрики</div>

    {{-- 1.1 Активные пользователи --}}
    <div class="subsection-title">
        1.1 Активные пользователи за период {{ $periodStart ?? '****' }} - {{ $periodEnd ?? '****' }}
    </div>

    <p>
        Общая активность: <strong>{{ $totalActive ?? 0 }}</strong> пользователей<br>
        Оставили хотя бы 1 комментарий: <strong>{{ $commenters ?? 0 }}</strong> пользователей<br>
        Оставили хотя бы одну реакцию: <strong>{{ $reactors ?? 0 }}</strong> пользователей<br>
        Оставили хотя бы один комментарий и хотя бы одну реакцию: <strong>{{ $both ?? 0 }}</strong> пользователей
    </p>

    @if(!empty($activityByDay))
        {{-- Таблица активности --}}
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
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
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ $row['total'] ?? 0 }}</td>
                        <td>{{ $row['posts'] ?? 0 }}</td>
                        <td>{{ $row['reactions'] ?? 0 }}</td>
                        <td>{{ $row['both'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- График активности --}}
        @php
            $labels = array_map(fn($row) => 'День ' . ($row['day'] ?? '?'), $activityByDay);
            $dataPosts = array_map(fn($row) => $row['posts'] ?? 0, $activityByDay);
            $dataReactions = array_map(fn($row) => $row['reactions'] ?? 0, $activityByDay);
            $chartConfig = [
                'type' => 'line',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        ['label' => 'Публикации', 'data' => $dataPosts, 'borderColor' => '#3b82f6', 'fill' => false],
                        ['label' => 'Реакции', 'data' => $dataReactions, 'borderColor' => '#10b981', 'fill' => false],
                    ],
                ],
                'options' => [
                    'plugins' => ['legend' => ['display' => true]],
                    'scales' => ['y' => ['beginAtZero' => true]]
                ]
            ];
            $chartUrl = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartConfig));
        @endphp
        <div class="chart-container">
            <img src="{{ $chartUrl }}" style="width:100%; margin-top:15px;">
        </div>
    @else
        <div style="font-size:12px; color:#6b7280;">Нет данных по активности</div>
    @endif

    {{-- 1.2 Частота публикаций --}}
    <div class="subsection-title">1.2 Частота публикаций</div>
    <p>
        Общее количество публикаций за период: <strong>{{ $totalPosts ?? 0 }}</strong><br>
        Количество публикаций администратора: <strong>{{ $adminPosts ?? 0 }}</strong><br>
        Количество публикаций пользователей: <strong>{{ $userPosts ?? 0 }}</strong>
    </p>

    @if(!empty($postsByDay))
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
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
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ $row['total'] ?? 0 }}</td>
                        <td>{{ $row['admin'] ?? 0 }}</td>
                        <td>{{ $row['users'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- График публикаций --}}
        @php
            $labels = array_map(fn($row) => 'День ' . ($row['day'] ?? '?'), $postsByDay);
            $dataAdmin = array_map(fn($row) => $row['admin'] ?? 0, $postsByDay);
            $dataUsers = array_map(fn($row) => $row['users'] ?? 0, $postsByDay);
            $chartConfig = [
                'type' => 'bar',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        ['label' => 'Администратор', 'data' => $dataAdmin, 'backgroundColor' => '#ef4444'],
                        ['label' => 'Пользователи', 'data' => $dataUsers, 'backgroundColor' => '#3b82f6'],
                    ],
                ],
                'options' => [
                    'plugins' => ['legend' => ['display' => true]],
                    'scales' => ['y' => ['beginAtZero' => true]]
                ]
            ];
            $chartUrl = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartConfig));
        @endphp
        <div class="chart-container">
            <img src="{{ $chartUrl }}" style="width:100%; margin-top:15px;">
        </div>
    @else
        <div style="font-size:12px; color:#6b7280;">Нет данных по публикациям</div>
    @endif

    {{-- 1.3 Средняя вовлеченность --}}
    <div class="subsection-title">1.3 Средняя вовлеченность на пост</div>
    <p>
        Средняя вовлеченность пользователей канала: <strong>{{ $avgEngagement ?? 0 }}</strong><br>
        Среднее количество публикаций по отношению к постам: <strong>{{ $avgPostsPerPost ?? 0 }}</strong><br>
        Среднее количество реакций по отношению к постам: <strong>{{ $avgReactionsPerPost ?? 0 }}</strong>
    </p>

    @if(!empty($engagementByDay))
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
                <tr>
                    <th>День</th>
                    <th>Среднее вовлеченность</th>
                    <th>Среднее публикаций/пост</th>
                    <th>Среднее реакций/пост</th>
                </tr>
            </thead>
            <tbody>
                @foreach($engagementByDay as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ $row['engagement'] ?? 0 }}</td>
                        <td>{{ $row['posts_ratio'] ?? 0 }}</td>
                        <td>{{ $row['reactions_ratio'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- График вовлеченности --}}
        @php
            $labels = array_map(fn($row) => 'День ' . ($row['day'] ?? '?'), $engagementByDay);
            $dataEngagement = array_map(fn($row) => $row['engagement'] ?? 0, $engagementByDay);
            $chartConfig = [
                'type' => 'line',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        ['label' => 'Вовлеченность', 'data' => $dataEngagement, 'borderColor' => '#10b981', 'fill' => false],
                    ],
                ],
                'options' => [
                    'plugins' => ['legend' => ['display' => true]],
                    'scales' => ['y' => ['beginAtZero' => true]]
                ]
            ];
            $chartUrl = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartConfig));
        @endphp
        <div class="chart-container">
            <img src="{{ $chartUrl }}" style="width:100%; margin-top:15px;">
        </div>
    @else
        <div style="font-size:12px; color:#6b7280;">Нет данных по вовлеченности</div>
    @endif

</div>
