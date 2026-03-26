<div class="report-section-footer">
    <div class="footer-date">
        <strong>{{ config('app.name') }}</strong> — Аналитический отчет
    </div>
    <div style="margin-top: 6px; line-height: 1.6; font-size: 9px;">
        Документ создан: {{ now()->format('d.m.Y в H:i') }}<br>
        Этот отчет содержит конфиденциальную информацию.<br>
        © {{ now()->year }} Все права защищены.
    </div>
</div>
