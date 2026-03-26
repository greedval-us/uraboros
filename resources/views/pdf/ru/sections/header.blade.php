<div class="document-header">
    <div class="header-top">
        <div style="flex: 1;">
            <div class="header-title">{{ $reportTitle ?? 'Аналитический отчет' }}</div>
            <div class="header-subtitle">{{ $reportSubtitle ?? 'Детальный анализ показателей сообщества' }}</div>
        </div>
        <div class="header-badge">Отчет</div>
    </div>

    <table class="header-meta">
        <tr>
            <td style="width: 50%;">
                <span class="header-meta-label">Период анализа</span>
                <span class="header-meta-value">{{ $periodStart ?? '****' }} — {{ $periodEnd ?? '****' }}</span>
            </td>
            <td style="width: 50%;">
                <span class="header-meta-label">Дата формирования</span>
                <span class="header-meta-value">{{ now()->format('d.m.Y H:i') }}</span>
            </td>
        </tr>
    </table>
</div>
