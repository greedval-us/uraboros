<div class="section page-break">

    <div class="section-title">Топ авторов</div>

    @foreach([$messages, $reactions, $all] as $block)

        <div class="chart-container">

            <div class="chart-block-title">
                {{ $block['title'] }}
            </div>

            <table width="100%">
                <tr>
                    <td width="60%" style="vertical-align:top;">

                        <img src="{{ $block['chart'] }}" style="width:100%;">

                        <div class="share-box">
                            10 самых активных участников обеспечили
                            <strong>{{ $block['share'] }}%</strong>
                            всей активности
                        </div>

                    </td>

                    <td width="40%" style="vertical-align:top; padding-left:15px;">

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
                                              style="background: {{ $row['color'] }}"></span>
                                        {{ $row['rank'] }}
                                    </td>
                                    <td>{{ $row['user_id'] }}</td>
                                    <td>{{ $row['count'] }}</td>
                                    <td>{{ $row['percent'] }}%</td>
                                </tr>
                            @endforeach
                        </table>

                        <div class="mini-description">
                            Цвет маркера соответствует сектору диаграммы.
                        </div>

                    </td>
                </tr>
            </table>

        </div>

    @endforeach

</div>
