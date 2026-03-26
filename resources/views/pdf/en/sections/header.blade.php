<div class="document-header">
    <div class="header-top">
        <div style="flex: 1;">
            <div class="header-title">{{ $reportTitle ?? 'Analytics Report' }}</div>
            <div class="header-subtitle">{{ $reportSubtitle ?? 'Detailed community metrics analysis' }}</div>
        </div>
        <div class="header-badge">Report</div>
    </div>

    <table class="header-meta">
        <tr>
            <td style="width: 50%;">
                <span class="header-meta-label">Analysis Period</span>
                <span class="header-meta-value">{{ $periodStart ?? '****' }} — {{ $periodEnd ?? '****' }}</span>
            </td>
            <td style="width: 50%;">
                <span class="header-meta-label">Generated On</span>
                <span class="header-meta-value">{{ now()->format('d.m.Y H:i') }}</span>
            </td>
        </tr>
    </table>
</div>
