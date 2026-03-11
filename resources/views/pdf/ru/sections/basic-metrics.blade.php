<div class="report-section page-break">

    <div class="report-section-title">1. Базовые метрики</div>

    <p>
        Базовые метрики позволяют оценить общий уровень активности и вовлеченности пользователей внутри анализируемого сообщества.
        Показатели отражают реальные действия пользователей и помогают определить фактическую «живую» аудиторию, уровень публикационной активности и характер взаимодействия участников с контентом.
    </p>

    <div class="report-subsection-title">1.1 Активные пользователи за период {{ $periodStart ?? '****' }} - {{ $periodEnd ?? '****' }}</div>

    <p>Метрика отражает количество уникальных пользователей, принимавших участие в активности сообщества за период.</p>

    <ul>
        <li>публикация сообщения</li>
        <li>написание комментария</li>
        <li>постановка реакции</li>
        <li>отправка подарка</li>
        <li>другое взаимодействие, кроме просмотров</li>
    </ul>

    @if(!empty($activityChart))
        <div class="report-chart">
            <div class="report-chart-title">График активности</div>
            <img src="{{ $activityChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <p>
        Общие данные за период:
        <br>Всего активных уникальных пользователей: <strong>{{ $totalActive ?? 0 }}</strong>
        <br>Оставили хотя бы один комментарий: <strong>{{ $commenters ?? 0 }}</strong>
        <br>Оставили хотя бы одну реакцию: <strong>{{ $reactors ?? 0 }}</strong>
        <br>Оставили хотя бы один комментарий и реакцию: <strong>{{ $both ?? 0 }}</strong>
    </p>
    <div class="report-section page-break">
        <div class="report-subsection-title">1.2 Частота публикаций</div>

        <p>
            Метрика характеризует интенсивность публикационной активности и позволяет оценить регулярность появления нового контента.
            Разделяет публикации по источнику:
        </p>

        <ul>
            <li>публикации администраторов (AdminPosts)</li>
            <li>публикации пользователей (UserPosts)</li>
        </ul>

        @if(!empty($postsChart))
            <div class="report-chart">
                <div class="report-chart-title">График публикаций</div>
                <img src="{{ $postsChart }}" style="width:100%; margin-top:10px;">
            </div>
        @endif

        <p>
            Общие данные за период:
            <br>Всего публикаций: <strong>{{ $totalPosts ?? 0 }}</strong>
            <br>Администратор: <strong>{{ $adminPosts ?? 0 }}</strong>
            <br>Пользователи: <strong>{{ $userPosts ?? 0 }}</strong>
        </p>
    </div>
    <div class="report-section page-break">
        <div class="report-subsection-title">1.3 Средняя вовлеченность на пост</div>

        <p>Метрика показывает, насколько аудитория взаимодействует с контентом:</p>

        <ul>
            <li>интерес аудитории к контенту (ReactionsPerPost)</li>
            <li>активность пользователей в комментариях (CommentsPerPost)</li>
            <li>общее вовлечение аудитории (EngagementRate)</li>
        </ul>

        @if(!empty($engagementChart))
            <div class="report-chart">
                <div class="report-chart-title">График вовлеченности</div>
                <img src="{{ $engagementChart }}" style="width:100%; margin-top:10px;">
            </div>
        @endif

        <p>
            Общие данные за период:
            <br>Средняя вовлеченность: <strong>{{ $avgEngagement ?? 0 }}</strong>
            <br>Публикаций/пост: <strong>{{ $avgPostsPerPost ?? 0 }}</strong>
            <br>Реакций/пост: <strong>{{ $avgReactionsPerPost ?? 0 }}</strong>
        </p>
    </div>
</div>

<div class="report-section page-break">
    <div class="report-section-title">Таблицы с данными по дням</div>

    @if(!empty($activityByDay))
        <div class="report-table-title">Таблица №1.1 «Активность по пользователям»</div>
        <table class="report-table">
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
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ $row['total'] ?? 0 }}</td>
                        <td>{{ $row['posts'] ?? 0 }}</td>
                        <td>{{ $row['reactions'] ?? 0 }}</td>
                        <td>{{ $row['both'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @if(!empty($postsByDay))
        <div class="report-section page-break">
            <div class="report-table-title">Таблица №1.2 «Частота публикаций»</div>
            <table class="report-table">
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
                            <td>{{ $row['day'] ?? '?' }}</td>
                            <td>{{ $row['total'] ?? 0 }}</td>
                            <td>{{ $row['admin'] ?? 0 }}</td>
                            <td>{{ $row['users'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    @if(!empty($engagementByDay))
        <div class="report-section page-break">
            <div class="report-table-title">Таблица №1.3 «Средняя вовлеченность»</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>День</th>
                        <th>Средняя вовлеченность</th>
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
        </div>
    @endif
</div>
