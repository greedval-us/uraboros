<div class="report-section">

    <div class="report-section-title">1. Анализ пользователя</div>

    @php
        $userId = data_get($user, 'idUser')
            ?? data_get($user, 'id_user')
            ?? data_get($user, 'id');

        $username = data_get($user, 'username');

        $fullName = trim(
            (string)(data_get($user, 'firstName') ?? data_get($user, 'first_name') ?? '') . ' ' .
            (string)(data_get($user, 'lastName') ?? data_get($user, 'last_name') ?? '')
        );

        $isBot = data_get($user, 'isBot');
        $isGeo = data_get($user, 'isGeo');

        $changedUserCount = is_countable($changedUser ?? null) ? count($changedUser) : 0;
    @endphp

    <p>
        Раздел содержит анализ активности конкретного пользователя за период
        {{ $periodStart ?? '****' }} - {{ $periodEnd ?? '****' }}.
        Рассматриваются основные типы действий: подарки, сообщения и реакции, а также распределение активности по группам.
    </p>

    <div class="report-subsection-title">1.1 Общая информация</div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Параметр</th>
                <th>Значение</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ID пользователя</td>
                <td>{{ $userId ?? '—' }}</td>
            </tr>
            <tr>
                <td>Username</td>
                <td>{{ $username ? '@' . $username : '—' }}</td>
            </tr>
            <tr>
                <td>Имя</td>
                <td>{{ $fullName !== '' ? $fullName : '—' }}</td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td>{{ data_get($user, 'number') ?? '—' }}</td>
            </tr>
            <tr>
                <td>Дата рождения</td>
                <td>{{ data_get($user, 'birthday') ?? '—' }}</td>
            </tr>
            <tr>
                <td>Бот</td>
                <td>
                    @if($isBot === null)
                        —
                    @else
                        {{ $isBot ? 'Да' : 'Нет' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Гео</td>
                <td>
                    @if($isGeo === null)
                        —
                    @else
                        {{ $isGeo ? 'Да' : 'Нет' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Локация</td>
                <td>{{ data_get($user, 'location') ?? '—' }}</td>
            </tr>
            <tr>
                <td>Адрес</td>
                <td>{{ data_get($user, 'locationAddress') ?? data_get($user, 'location_address') ?? '—' }}</td>
            </tr>
            <tr>
                <td>Последнее обновление</td>
                <td>{{ data_get($user, 'updatedAt') ?? data_get($user, 'updated_at') ?? '—' }}</td>
            </tr>
            <tr>
                <td>Группы</td>
                <td>{{ is_countable($groups ?? null) ? count($groups) : 0 }}</td>
            </tr>
            <tr>
                <td>Изменения профиля (снимки)</td>
                <td>{{ $changedUserCount }}</td>
            </tr>
            <tr>
                <td>Итого за период</td>
                <td>
                    Подарки: <strong>{{ number_format($allGifts ?? 0, 0, '.', ' ') }}</strong>,
                    сообщения: <strong>{{ number_format($allMessages ?? 0, 0, '.', ' ') }}</strong>,
                    реакции: <strong>{{ number_format($allReactions ?? 0, 0, '.', ' ') }}</strong>
                </td>
            </tr>
        </tbody>
    </table>

    @if(!empty(data_get($user, 'about')))
        <div class="description-box" style="margin-top: 14px;">
            <strong>О себе</strong>
            <pre style="margin-top: 6px;">{{ data_get($user, 'about') }}</pre>
        </div>
    @endif

    @if(!empty($activityPeriodChart))
        <div class="report-chart">
            <div class="report-chart-title">График активности по дням</div>
            <img src="{{ $activityPeriodChart }}" style="width:100%;">
        </div>
    @endif

    @if(!empty($activityByGroupsChart))
        <div class="report-chart">
            <div class="report-chart-title">График активности по группам</div>
            <img src="{{ $activityByGroupsChart }}" style="width:100%;">
        </div>
    @endif

</div>

<div class="report-section page-break">
    <div class="report-section-title">Таблицы с числовыми значениями</div>

    @if(!empty($activityPeriod))
        <div class="report-table-title">Таблица 1.1 — Активность пользователя по дням</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>День</th>
                    <th>Подарки</th>
                    <th>Сообщения</th>
                    <th>Реакции</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activityPeriod as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ number_format($row['allGifts'] ?? 0, 0, '.', ' ') }}</td>
                        <td>{{ number_format($row['allMessages'] ?? 0, 0, '.', ' ') }}</td>
                        <td>{{ number_format($row['allReactions'] ?? 0, 0, '.', ' ') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($activityByGroups))
        <div class="report-section page-break">
            <div class="report-table-title">Таблица 1.2 — Активность пользователя по группам</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Группа</th>
                        <th>ID</th>
                        <th>Подарки</th>
                        <th>Сообщения</th>
                        <th>Реакции</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activityByGroups as $row)
                        <tr>
                            <td>{{ $row['day'] ?? '?' }}</td>
                            <td>{{ $row['groupId'] ?? '—' }}</td>
                            <td>{{ number_format($row['allGifts'] ?? 0, 0, '.', ' ') }}</td>
                            <td>{{ number_format($row['allMessages'] ?? 0, 0, '.', ' ') }}</td>
                            <td>{{ number_format($row['allReactions'] ?? 0, 0, '.', ' ') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
