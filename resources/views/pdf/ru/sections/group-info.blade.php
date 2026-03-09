<div class="section">
    <div class="section-title">Информация о группе</div>

    <table class="meta-table">
        <tr>
            <td class="label">Название</td>
            <td class="value">{{ $title }}</td>
        </tr>

        <tr>
            <td class="label">Username</td>
            <td class="value">{{ $username ?? '—' }}</td>
        </tr>

        <tr>
            <td class="label">Количество участников</td>
            <td class="value">{{ number_format($participants ?? 0, 0, '.', ' ') }}</td>
        </tr>

        <tr>
            <td class="label">Дата создания</td>
            <td class="value">{{ $createdAt ?? '—' }}</td>
        </tr>

        <tr>
            <td class="label">Последнее обновление</td>
            <td class="value">{{ $lastUpdate ?? '—' }}</td>
        </tr>
    </table>

    @if(!empty($description))
        <div class="description-box" style="margin-top:15px;">
            <strong>Описание</strong>
            <pre>{{ $description }}</pre>
        </div>
    @endif

    @if(!empty($flags))
        <div class="tags" style="margin-top:10px;">
            <strong>Флаги:</strong><br>
            @foreach(explode(',', $flags) as $flag)
                <span class="tag">{{ trim($flag) }}</span>
            @endforeach
        </div>
    @endif
</div>
