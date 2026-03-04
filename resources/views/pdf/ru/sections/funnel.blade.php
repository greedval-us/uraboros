<div class="section page-break">

    <div class="section-title">3. Воронка «Участники → Просмотры → Реакции → Комментарии»</div>

    {{-- 3.0 Общая воронка --}}
    <div class="subsection-title">
        3.0 Динамика воронки за период {{ $periodStart ?? '****' }} - {{ $periodEnd ?? '****' }}
    </div>

    <p>
        Общее количество участников: <strong>{{ $totalMembers ?? 0 }}</strong><br>
        Суммарное количество просмотров: <strong>{{ $totalViews ?? 0 }}</strong><br>
        Суммарное количество реакций: <strong>{{ $totalReactions ?? 0 }}</strong><br>
        Суммарное количество комментариев: <strong>{{ $totalComments ?? 0 }}</strong>
    </p>

    @if(!empty($funnelByDay))
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
                <tr>
                    <th>День</th>
                    <th>Пост</th>
                    <th>Автор</th>
                    <th>Просмотры</th>
                    <th>Реакции</th>
                    <th>Комментарии</th>
                </tr>
            </thead>
            <tbody>
                @foreach($funnelByDay as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ $row['post_time'] ?? '-' }}</td>
                        <td>{{ $row['author'] ?? '-' }}</td>
                        <td>{{ $row['views'] ?? 0 }}</td>
                        <td>{{ $row['reactions'] ?? 0 }}</td>
                        <td>{{ $row['comments'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- График воронки --}}
        @if(!empty($funnelChart))
            <div class="chart-container">
                <img src="{{ $funnelChart }}" style="width:100%; margin-top:15px;">
            </div>
        @endif
    @else
        <div style="font-size:12px; color:#6b7280;">Нет данных по воронке</div>
    @endif


    {{-- 3.1 ReactionRate --}}
    <div class="subsection-title">3.1 Доля реакций (ReactionRate)</div>

    <p>
        За период: <strong>{{ $reactionRatePeriod ?? 0 }}%</strong>
    </p>

    @if(!empty($reactionRateByPost))
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
                <tr>
                    <th>Дата</th>
                    <th>Автор</th>
                    <th>Просмотры</th>
                    <th>Реакции</th>
                    <th>ReactionRate (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reactionRateByPost as $row)
                    <tr>
                        <td>{{ $row['date'] ?? '?' }}</td>
                        <td>{{ $row['author'] ?? '-' }}</td>
                        <td>{{ $row['views'] ?? 0 }}</td>
                        <td>{{ $row['reactions'] ?? 0 }}</td>
                        <td>{{ $row['rate'] ?? 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(!empty($reactionRateChart))
            <div class="chart-container">
                <img src="{{ $reactionRateChart }}" style="width:100%; margin-top:15px;">
            </div>
        @endif
    @else
        <div style="font-size:12px; color:#6b7280;">Нет данных по ReactionRate</div>
    @endif


    {{-- 3.2 CommentRate --}}
    <div class="subsection-title">3.2 Доля комментариев (CommentRate)</div>

    <p>
        За период: <strong>{{ $commentRatePeriod ?? 0 }}%</strong>
    </p>

    @if(!empty($commentRateByPost))
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
                <tr>
                    <th>Дата</th>
                    <th>Автор</th>
                    <th>Просмотры</th>
                    <th>Комментарии</th>
                    <th>CommentRate (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commentRateByPost as $row)
                    <tr>
                        <td>{{ $row['date'] ?? '?' }}</td>
                        <td>{{ $row['author'] ?? '-' }}</td>
                        <td>{{ $row['views'] ?? 0 }}</td>
                        <td>{{ $row['comments'] ?? 0 }}</td>
                        <td>{{ $row['rate'] ?? 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(!empty($commentRateChart))
            <div class="chart-container">
                <img src="{{ $commentRateChart }}" style="width:100%; margin-top:15px;">
            </div>
        @endif
    @else
        <div style="font-size:12px; color:#6b7280;">Нет данных по CommentRate</div>
    @endif


    {{-- 3.3 ERview --}}
    <div class="subsection-title">3.3 Вовлеченность от просмотров (ERview)</div>

    <p>
        За период: <strong>{{ $erViewPeriod ?? 0 }}%</strong>
    </p>

    @if(!empty($erViewByPost))
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
                <tr>
                    <th>Дата</th>
                    <th>Автор</th>
                    <th>Просмотры</th>
                    <th>Реакции + Комментарии</th>
                    <th>ERview (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($erViewByPost as $row)
                    <tr>
                        <td>{{ $row['date'] ?? '?' }}</td>
                        <td>{{ $row['author'] ?? '-' }}</td>
                        <td>{{ $row['views'] ?? 0 }}</td>
                        <td>{{ ($row['reactions'] ?? 0) + ($row['comments'] ?? 0) }}</td>
                        <td>{{ $row['rate'] ?? 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(!empty($erViewChart))
            <div class="chart-container">
                <img src="{{ $erViewChart }}" style="width:100%; margin-top:15px;">
            </div>
        @endif
    @else
        <div style="font-size:12px; color:#6b7280;">Нет данных по ERview</div>
    @endif


    {{-- 3.4 ViewRate --}}
    <div class="subsection-title">3.4 Охват просмотров (ViewRate)</div>

    <p>
        Средний процент просмотра аудитории за период: <strong>{{ $viewRatePeriod ?? 0 }}%</strong>
    </p>

    @if(!empty($viewRateByPost))
        <table width="100%" style="border-collapse:collapse; text-align:center;">
            <thead style="background:#f3f4f6;">
                <tr>
                    <th>Дата</th>
                    <th>Автор</th>
                    <th>Просмотры</th>
                    <th>Участники</th>
                    <th>ViewRate (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewRateByPost as $row)
                    <tr>
                        <td>{{ $row['date'] ?? '?' }}</td>
                        <td>{{ $row['author'] ?? '-' }}</td>
                        <td>{{ $row['views'] ?? 0 }}</td>
                        <td>{{ $row['members'] ?? 0 }}</td>
                        <td>{{ $row['rate'] ?? 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(!empty($viewRateChart))
            <div class="chart-container">
                <img src="{{ $viewRateChart }}" style="width:100%; margin-top:15px;">
            </div>
        @endif
    @else
        <div style="font-size:12px; color:#6b7280;">Нет данных по ViewRate</div>
    @endif

</div>
