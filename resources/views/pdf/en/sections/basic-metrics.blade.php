<div class="report-section page-break">

    <div class="report-section-title">1. Basic Metrics</div>

    <p>
        Basic metrics allow evaluating the overall level of user activity and engagement within the analyzed community.
        These indicators reflect real user actions and help determine the actual "live" audience, publishing activity levels,
        and the nature of participants' interaction with content.
    </p>

    <div class="report-subsection-title">1.1 Active Users for the Period {{ $periodStart ?? '****' }} - {{ $periodEnd ?? '****' }}</div>

    <p>This metric reflects the number of unique users who participated in community activity during the period.</p>

    <ul>
        <li>posting a message</li>
        <li>writing a comment</li>
        <li>reacting to content</li>
        <li>sending gifts</li>
        <li>other interactions excluding views</li>
    </ul>

    @if(!empty($activityChart))
        <div class="report-chart">
            <div class="report-chart-title">User Activity Chart</div>
            <img src="{{ $activityChart }}" style="width:100%;">
        </div>
    @endif

    <div class="metrics-box">
        <div class="metrics-box-title">Summary for the Period</div>
        <div class="metric-row">
            <span class="metric-label">Total unique active users</span>
            <span class="metric-value">{{ $totalActive ?? 0 }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Left at least one comment</span>
            <span class="metric-value">{{ $commenters ?? 0 }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Left at least one reaction</span>
            <span class="metric-value">{{ $reactors ?? 0 }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label">Left comment and reaction</span>
            <span class="metric-value">{{ $both ?? 0 }}</span>
        </div>
    </div>

    <div class="report-section page-break">
        <div class="report-subsection-title">1.2 Posting Frequency</div>

        <p>
            This metric characterizes the intensity of publishing activity and helps evaluate how regularly new content appears.
            It separates posts by source:
        </p>

        <ul>
            <li>administrator posts (AdminPosts)</li>
            <li>user posts (UserPosts)</li>
        </ul>

        @if(!empty($postsChart))
            <div class="report-chart">
                <div class="report-chart-title">Posts Chart</div>
                <img src="{{ $postsChart }}" style="width:100%;">
            </div>
        @endif

        <div class="metrics-box">
            <div class="metrics-box-title">Summary for the Period</div>
            <div class="metric-row">
                <span class="metric-label">Total posts</span>
                <span class="metric-value">{{ $totalPosts ?? 0 }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Administrator</span>
                <span class="metric-value">{{ $adminPosts ?? 0 }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Users</span>
                <span class="metric-value">{{ $userPosts ?? 0 }}</span>
            </div>
        </div>
    </div>

    <div class="report-section page-break">
        <div class="report-subsection-title">1.3 Average Engagement per Post</div>

        <p>This metric shows how the audience interacts with content:</p>

        <ul>
            <li>audience interest in content (ReactionsPerPost)</li>
            <li>user activity in comments (CommentsPerPost)</li>
            <li>overall audience engagement (EngagementRate)</li>
        </ul>

        @if(!empty($engagementChart))
            <div class="report-chart">
                <div class="report-chart-title">Engagement Chart</div>
                <img src="{{ $engagementChart }}" style="width:100%;">
            </div>
        @endif

        <div class="metrics-box">
            <div class="metrics-box-title">Summary for the Period</div>
            <div class="metric-row">
                <span class="metric-label">Average engagement</span>
                <span class="metric-value">{{ $avgEngagement ?? 0 }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Posts per post</span>
                <span class="metric-value">{{ $avgPostsPerPost ?? 0 }}</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Reactions per post</span>
                <span class="metric-value">{{ $avgReactionsPerPost ?? 0 }}</span>
            </div>
        </div>
    </div>

    <div class="report-section page-break">
        <div class="report-subsection-title">1.4 Audience Changes</div>

        <p>
            This section reflects the dynamics of community audience size over the analyzed period.
            The metric helps evaluate audience growth rates and identify periods of accelerated
            growth or decline in user activity.
        </p>

        <p>
            Analyzing this metric allows assessing the stability of community development,
            the nature of new participant influx, and potential periods of audience attrition.
        </p>

        @if(!empty($participantChangedChart))
            <div class="report-chart">
                <div class="report-chart-title">Audience Change Chart</div>
                <img src="{{ $participantChangedChart }}" style="width:100%;">
            </div>
        @endif

        <p>Values may indicate:</p>

        <ul>
            <li>steady organic growth of the community audience;</li>
            <li>decreasing user interest and gradual subscriber attrition;</li>
            <li>sharp spikes in audience growth due to advertising campaigns, viral content spread, or artificial increase in followers;</li>
            <li>short-term audience fluctuations caused by informational events or changes in community activity.</li>
        </ul>

        <div class="note-box">
            Daily metric values are presented at the end of the report in Table 1.4 "Audience Changes During the Period".
        </div>
    </div>
</div>

<div class="report-section page-break">
    <div class="report-section-title">Daily Data Tables</div>

    @if(!empty($activityByDay))
        <div class="report-table-title">Table 1.1 — User Activity</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Post or Reaction</th>
                    <th>Posts</th>
                    <th>Reactions</th>
                    <th>Posts and Reactions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activityByDay as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ $row['total'] ?? 0 }}</td>
                        <td>{{ $row['posts'] ?? 0 }}</td>
                        <td>{{ $row['reactions'] ?? 0 }}</td>
                        <td>{{ $row['both'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($postsByDay))
        <div class="report-section page-break">
            <div class="report-table-title">Table 1.2 — Posting Frequency</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Total</th>
                        <th>Administrator</th>
                        <th>Users</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($postsByDay as $row)
                        <tr>
                            <td>{{ $row['day'] ?? '?' }}</td>
                            <td>{{ $row['total'] ?? 0 }}</td>
                            <td>{{ $row['admin'] ?? 0 }}</td>
                            <td>{{ $row['users'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(!empty($engagementByDay))
        <div class="report-section page-break">
            <div class="report-table-title">Table 1.3 — Average Engagement</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Average Engagement</th>
                        <th>Posts per Post</th>
                        <th>Reactions per Post</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($engagementByDay as $row)
                        <tr>
                            <td>{{ $row['day'] ?? '?' }}</td>
                            <td>{{ $row['engagement'] ?? 0 }}</td>
                            <td>{{ $row['postsPerPost'] ?? 0 }}</td>
                            <td>{{ $row['reactionsPerPost'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(!empty($participantChanged))
        <div class="report-section page-break">
            <div class="report-table-title">Table 1.4 — Audience Changes</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Number of Participants</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participantChanged as $row)
                        <tr>
                            <td>{{ $row['day'] ?? '?' }}</td>
                            <td>{{ $row['value'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
    @endif

    <p>
        Summary for the period:
        <br>Total unique active users: <strong>{{ $totalActive ?? 0 }}</strong>
        <br>Left at least one comment: <strong>{{ $commenters ?? 0 }}</strong>
        <br>Left at least one reaction: <strong>{{ $reactors ?? 0 }}</strong>
        <br>Left at least one comment and reaction: <strong>{{ $both ?? 0 }}</strong>
    </p>

    <div class="report-section page-break">
        <div class="report-subsection-title">1.2 Posting Frequency</div>

        <p>
            This metric characterizes the intensity of publishing activity and helps evaluate how regularly new content appears.
            It separates posts by source:
        </p>

        <ul>
            <li>administrator posts (AdminPosts)</li>
            <li>user posts (UserPosts)</li>
        </ul>

        @if(!empty($postsChart))
            <div class="report-chart">
                <div class="report-chart-title">Posts Chart</div>
                <img src="{{ $postsChart }}" style="width:100%; margin-top:10px;">
            </div>
        @endif

        <p>
            Summary for the period:
            <br>Total posts: <strong>{{ $totalPosts ?? 0 }}</strong>
            <br>Administrator: <strong>{{ $adminPosts ?? 0 }}</strong>
            <br>Users: <strong>{{ $userPosts ?? 0 }}</strong>
        </p>
    </div>

    <div class="report-section page-break">
        <div class="report-subsection-title">1.3 Average Engagement per Post</div>

        <p>This metric shows how the audience interacts with content:</p>

        <ul>
            <li>audience interest in content (ReactionsPerPost)</li>
            <li>user activity in comments (CommentsPerPost)</li>
            <li>overall audience engagement (EngagementRate)</li>
        </ul>

        @if(!empty($engagementChart))
            <div class="report-chart">
                <div class="report-chart-title">Engagement Chart</div>
                <img src="{{ $engagementChart }}" style="width:100%; margin-top:10px;">
            </div>
        @endif

        <p>
            Summary for the period:
            <br>Average engagement: <strong>{{ $avgEngagement ?? 0 }}</strong>
            <br>Posts per post: <strong>{{ $avgPostsPerPost ?? 0 }}</strong>
            <br>Reactions per post: <strong>{{ $avgReactionsPerPost ?? 0 }}</strong>
        </p>
    </div>

    <div class="report-section page-break">
        <div class="report-subsection-title">1.4 Audience Changes</div>

        <p>
            This section reflects the dynamics of community audience size over the analyzed period.
            The metric helps evaluate audience growth rates and identify periods of accelerated
            growth or decline in user activity.
        </p>

        <p>
            Analyzing this metric allows assessing the stability of community development,
            the nature of new participant influx, and potential periods of audience attrition.
        </p>

        @if(!empty($participantChangedChart))
            <div class="report-chart">
                <div class="report-chart-title">Audience Change Chart</div>
                <img src="{{ $participantChangedChart }}" style="width:100%; margin-top:10px;">
            </div>
        @endif

        <p>
            Daily metric values are presented at the end of the report
            in Table 1.4: "Audience Changes During the Period".
        </p>

        <p>Values may indicate:</p>

        <ul>
            <li>steady organic growth of the community audience;</li>
            <li>decreasing user interest and gradual subscriber attrition;</li>
            <li>sharp spikes in audience growth due to advertising campaigns, viral content spread, or artificial increase in followers;</li>
            <li>short-term audience fluctuations caused by informational events or changes in community activity.</li>
        </ul>
    </div>
</div>

<div class="report-section page-break">
    <div class="report-section-title">Daily Data Tables</div>

    @if(!empty($activityByDay))
        <div class="report-table-title">Table 1.1: "User Activity"</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Post or Reaction</th>
                    <th>Posts</th>
                    <th>Reactions</th>
                    <th>Posts and Reactions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activityByDay as $row)
                    <tr>
                        <td>{{ $row['day'] ?? '?' }}</td>
                        <td>{{ $row['total'] ?? 0 }}</td>
                        <td>{{ $row['posts'] ?? 0 }}</td>
                        <td>{{ $row['reactions'] ?? 0 }}</td>
                        <td>{{ $row['both'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($postsByDay))
        <div class="report-section page-break">
            <div class="report-table-title">Table 1.2: "Posting Frequency"</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Total</th>
                        <th>Administrator</th>
                        <th>Users</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($postsByDay as $row)
                        <tr>
                            <td>{{ $row['day'] ?? '?' }}</td>
                            <td>{{ $row['total'] ?? 0 }}</td>
                            <td>{{ $row['admin'] ?? 0 }}</td>
                            <td>{{ $row['users'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(!empty($engagementByDay))
        <div class="report-section page-break">
            <div class="report-table-title">Table 1.3: "Average Engagement"</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Average Engagement</th>
                        <th>Average Posts per Post</th>
                        <th>Average Reactions per Post</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($engagementByDay as $row)
                        <tr>
                            <td>{{ $row['day'] ?? '?' }}</td>
                            <td>{{ $row['engagement'] ?? 0 }}</td>
                            <td>{{ $row['postsPerPost'] ?? 0 }}</td>
                            <td>{{ $row['reactionsPerPost'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(!empty($participantChanged))
        <div class="report-section page-break">
            <div class="report-table-title">Table 1.4: "Audience Changes"</div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Number of Participants</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participantChanged as $row)
                        <tr>
                            <td>{{ $row['day'] ?? '?' }}</td>
                            <td>{{ $row['value'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
