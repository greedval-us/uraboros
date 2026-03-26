<div class="report-section page-break">
    <div class="report-section-title">Информация о группе</div>

    <table class="report-table">
        <tr>
            <td style="font-weight: 600; width: 40%;">Название</td>
            <td>{{ $title }}</td>
        </tr>

        <tr>
            <td style="font-weight: 600;">Username</td>
            <td>{{ $username ?? '—' }}</td>
        </tr>

        <tr>
            <td style="font-weight: 600;">Количество участников</td>
            <td>{{ number_format($participants ?? 0, 0, '.', ' ') }}</td>
        </tr>

        <tr>
            <td style="font-weight: 600;">Дата создания</td>
            <td>{{ $createdAt ?? '—' }}</td>
        </tr>

        <tr>
            <td style="font-weight: 600;">Последнее обновление</td>
            <td>{{ $lastUpdate ?? '—' }}</td>
        </tr>
    </table>

    @if(!empty($description))
        <div class="description-box" style="margin-top: 14px;">
            <strong>Описание</strong>
            <pre style="margin-top: 6px;">{{ $description }}</pre>
        </div>
    @endif

    @if(!empty($flags))
        <div style="margin-top: 10px;">
            <strong>Флаги:</strong><br>
            @foreach(explode(',', $flags) as $flag)
                <span class="badge">{{ trim($flag) }}</span>
            @endforeach
        </div>
    @endif
</div>
