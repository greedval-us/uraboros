<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: DejaVu Sans, serif;
    font-size: 12px;
    color: #374151;
    line-height: 1.6;
    background-color: #f9fafb;
}

/* ### HEADER & FOOTER ### */
.document-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 30px;
    margin-bottom: 20px;
    border-radius: 8px;
    page-break-inside: avoid;
}

.header-top {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 20px;
}

.header-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

.header-subtitle {
    font-size: 13px;
    opacity: 0.95;
    margin-bottom: 15px;
}

.header-meta {
    display: table;
    width: 100%;
    border-collapse: collapse;
    font-size: 10px;
    opacity: 0.9;
}

.header-meta tr {
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.header-meta td {
    padding: 6px 0;
    padding-right: 20px;
}

.header-date, .header-period {
    font-weight: 500;
}

/* ### PAGE BREAKS ### */
.page-break {
    page-break-before: always;
    margin-top: 0;
}

/* ### SECTIONS ### */
.report-section {
    margin-bottom: 25px;
    padding: 25px;
    background-color: #ffffff;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    page-break-inside: avoid;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.report-section:first-of-type {
    margin-top: 0;
}

.report-section p {
    margin-bottom: 12px;
    text-align: justify;
    font-size: 12px;
    line-height: 1.65;
}

.report-section p:last-child {
    margin-bottom: 0;
}

.report-section ul {
    margin: 12px 0 12px 20px;
    padding-left: 5px;
    font-size: 12px;
}

.report-section li {
    margin-bottom: 5px;
    list-style-type: disc;
    font-size: 12px;
}

/* ### TITLES ### */
.report-section-title {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 15px;
    padding-bottom: 12px;
    border-bottom: 3px solid #3b82f6;
    display: block;
}

.report-subsection-title {
    font-size: 13px;
    font-weight: 700;
    color: #1f2937;
    margin: 18px 0 10px;
    padding-left: 12px;
    border-left: 4px solid #60a5fa;
    display: block;
}

/* ### METRICS BOX ### */
.metrics-box {
    background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 100%);
    border-left: 4px solid #0ea5e9;
    padding: 15px;
    margin: 15px 0;
    border-radius: 6px;
}

.metric-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 12px;
    border-bottom: 1px dotted #cbd5e1;
}

.metric-row:last-child {
    border-bottom: none;
}

.metric-label {
    color: #6b7280;
    font-weight: 500;
}

.metric-value {
    color: #111827;
    font-weight: 700;
}

/* ### CHARTS ### */
.report-chart {
    margin: 20px 0;
    padding: 15px;
    background-color: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    text-align: center;
    page-break-inside: avoid;
}

.report-chart img {
    max-width: 100%;
    height: auto;
    margin-top: 10px;
}

.report-chart-title {
    font-size: 12px;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 2px solid #bfdbfe;
}

.report-caption {
    font-size: 10px;
    color: #6b7280;
    margin-top: 8px;
    font-style: italic;
}

/* ### TABLES ### */
.report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    margin: 15px 0;
    page-break-inside: avoid;
}

.report-table-title {
    font-size: 12px;
    font-weight: 700;
    color: #1f2937;
    margin: 20px 0 10px;
    padding-bottom: 8px;
    border-bottom: 2px solid #3b82f6;
    display: block;
}

.report-table th {
    text-align: left;
    padding: 8px 10px;
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: #ffffff;
    font-weight: 700;
    border: none;
    font-size: 11px;
}

.report-table td {
    padding: 6px 10px;
    border-bottom: 1px solid #e5e7eb;
    color: #374151;
}

.report-table tbody tr {
    transition: background-color 0.1s;
}

.report-table tbody tr:nth-child(odd) {
    background-color: #f9fafb;
}

.report-table tbody tr:nth-child(even) {
    background-color: #ffffff;
}

.report-table tbody tr:hover {
    background-color: #f0f9ff;
}

.report-table tbody tr:last-child td {
    border-bottom: 2px solid #3b82f6;
}

/* ### SPECIAL TEXT ### */
.description-box {
    background-color: #fef3c7;
    padding: 15px;
    margin: 15px 0;
    border-radius: 6px;
    border-left: 4px solid #f59e0b;
}

.description-box pre,
.description-box code {
    font-family: 'DejaVu Sans Mono', 'Courier New', monospace;
    white-space: pre-wrap;
    word-wrap: break-word;
    margin: 0;
    font-size: 10px;
    color: #92400e;
}

/* ### FOOTER ### */
.report-section-footer {
    margin-top: 40px;
    padding-top: 15px;
    border-top: 2px solid #e5e7eb;
    font-size: 10px;
    color: #6b7280;
    text-align: center;
    page-break-inside: avoid;
}

.footer-date {
    margin-bottom: 8px;
    font-weight: 500;
}

.footer-page {
    font-size: 9px;
}

/* ### HIGHLIGHTS & BADGES ### */
.badge {
    display: inline-block;
    padding: 4px 10px;
    background-color: #dbeafe;
    color: #1e3a8a;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
    margin: 0 4px 0 0;
}

.badge.success {
    background-color: #dcfce7;
    color: #166534;
}

.badge.warning {
    background-color: #fef3c7;
    color: #92400e;
}

.badge.danger {
    background-color: #fee2e2;
    color: #991b1b;
}

strong {
    color: #111827;
    font-weight: 700;
}

/* ### PRINT OPTIMIZATION ### */
@media print {
    body {
        background-color: white;
    }

    .report-section {
        page-break-inside: avoid;
        box-shadow: none;
        border: 1px solid #d1d5db;
    }

    .page-break {
        page-break-before: always;
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
