<div class="report-section page-break">

    <div class="report-section-title">1. Top Users and Key Participants</div>

    <p>
        This section aims to identify the most active community members who contribute a significant portion of posts and interactions.
        The analysis helps determine participants with the greatest influence on the community’s informational activity and user interaction structure.
        Identifying such users allows assessing activity distribution within the community, defining the core of the most active audience,
        and identifying users generating a substantial part of discussions.
    </p>

    <div class="report-subsection-title">1.1 Top 10 Users (by Number of Posts)</div>

    <p>
        This subsection identifies users who published the highest number of posts during the analyzed period.
        The metric highlights the most active content creators and identifies users shaping a large part of the community’s information flow.
    </p>

    <p>
        Numerical values for the metric are shown at the end of the report in Table 4.1 “Top 10 Users by Number of Posts.”
        Metric values may indicate:
        <ul>
            <li>the presence of a core of active users regularly publishing posts;</li>
            <li>concentration of a significant portion of posting activity among a limited number of participants;</li>
            <li>high activity of individual users shaping discussions within the community.</li>
        </ul>
    </p>

    @if(!empty($messageChart))
        <div class="report-chart">
            <div class="report-chart-title">Top 10 Users by Posts</div>
            <img src="{{ $messageChart }}" style="width:100%; margin-top:10px;">
            <div class="report-table-title">Table 4.1: Top 10 Users by Number of Posts</div>
        </div>
    @endif

    <div class="report-section page-break">
        <div class="report-subsection-title">1.2 Top 10 Users (by Number of Reactions)</div>

        <p>
            This subsection analyzes users who most actively react to community posts.
            The metric identifies users showing the highest engagement with the community’s content.
        </p>

        <p>
            Numerical values for the metric are shown at the end of the report in Table 4.2 “Top 10 Users by Number of Reactions.”
            Metric values may indicate:
            <ul>
                <li>users who regularly engage with posts;</li>
                <li>high engagement of certain participants in consuming and evaluating content;</li>
                <li>concentration of interaction activity among a limited number of users.</li>
            </ul>
        </p>

        @if(!empty($reactionChart))
            <div class="report-chart">
                <div class="report-chart-title">Top 10 Users by Reactions</div>
                <img src="{{ $reactionChart }}" style="width:100%; margin-top:10px;">
                <div class="report-table-title">Table 4.2: Top 10 Users by Number of Reactions</div>
            </div>
        @endif
    </div>

    <div class="report-section page-break">
        <div class="report-subsection-title">1.3 Top 10 Users (by Total Activity)</div>

        <p>
            This subsection ranks users by an aggregate activity metric, considering multiple types of interaction with community content:
            posting, commenting, reacting, and other forms of engagement.
            The metric identifies users with the greatest influence on overall community activity.
        </p>

        <p>
            Numerical values for total activity are shown in Table 4.3 “Top 10 Users by Total Activity.”
            Metric values may indicate:
            <ul>
                <li>the presence of a core group of the most active participants;</li>
                <li>concentration of a significant portion of activity among a limited number of users;</li>
                <li>distribution of activity among various community members.</li>
            </ul>
        </p>

        @if(!empty($totalChart))
            <div class="report-chart">
                <div class="report-chart-title">Top 10 Users by Total Activity</div>
                <img src="{{ $totalChart }}" style="width:100%; margin-top:10px;">
                <div class="report-table-title">Table 4.3: Top 10 Users by Total Activity</div>
            </div>
        @endif
    </div>

    <div class="report-section page-break">
        <div class="report-section-title">Tables with Numeric Values</div>

        <div class="report-table-title">Table 4.1: Top 10 Users by Number of Posts</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Posts</th>
                </tr>
            </thead>
            <tbody>
                @foreach($top10ByMessage as $userId => $count)
                    <tr>
                        <td>{{ $userId }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="report-section page-break">
            <div class="report-table-title">Table 4.2: Top 10 Users by Number of Reactions</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Reactions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($top10ByReaction as $userId => $count)
                        <tr>
                            <td>{{ $userId }}</td>
                            <td>{{ $count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="report-section page-break">
            <div class="report-table-title">Table 4.3: Top 10 Users by Total Activity</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Total Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($top10ByTotal as $userId => $count)
                        <tr>
                            <td>{{ $userId }}</td>
                            <td>{{ $count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
