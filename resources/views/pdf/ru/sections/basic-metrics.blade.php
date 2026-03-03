<div class="section page-break">

    {{-- 1. Базовые метрики --}}
    <div class="section-title" style="font-size:22px; font-weight:bold; margin-bottom:10px;">
        1. Базовые метрики
    </div>

    {{-- 1.1 Активные пользователи за период --}}
    <div class="subsection-title" style="font-size:18px; font-weight:bold; margin-bottom:5px;">
        1.1 Активные пользователи за период
        <span style="font-weight:normal; color:#6b7280;">
            {{ $periodStart ?? '****' }} - {{ $periodEnd ?? '****' }}
        </span>
    </div>

    {{-- 1.1.1 За выбранный период --}}
    <div class="subsubsection" style="margin-bottom:15px;">
        <p>
            Общая активность: <strong>{{ $totalActive ?? 0 }}</strong> пользователей<br>
            Оставили хотя бы 1 комментарий: <strong>{{ $commenters ?? 0 }}</strong> пользователей<br>
            Оставили хотя бы одну реакцию: <strong>{{ $reactors ?? 0 }}</strong> пользователей<br>
            Оставили хотя бы один комментарий и хотя бы одну реакцию: <strong>{{ $both ?? 0 }}</strong> пользователей
        </p>
    </div>

    {{-- Таблица активности --}}
    <div style="margin-bottom:20px;">
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
                <tr>
                    <th>Активность</th>
                    <th>Публикация или реакция</th>
                    <th>Публикация</th>
                    <th>Реакция</th>
                    <th>Публикация и реакция</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($activityByDay))
                    @foreach($activityByDay as $day => $row)
                        <tr>
                            <td>{{ $day }}</td>
                            <td>{{ $row['post_or_reaction'] ?? 0 }}</td>
                            <td>{{ $row['post'] ?? 0 }}</td>
                            <td>{{ $row['reaction'] ?? 0 }}</td>
                            <td>{{ $row['post_and_reaction'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="color:#6b7280;">Нет данных</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- 1.2 Частота публикаций --}}
    <div class="subsection-title" style="font-size:18px; font-weight:bold; margin-bottom:5px;">
        1.2 Частота публикаций
    </div>

    <p>
        Общее количество публикаций за период: <strong>{{ $totalPosts ?? 0 }}</strong><br>
        Количество публикаций администратора: <strong>{{ $adminPosts ?? 0 }}</strong><br>
        Количество публикаций пользователей: <strong>{{ $userPosts ?? 0 }}</strong>
    </p>

    {{-- Таблица публикаций --}}
    <div style="margin-bottom:20px;">
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
                <tr>
                    <th>Публикации</th>
                    <th>Общее</th>
                    <th>Администратор</th>
                    <th>Пользователи</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($postsByDay))
                    @foreach($postsByDay as $day => $row)
                        <tr>
                            <td>{{ $day }}</td>
                            <td>{{ $row['total'] ?? 0 }}</td>
                            <td>{{ $row['admin'] ?? 0 }}</td>
                            <td>{{ $row['users'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" style="color:#6b7280;">Нет данных</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- 1.3 Средняя вовлеченность на пост --}}
    <div class="subsection-title" style="font-size:18px; font-weight:bold; margin-bottom:5px;">
        1.3 Средняя вовлеченность на пост
    </div>

    <p>
        Средняя вовлеченность пользователей канала: <strong>{{ $avgEngagement ?? 0 }}</strong><br>
        Среднее количество публикаций по отношению к постам: <strong>{{ $avgPostsPerPost ?? 0 }}</strong><br>
        Среднее количество реакций по отношению к постам: <strong>{{ $avgReactionsPerPost ?? 0 }}</strong>
    </p>

    {{-- Таблица средней вовлеченности --}}
    <div style="margin-bottom:20px;">
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
                <tr>
                    <th>Среднее вовлеченность</th>
                    <th>Среднее публикаций/пост</th>
                    <th>Среднее реакций/пост</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($engagementByDay))
                    @foreach($engagementByDay as $day => $row)
                        <tr>
                            <td>{{ $row['engagement'] ?? 0 }}</td>
                            <td>{{ $row['posts_ratio'] ?? 0 }}</td>
                            <td>{{ $row['reactions_ratio'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" style="color:#6b7280;">Нет данных</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>
