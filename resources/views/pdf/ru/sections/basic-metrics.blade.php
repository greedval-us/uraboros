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
        @if(!empty($activityChart))
            <div class="chart-container">
                <img src="{{ $activityChart }}" style="width:100%; margin-top:15px;">
            </div>
        @endif
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
        @if(!empty($postsChart))
            <div class="chart-container">
                <img src="{{ $postsChart }}" style="width:100%; margin-top:15px;">
            </div>
        @endif
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
                        <td>{{ $row['postsPerPost'] ?? 0 }}</td>
                        <td>{{ $row['reactionsPerPost'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- График вовлеченности --}}
        @if(!empty($engagementChart))
            <div class="chart-container">
                <img src="{{ $engagementChart }}" style="width:100%; margin-top:15px;">
            </div>
        @endif
    @else
        <div style="font-size:12px; color:#6b7280;">Нет данных по вовлеченности</div>
    @endif

</div>
