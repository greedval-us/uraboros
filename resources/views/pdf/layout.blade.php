<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
@font-face {
    font-family: DejaVu Sans;
    src: local('DejaVu Sans');
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
    color-adjust: exact !important;
}

body {
    font-family: Helvetica, 'Courier New', monospace;
    font-size: 11px;
    color: #1f2937;
    line-height: 1.7;
    background-color: white;
}

/* ### HEADER & FOOTER ### */
.document-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 35px;
    margin-bottom: 30px;
    border-radius: 0;
    page-break-inside: avoid;
}

.header-top {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 25px;
    gap: 20px;
}

.header-title {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
    line-height: 1.2;
}

.header-subtitle {
    font-size: 14px;
    opacity: 0.95;
    margin-bottom: 15px;
    font-weight: 400;
    line-height: 1.4;
}

.header-meta {
    display: table;
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    opacity: 0.95;
}

.header-meta tr {
    border-bottom: 1px solid rgba(255,255,255,0.3);
}

.header-meta td {
    padding: 8px 0;
    padding-right: 25px;
    vertical-align: top;
}

.header-date, .header-period {
    font-weight: 600;
    font-size: 12px;
}

/* ### PAGE BREAKS ### */
.page-break {
    page-break-before: always;
    margin-top: 0;
    padding-top: 0;
}

/* ### SECTIONS ### */
.report-section {
    margin-bottom: 30px;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 0;
    border: 1px solid #d1d5db;
    border-top: 4px solid #3b82f6;
    page-break-inside: auto;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}

.report-section:first-of-type {
    margin-top: 0;
}

.report-section p {
    margin-bottom: 14px;
    text-align: left;
    font-size: 11px;
    line-height: 1.8;
    color: #374151;
}

.report-section p:last-child {
    margin-bottom: 0;
}

.report-section ul, .report-section ol {
    margin: 14px 0 14px 25px;
    padding-left: 0;
    font-size: 11px;
}

.report-section li {
    margin-bottom: 8px;
    list-style-type: disc;
    font-size: 11px;
    line-height: 1.6;
    color: #374151;
}

/* ### TITLES ### */
.report-section-title {
    font-size: 20px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 3px solid #3b82f6;
    display: block;
    letter-spacing: -0.3px;
    line-height: 1.3;
}

.report-subsection-title {
    font-size: 14px;
    font-weight: 700;
    color: #1f2937;
    margin: 24px 0 12px;
    padding-left: 14px;
    border-left: 4px solid #60a5fa;
    display: block;
    letter-spacing: -0.2px;
    line-height: 1.4;
}

/* ### METRICS BOX ### */
.metrics-box {
    background: linear-gradient(135deg, #f0f9ff 0%, #cfe9ff 100%);
    border-left: 5px solid #0ea5e9;
    border-radius: 0;
    padding: 18px;
    margin: 18px 0;
}

.metric-row {
    display: flex;
    justify-content: space-between;
    padding: 9px 0;
    font-size: 11px;
    border-bottom: 1px dotted #bae6fd;
    align-items: center;
}

.metric-row:last-child {
    border-bottom: none;
}

.metric-label {
    color: #0c4a6e;
    font-weight: 500;
    flex: 1;
}

.metric-value {
    color: #164e63;
    font-weight: 700;
    text-align: right;
    min-width: 80px;
}

/* ### CHARTS ### */
.report-chart {
    margin: 22px 0;
    padding: 16px;
    background-color: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 0;
    text-align: center;
    page-break-inside: avoid;
}

.report-chart img {
    max-width: 100%;
    height: auto;
    margin-top: 12px;
}

.report-chart-title {
    font-size: 13px;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 2px solid #bfdbfe;
}

.report-caption {
    font-size: 10px;
    color: #6b7280;
    margin-top: 10px;
    font-style: italic;
}

/* ### TABLES ### */
.report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    margin: 16px 0;
    page-break-inside: avoid;
}

.report-table-title {
    font-size: 13px;
    font-weight: 700;
    color: #1f2937;
    margin: 24px 0 12px;
    padding-bottom: 10px;
    border-bottom: 2px solid #3b82f6;
    display: block;
}

.report-table th {
    text-align: left;
    padding: 11px 12px;
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: #ffffff;
    font-weight: 700;
    border: none;
    font-size: 11px;
    line-height: 1.4;
}

.report-table td {
    padding: 9px 12px;
    border-bottom: 1px solid #e5e7eb;
    color: #374151;
    font-size: 11px;
    line-height: 1.6;
}

.report-table tbody tr {
    page-break-inside: avoid;
}

.report-table tbody tr:nth-child(odd) {
    background-color: #f9fafb;
}

.report-table tbody tr:nth-child(even) {
    background-color: #ffffff;
}

.report-table tbody tr:last-child td {
    border-bottom: 2px solid #3b82f6;
}

/* Table labels and values for group-info */
.report-table-label {
    font-weight: 600;
    color: #1f2937;
    background-color: #f3f4f6;
    padding: 10px 12px;
    width: 35%;
}

.report-table-value {
    color: #374151;
    padding: 10px 12px;
}

/* ### SPECIAL TEXT ### */
.description-box, .report-description {
    background-color: #fef3c7;
    padding: 16px;
    margin: 16px 0;
    border-radius: 0;
    border-left: 4px solid #f59e0b;
}

.description-box pre,
.description-box code,
.report-description pre,
.report-description code {
    font-family: 'DejaVu Sans Mono', 'Courier New', monospace;
    white-space: pre-wrap;
    word-wrap: break-word;
    margin: 8px 0 0 0;
    font-size: 10px;
    color: #78350f;
    line-height: 1.5;
}

.description-box strong,
.report-description strong {
    color: #92400e;
    font-weight: 700;
}

.report-tags {
    margin: 12px 0;
}

.report-tag {
    display: inline-block;
    padding: 6px 12px;
    background-color: #dbeafe;
    color: #1e3a8a;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
    margin: 4px 6px 4px 0;
    border: 1px solid #bfdbfe;
}

/* ### FOOTER ### */
.report-section-footer {
    margin-top: 50px;
    padding-top: 20px;
    border-top: 2px solid #d1d5db;
    font-size: 10px;
    color: #6b7280;
    text-align: center;
    page-break-inside: avoid;
    line-height: 1.8;
}

.footer-date {
    margin-bottom: 10px;
    font-weight: 600;
    color: #374151;
}

.footer-page {
    font-size: 9px;
    color: #9ca3af;
}

/* ### HIGHLIGHTS & BADGES ### */
.badge {
    display: inline-block;
    padding: 5px 12px;
    background-color: #dbeafe;
    color: #1e3a8a;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    margin: 0 4px 0 0;
    border: 1px solid #bfdbfe;
}

.badge.success {
    background-color: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.badge.warning {
    background-color: #fef3c7;
    color: #b45309;
    border-color: #fde68a;
}

.badge.danger {
    background-color: #fee2e2;
    color: #991b1b;
    border-color: #fecaca;
}

strong {
    color: #111827;
    font-weight: 700;
}

/* ### PRINT OPTIMIZATION ### */
@media print {
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
    }

    html {
        margin: 0;
        padding: 0;
    }

    body {
        margin: 0;
        padding: 0;
        background-color: white;
        font-size: 11px;
    }

    .report-section {
        page-break-inside: auto;
        box-shadow: none;
        border: 1px solid #d1d5db;
        margin-bottom: 25px;
    }

    .report-section:last-child {
        margin-bottom: 0;
    }

    .page-break {
        page-break-before: always;
        margin-top: 0;
        padding-top: 0;
    }

    .report-chart,
    .metrics-box {
        page-break-inside: avoid;
    }

    .report-table {
        page-break-inside: auto;
    }

    .report-table tbody tr {
        page-break-inside: avoid;
    }
}
</style>
</head>

<body>

@foreach($sections as $section)

    @include($section->view(), $section->data())

@endforeach

</body>
</html>
