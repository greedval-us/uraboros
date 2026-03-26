<div class="document-header">
    <div class="header-top">
        <div style="flex: 1;">
            <div class="header-title">{{ $reportTitle ?? 'Analytics Report' }}</div>
            <div class="header-subtitle">{{ $reportSubtitle ?? 'Detailed Community Analytics' }}</div>
        </div>
        <div style="text-align: right; font-size: 12px; font-weight: 500;">
            REPORT
        </div>
    </div>

    <table class="header-meta">
        <tr>
            <td style="width: 50%;">
                <span style="opacity: 0.9; display: block; font-size: 9px; margin-bottom: 2px;">ANALYSIS PERIOD</span>
                <span class="header-period">{{ $periodStart ?? '****' }} - {{ $periodEnd ?? '****' }}</span>
            </td>
            <td style="width: 50%;">
                <span style="opacity: 0.9; display: block; font-size: 9px; margin-bottom: 2px;">GENERATED DATE</span>
                <span class="header-date">{{ now()->format('d.m.Y') }}</span>
            </td>
        </tr>
    </table>
</div>
