<div class="report-section-footer">
    <div class="footer-date">
        <strong>{{ config('app.name') }}</strong> — Analytics Report
    </div>
    <div style="margin-top: 12px; line-height: 1.9; color: #6b7280; font-size: 10px;">
        Generated: {{ now()->format('d.m.Y H:i') }}<br>
        This report contains confidential information.<br>
        (c) {{ now()->year }} All rights reserved.
    </div>
</div>
