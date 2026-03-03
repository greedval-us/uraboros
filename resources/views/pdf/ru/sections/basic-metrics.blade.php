<div class="section">
    <div class="section-title">Топ авторов (Top 10)</div>

    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td width="50%" style="padding-right:10px; vertical-align:top;">
                <div class="chart-box">
                    <div class="chart-title">По сообщениям</div>
                    <img src="{{ $messagesChart }}" style="width:100%;">
                </div>
            </td>

            <td width="50%" style="padding-left:10px; vertical-align:top;">
                <div class="chart-box">
                    <div class="chart-title">По реакциям</div>
                    <img src="{{ $reactionsChart }}" style="width:100%;">
                </div>
            </td>
        </tr>
    </table>

    <div style="margin-top:25px;">
        <div class="chart-box">
            <div class="chart-title">По всем действиям</div>
            <img src="{{ $allChart }}" style="width:100%;">
        </div>
    </div>
</div>
