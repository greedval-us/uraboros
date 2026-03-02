<h2>Информация о группе</h2>

<table class="info-table">
    <tr>
        <td class="label">Название</td>
        <td class="value">{{ $title ?? '—' }}</td>
    </tr>

    <tr>
        <td class="label">Username</td>
        <td class="value">
            @if($username)
                @{{ $username }}
            @else
                —
            @endif
        </td>
    </tr>

    <tr>
        <td class="label">Участников</td>
        <td class="value">
            {{ $participants ? number_format($participants, 0, '.', ' ') : '—' }}
        </td>
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
    <div class="description">
        <strong>Описание</strong>
        <div class="description-text">
            {!! nl2br(e($description)) !!}
        </div>
    </div>
@endif

@if(!empty($flags))
    <div class="flags">
        <strong>Флаги</strong><br>
        {{ $flags }}
    </div>
@endif

<hr>
