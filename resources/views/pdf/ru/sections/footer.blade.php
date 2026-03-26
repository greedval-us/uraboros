<div class="report-section-footer">
    <div class="footer-date">
        <strong>{{ config('app.name') }}</strong> — Аналитический отчет
    </div>
    <div style="margin-top: 12px; line-height: 1.9; color: #6b7280; font-size: 10px;">
        Документ создан: {{ now()->format('d.m.Y H:i') }}<br>
        Этот отчет содержит конфиденциальную информацию.<br>
        (c) {{ now()->year }} Все права защищены.
    </div>
</div>
