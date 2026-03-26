<div class="report-section page-break">

    <div class="report-section-title">2. Engagement Funnel</div>

    <p>
        participants → views → reactions → comments <br>
        (ViewRate, ReactionRate, CommentRate, ERview)
    </p>

    <p>
        This section analyzes the user behavioral funnel for content interaction.
        It shows content effectiveness, audience engagement depth, and how the audience progresses
        through sequential interaction stages:
    </p>

    <ol>
        <li>content view (ViewRate)</li>
        <li>reaction to content (ReactionRate)</li>
        <li>participation in discussion (CommentRate)</li>
        <li>view-based engagement (ERview)</li>
    </ol>

    <p>
        Summary for the period from {{ $periodStart ?? '****' }} to {{ $periodEnd ?? '****' }}:
    </p>

    @if(!empty($funnelChart))
        <div class="report-chart">
            <div class="report-chart-title">📊 Engagement Funnel (%)</div>
            <img src="{{ $funnelChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <ul>
        <li>Total content views (ViewRate) – <strong>{{ $avgViewRate ?? 0 }}%</strong></li>
        <li>Average reactions to content (ReactionRate) – <strong>{{ $avgReactionRate ?? 0 }}%</strong></li>
        <li>Average participation in discussions (CommentRate) – <strong>{{ $avgCommentRate ?? 0 }}%</strong></li>
        <li>Overall view-based engagement (ERview) – <strong>{{ $avgERview ?? 0 }}%</strong></li>
    </ul>
</div>

<div class="report-section page-break">

    <div class="report-subsection-title">2.1 Content Views (by Post)</div>

    <p>
        This metric reflects the portion of the community audience that actually views
        published content (ViewRate).
    </p>

    <p>It is used to assess:</p>

    <ul>
        <li>actual reach of publications;</li>
        <li>effectiveness of content distribution within the audience;</li>
        <li>trends in audience interest for published materials.</li>
    </ul>

    @if(!empty($viewRateChart))
        <div class="report-chart">
            <div class="report-chart-title">📈 Content View Trends</div>
            <img src="{{ $viewRateChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <p>
        Metric values per post are shown at the end of the report
        in Table 2.1: "Content Views (by Post)".
    </p>

    <p>Values may indicate:</p>

    <ul>
        <li>actual reach of content among the audience;</li>
        <li>audience interest in the content;</li>
        <li>stable values indicate a consistent and engaged audience;</li>
        <li>significant fluctuations may be caused by informational events, external content distribution, or changes in audience interest.</li>
    </ul>

</div>

<div class="report-section page-break">

    <div class="report-subsection-title">2.2 Reaction Rate (by Post)</div>

    <p>
        This metric shows the proportion of users who viewed a post and reacted to it (ReactionRate).
    </p>

    <p>
        It helps determine how content stimulates immediate emotional reactions from the audience.
    </p>

    @if(!empty($reactionRateChart))
        <div class="report-chart">
            <div class="report-chart-title">📈 Reaction Trends</div>
            <img src="{{ $reactionRateChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <p>
        Metric values are presented at the end of the report
        in Table 2.2: "Reaction Rate (by Post)".
    </p>

    <p>Values may indicate:</p>

    <ul>
        <li>high or low emotional response from the audience;</li>
        <li>content attractiveness;</li>
        <li>sharp spikes may indicate viral content or artificially increased reactions.</li>
    </ul>

</div>

<div class="report-section page-break">

    <div class="report-subsection-title">2.3 Comment Rate (by Post)</div>

    <p>
        This metric shows how often the audience transitions from passive content viewing
        to active discussion (CommentRate).
    </p>

    @if(!empty($commentRateChart))
        <div class="report-chart">
            <div class="report-chart-title">📈 Comment Trends</div>
            <img src="{{ $commentRateChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <p>
        Metric values are presented at the end of the report
        in Table 2.3: "Comment Rate (by Post)".
    </p>

    <p>Values may indicate:</p>

    <ul>
        <li>high or low discussion potential of content;</li>
        <li>audience engagement in discussions;</li>
        <li>user interest in topics;</li>
        <li>sharp peaks may indicate viral posts or external audience influx.</li>
    </ul>

</div>

<div class="report-section page-break">

    <div class="report-subsection-title">2.4 Engagement from Views (ERview)</div>

    <p>
        This metric reflects the portion of users who took an action
        (reaction or comment) after viewing a post.
    </p>

    <p>
        It helps evaluate conversion of views into active engagement.
    </p>

    @if(!empty($erViewChart))
        <div class="report-chart">
            <div class="report-chart-title">📈 Engagement from Views Trends</div>
            <img src="{{ $erViewChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <p>
        Metric values are presented at the end of the report
        in Table 2.4: "Engagement from Views (by Post)".
    </p>

    <p>Values may indicate:</p>

    <ul>
        <li>audience engagement in content interaction;</li>
        <li>effectiveness of posts in prompting actions;</li>
        <li>stable values indicate an engaged audience;</li>
        <li>large deviations may result from viral content or external distribution.</li>
    </ul>
</div>

<div class="report-section page-break">
    @if(!empty($funnelByDay))
        <div class="report-table-title">Table 2: Engagement Funnel</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Content Views</th>
                    <th>Reactions</th>
                    <th>Comments</th>
                    <th>View-Based Engagement</th>
                </tr>
            </thead>
            <tbody>
                @foreach($funnelByDay as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '-- --' }}</td>
                        <td>{{ $row['viewRate'] ?? 0 }}</td>
                        <td>{{ $row['reactionRate'] ?? 0 }}</td>
                        <td>{{ $row['commentRate'] ?? 0 }}</td>
                        <td>{{ $row['erView'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="report-section page-break">
    @if(!empty($viewRatePeriod))
        <div class="report-table-title">Table 2.1 - Content Views</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Content Views</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewRatePeriod as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '-- --' }}</td>
                        <td>{{ $row['value'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="report-section page-break">
    @if(!empty($reactionRatePeriod))
        <div class="report-table-title">Table 2.2 - Reactions</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Reactions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reactionRatePeriod as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '-- --' }}</td>
                        <td>{{ $row['value'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="report-section page-break">
    @if(!empty($commentRatePeriod))
        <div class="report-table-title">Table 2.3 - Comments</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commentRatePeriod as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '-- --' }}</td>
                        <td>{{ $row['value'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="report-section page-break">
    @if(!empty($ERviewPeriod))
        <div class="report-table-title">Table 2.4 - View-Based Engagement</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>ERview</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ERviewPeriod as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '-- --' }}</td>
                        <td>{{ $row['value'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
