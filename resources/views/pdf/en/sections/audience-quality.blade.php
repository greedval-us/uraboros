<div class="report-section page-break">

    <div class="report-section-title">3. Audience Quality</div>

    <p>
        This section focuses on analyzing the audience activity structure and identifying signs of artificial
        or abnormal user activity. The metrics help evaluate the distribution of roles within the community,
        determine the ratio of readers to content creators, and detect possible
        unnatural audience behavior patterns.
    </p>

    <p>
        Numerical values of message metrics are shown at the end of the report
        in Table 3: "Audience Quality".
    </p>

    <p>
        Overall audience activity for the period
        from {{ $periodStart ?? '****' }} to {{ $periodEnd ?? '****' }}:
    </p>

    <ul>
        <li>Percentage of users who write (WriterToMembers) – {{ $writerToMembers ?? 0 }}%</li>
        <li>Percentage of writers among active users (WriterShare) – {{ $writerShare ?? 0 }}%</li>
    </ul>

    <p>
        These metrics indicate the structure of user interactions
        within the community and allow assessment of audience engagement
        in content creation and discussion.
    </p>

    @if(!empty($writerToMembersAllChart))
        <div class="report-chart">
            <div class="report-chart-title">Audience Structure (WriterToMembers)</div>
            <img src="{{ $writerToMembersAllChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    @if(!empty($writerToShareAllChart))
        <div class="report-chart">
            <div class="report-chart-title">Active Audience Structure (WriterShare)</div>
            <img src="{{ $writerToShareAllChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

</div>

<div class="report-section page-break">

    <div class="report-subsection-title">
        3.1 Percentage of Writers in the Total Audience (WriterToMembers)
    </div>

    <p>
        This metric reflects the proportion of users who publish posts
        or comments relative to the total number of community members.
    </p>

    <p>It is used to evaluate:</p>

    <ul>
        <li>audience engagement in content creation</li>
        <li>the share of users participating in discussions</li>
        <li>the ratio of active authors to passive readers</li>
    </ul>

    <p>
        Numerical values of this metric are shown
        at the end of the report in Table 3.1: "Percentage of Writers in the Audience".
    </p>

    <p>Values may indicate:</p>

    <ul>
        <li>high audience engagement with many users participating in discussions</li>
        <li>predominance of passive content consumption with low metric values</li>
        <li>community format characteristics (information channel, discussion group, etc.)</li>
    </ul>

    @if(!empty($writerToMembersChart))
        <div class="report-chart">
            <div class="report-chart-title">
                Chart: Percentage of Writers in the Audience
            </div>

            <img src="{{ $writerToMembersChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

</div>

<div class="report-section page-break">

    <div class="report-subsection-title">
        3.2 Percentage of Writers Among Active Users (WriterShare)
    </div>

    <p>
        This metric shows the proportion of users who create content
        (write posts or comments) among all active users.
    </p>

    <p>
        It helps determine the structure of audience activity
        and the balance between content consumers and content creators.
    </p>

    <p>
        Numerical values of this metric are shown
        at the end of the report in Table 3.2: "Percentage of Writers Among Active Users".
    </p>

    <p>Values indicate:</p>

    <ul>
        <li>the distribution of user activity within the community</li>
        <li>the engagement level of the active audience in content discussion</li>
        <li>established user interaction patterns when metric values are stable</li>
        <li>possible spikes in activity by individual users when deviations are significant</li>
    </ul>

    @if(!empty($writerShareChart))
        <div class="report-chart">
            <div class="report-chart-title">
                Chart: Percentage of Writers Among Active Users
            </div>

            <img src="{{ $writerShareChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

</div>

<div class="report-section page-break">

    <div class="report-subsection-title">
        3.3 Time Burst Index (TimeBurstIndex)
    </div>

    <p>
        This metric is designed to detect unnatural bursts of user activity
        over time. Analysis is based on the distribution
        of user activity by day.
    </p>

    <p>
        The metric allows identification of anomalous concentrations of activity
        that are uncharacteristic of natural audience behavior.
    </p>

    <p>
        Numerical values of this metric are shown
        at the end of the report in Table 3.3: "Time Burst Index".
    </p>

    <p>Such bursts may indicate:</p>

    <ul>
        <li>mass automated user actions</li>
        <li>use of bots or automated scripts</li>
        <li>artificially inflated user activity</li>
        <li>coordinated actions by a group of accounts</li>
    </ul>

    @if(!empty($timeBurstIndexChart))
        <div class="report-chart">
            <div class="report-chart-title">
                Chart: Time Burst Index
            </div>

            <img src="{{ $timeBurstIndexChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

</div>

<div class="report-section page-break">

    <div class="report-section-title">
        Tables with Numerical Values
    </div>
    <div class="report-table-title">
        Table 3: "Audience Quality"
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>WriterToMembers</th>
                <th>WriterShare</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $writerToMembers ?? 0 }}</td>
                <td>{{ $writerShare ?? 0 }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="report-section page-break">

    <div class="report-table-title">
        Table 3.1: "Percentage of Writers in the Audience"
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Day</th>
                <th>WriterToMembers</th>
            </tr>
        </thead>
        <tbody>
            @foreach($writerToMembersByDay ?? [] as $row)
                <tr>
                    <td>{{ $row['day'] }}</td>
                    <td>{{ $row['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

<div class="report-section page-break">

    <div class="report-table-title">
        Table 3.2: "Percentage of Writers Among Active Users"
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Day</th>
                <th>WriterShare</th>
            </tr>
        </thead>
        <tbody>
            @foreach($writerShareByDay ?? [] as $row)
                <tr>
                    <td>{{ $row['day'] }}</td>
                    <td>{{ $row['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

<div class="report-section page-break">

    <div class="report-table-title">
        Table 3.3: "Time Burst Index"
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Day</th>
                <th>TimeBurstIndex</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timeBurstIndexByDay ?? [] as $row)
                <tr>
                    <td>{{ $row['day'] }}</td>
                    <td>{{ $row['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
