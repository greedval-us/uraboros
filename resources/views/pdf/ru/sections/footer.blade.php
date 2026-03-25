<div class="report-section-footer">
    <div class="footer-date">
        <strong>{{ config('app.name') }}</strong> - Аналитический отчет
    </div>
    <div style="margin-top: 8px; line-height: 1.8; color: #4b5563; font-size: 9px;">
        Документ создан: {{ now()->format('d.m.Y') }}<br>
        Этот отчет содержит конфиденциальную информацию.<br>
        (c) {{ now()->year }} Все права защищены.
    </div>
</div>
