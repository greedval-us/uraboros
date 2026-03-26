<div class="document-header">
    <div class="header-top">
        <div style="flex: 1;">
            <div class="header-title">{{ $reportTitle ?? 'Аналитический отчет' }}</div>
            <div class="header-subtitle">{{ $reportSubtitle ?? 'Детальный анализ показателей сообщества' }}</div>
        </div>
        <div style="text-align: right; font-size: 12px; font-weight: 500;">
            📊 ОТЧЕТ
        </div>
    </div>

    <table class="header-meta">
        <tr>
            <td style="width: 50%;">
                <span style="opacity: 0.8; display: block; font-size: 9px; margin-bottom: 2px;">ПЕРИОД АНАЛИЗА</span>
                <span class="header-period">{{ $periodStart ?? '****' }} — {{ $periodEnd ?? '****' }}</span>
            </td>
            <td style="width: 50%;">
                <span style="opacity: 0.8; display: block; font-size: 9px; margin-bottom: 2px;">ДАТА ФОРМИРОВАНИЯ</span>
                <span class="header-date">{{ now()->format('d.m.Y H:i') }}</span>
            </td>
        </tr>
    </table>
</div>
