<div class="report-section">

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
            <div class="report-chart-title">График активности пользователей</div>
            <img src="{{ $activityChart }}" style="width:100%;">
        </div>
    @endif

    <div class="metrics-box">
        <div class="metrics-box-title">Общие данные за период</div>
        <div class="metric-row">
            <span class="metric-label">Всего активных уникальных пользователей</span>
            <span class="metric-value">{{ $totalActive ?? 0 }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Оставили хотя бы один комментарий</span>
            <span class="metric-value">{{ $commenters ?? 0 }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Оставили хотя бы одну реакцию</span>
            <span class="metric-value">{{ $reactors ?? 0 }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Оставили комментарий и реакцию</span>
            <span class="metric-value">{{ $both ?? 0 }}</span>
        </div>
    </div>
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
                <img src="{{ $postsChart }}" style="width:100%;">
            </div>
        @endif

        <div class="metrics-box">
            <div class="metrics-box-title">Общие данные за период</div>
            <div class="metric-row">
                <span class="metric-label">Всего публикаций</span>
                <span class="metric-value">{{ $totalPosts ?? 0 }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Администраторов</span>
                <span class="metric-value">{{ $adminPosts ?? 0 }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">От пользователей</span>
                <span class="metric-value">{{ $userPosts ?? 0 }}</span>
            </div>
        </div>
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
                <img src="{{ $engagementChart }}" style="width:100%;">
            </div>
        @endif

        <div class="metrics-box">
            <div class="metrics-box-title">Общие данные за период</div>
            <div class="metric-row">
                <span class="metric-label">Средняя вовлеченность</span>
                <span class="metric-value">{{ $avgEngagement ?? 0 }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Публикаций/пост</span>
                <span class="metric-value">{{ $avgPostsPerPost ?? 0 }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Реакций/пост</span>
                <span class="metric-value">{{ $avgReactionsPerPost ?? 0 }}</span>
            </div>
        </div>
    </div>

    <div class="report-section page-break">
        <div class="report-subsection-title">1.4 Изменения аудитории</div>

        <p>
            Раздел отражает динамику численности аудитории сообщества за анализируемый период.
            Показатель позволяет оценить темпы роста аудитории, а также выявить периоды ускоренного
            роста или снижения активности пользователей.
        </p>

        <p>
            Анализ данной метрики позволяет определить устойчивость развития сообщества,
            характер притока новых участников и возможные периоды оттока аудитории.
        </p>

        @if(!empty($participantChangedChart))
            <div class="report-chart">
                <div class="report-chart-title">График изменения аудитории</div>
                <img src="{{ $participantChangedChart }}" style="width:100%;">
            </div>
        @endif

        <p>Значения показателя могут свидетельствовать о:</p>

        <ul>
            <li>стабильном органическом росте аудитории сообщества;</li>
            <li>снижении интереса пользователей и постепенном оттоке подписчиков;</li>
            <li>резких скачках роста аудитории, связанных с рекламными кампаниями, вирусным распространением контента или искусственным увеличением числа подписчиков;</li>
            <li>краткосрочных колебаниях численности аудитории, вызванных информационными событиями или изменением активности сообщества.</li>
        </ul>

        <div class="note-box">
            <strong>Примечание:</strong> Числовые значения метрики по дням представлены в конце отчета в таблице 1.4.
        </div>
    </div>
</div>

<div class="report-section page-break">
    <div class="report-section-title">Таблица 1.1 - Активность по пользователям</div>

    @if(!empty($activityByDay))
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
</div>

@if(!empty($postsByDay))
    <div class="report-section page-break">
        <div class="report-section-title">Таблица 1.2 - Частота публикаций</div>
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
        <div class="report-section-title">Таблица 1.3 - Средняя вовлеченность</div>
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

@if(!empty($participantChanged))
    <div class="report-section page-break">
        <div class="report-section-title">Таблица 1.4 - Изменения аудитории</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>День</th>
                    <th>Количество участников</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participantChanged as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ $row['value'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
