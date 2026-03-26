<div class="report-section page-break">
    <div class="report-section-title">Информация о группе</div>

    <table class="report-table">
        <tr>
            <td class="report-table-label">Название</td>
            <td class="report-table-value">{{ $title }}</td>
        </tr>
        <tr>
            <td class="report-table-label">Username</td>
            <td class="report-table-value">{{ $username ?? '—' }}</td>
        </tr>
        <tr>
            <td class="report-table-label">Количество участников</td>
            <td class="report-table-value">{{ number_format($participants ?? 0, 0, '.', ' ') }}</td>
        </tr>
        <tr>
            <td class="report-table-label">Дата создания</td>
            <td class="report-table-value">{{ $createdAt ?? '—' }}</td>
        </tr>
        <tr>
            <td class="report-table-label">Последнее обновление</td>
            <td class="report-table-value">{{ $lastUpdate ?? '—' }}</td>
        </tr>
    </table>

    @if(!empty($description))
        <div class="report-description" style="margin-top:20px;">
            <strong>Описание группы</strong>
            <pre>{{ $description }}</pre>
        </div>
    @endif

    @if(!empty($flags))
        <div class="report-tags" style="margin-top:15px;">
            <strong>Характеристики:</strong><br>
            @foreach(explode(',', $flags) as $flag)
                <span class="report-tag">{{ trim($flag) }}</span>
            @endforeach
        </div>
    @endif
</div>
