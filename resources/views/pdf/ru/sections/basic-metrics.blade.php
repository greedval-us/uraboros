<div class="section page-break">

    <div class="section-title">Топ авторов</div>

    @foreach([$messages, $reactions, $all] as $block)
        @if(!empty($block))
            <div class="chart-container">

                {{-- Название графика --}}
                <div class="chart-block-title">
                    {{ $block['title'] ?? 'Без названия' }}
                </div>

                <table width="100%">
                    <tr>
                        {{-- График --}}
                        <td width="60%" style="vertical-align:top;">
                            @if(!empty($block['chart']))
                                <img src="{{ $block['chart'] }}" style="width:100%;">
                            @else
                                <div style="width:100%; height:200px; background:#f0f0f0; text-align:center; line-height:200px;">
                                    Нет данных для графика
                                </div>
                            @endif

                            {{-- Доля топ 10 участников --}}
                            <div class="share-box">
                                10 самых активных участников обеспечили
                                <strong>{{ $block['share'] ?? 0 }}%</strong>
                                всей активности
                            </div>
                        </td>

                        {{-- Таблица лидеров --}}
                        <td width="40%" style="vertical-align:top; padding-left:15px;">
                            @if(!empty($block['table']))
                                <table class="leaders-table">
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Count</th>
                                        <th>%</th>
                                    </tr>

                                    @foreach($block['table'] as $row)
                                        <tr>
                                            <td>
                                                <span class="color-dot"
                                                      style="background: {{ $row['color'] ?? '#999999' }}"></span>
                                                {{ $row['rank'] ?? '?' }}
                                            </td>
                                            <td>{{ $row['user_id'] ?? '-' }}</td>
                                            <td>{{ $row['count'] ?? 0 }}</td>
                                            <td>{{ $row['percent'] ?? 0 }}%</td>
                                        </tr>
                                    @endforeach
                                </table>
                                <div class="mini-description">
                                    Цвет маркера соответствует сектору диаграммы.
                                </div>
                            @else
                                <div style="font-size:12px; color:#6b7280;">
                                    Данные о лидерах отсутствуют
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>

            </div>
        @endif
    @endforeach

</div>
