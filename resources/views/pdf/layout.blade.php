<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Аналитический отчет</title>

<style>
/* === BASE RESET & TYPOGRAPHY === */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    font-size: 11px;
}

body {
    font-family: "DejaVu Sans", sans-serif;
    font-size: 11px;
    color: #1a1a2e;
    line-height: 1.6;
    background-color: #ffffff;
}

/* === DOCUMENT HEADER === */
.document-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0ea5e9 100%);
    color: #ffffff;
    padding: 24px 28px;
    margin-bottom: 16px;
    page-break-inside: avoid;
    position: relative;
    overflow: hidden;
}

.document-header::before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05));
}

.header-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.header-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 6px;
    letter-spacing: -0.3px;
    color: #ffffff;
}

.header-subtitle {
    font-size: 11px;
    opacity: 0.9;
    margin-bottom: 0;
    color: #e0f2fe;
}

.header-badge {
    background: rgba(255,255,255,0.15);
    padding: 6px 14px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.header-meta {
    display: table;
    width: 100%;
    border-collapse: collapse;
    font-size: 10px;
}

.header-meta tr {
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.header-meta tr:last-child {
    border-bottom: none;
}

.header-meta td {
    padding: 8px 0;
    vertical-align: top;
}

.header-meta-label {
    font-size: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.7;
    display: block;
    margin-bottom: 2px;
}

.header-meta-value {
    font-weight: 600;
    font-size: 11px;
}

/* === PAGE BREAKS === */
.page-break {
    page-break-before: always;
    margin-top: 0;
    padding-top: 0;
}

/* === SECTIONS === */
.report-section {
    margin-bottom: 16px;
    padding: 20px 24px;
    background-color: #ffffff;
    page-break-inside: avoid;
}

.report-section p {
    margin-bottom: 10px;
    text-align: justify;
    font-size: 11px;
    line-height: 1.6;
    color: #374151;
}

.report-section p:last-child {
    margin-bottom: 0;
}

.report-section ul {
    margin: 10px 0 10px 18px;
    font-size: 11px;
}

.report-section li {
    margin-bottom: 4px;
    list-style-type: disc;
    color: #374151;
}

/* === SECTION TITLES === */
.report-section-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 2px solid #0ea5e9;
    display: block;
}

.report-subsection-title {
    font-size: 12px;
    font-weight: 700;
    color: #1e3a5f;
    margin: 16px 0 10px;
    padding-left: 10px;
    border-left: 3px solid #0ea5e9;
    display: block;
}

/* === METRICS BOX === */
.metrics-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-left: 3px solid #0ea5e9;
    padding: 14px 16px;
    margin: 14px 0;
    border-radius: 4px;
}

.metrics-box-title {
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 10px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.metric-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    font-size: 11px;
    border-bottom: 1px solid #e2e8f0;
}

.metric-row:last-child {
    border-bottom: none;
}

.metric-label {
    color: #64748b;
    font-weight: 400;
}

.metric-value {
    color: #0f172a;
    font-weight: 700;
}

/* === CHARTS === */
.report-chart {
    margin: 16px 0;
    padding: 14px;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    text-align: center;
    page-break-inside: avoid;
}

.report-chart img {
    max-width: 100%;
    height: auto;
}

.report-chart-title {
    font-size: 11px;
    font-weight: 700;
    color: #1e3a5f;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid #cbd5e1;
    text-align: left;
}

.report-caption {
    font-size: 9px;
    color: #64748b;
    margin-top: 8px;
    font-style: italic;
}

/* === TABLES === */
.report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10px;
    margin: 12px 0;
}

.report-table-title {
    font-size: 11px;
    font-weight: 700;
    color: #0f172a;
    margin: 16px 0 10px;
    padding-bottom: 6px;
    border-bottom: 1px solid #cbd5e1;
    display: block;
}

.report-table th {
    text-align: left;
    padding: 8px 10px;
    background-color: #0f172a;
    color: #ffffff;
    font-weight: 700;
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.report-table td {
    padding: 7px 10px;
    border-bottom: 1px solid #e2e8f0;
    color: #374151;
    font-size: 10px;
}

.report-table tbody tr:nth-child(odd) {
    background-color: #f8fafc;
}

.report-table tbody tr:nth-child(even) {
    background-color: #ffffff;
}

.report-table tbody tr:last-child td {
    border-bottom: 1px solid #cbd5e1;
}

/* === SPECIAL BOXES === */
.description-box {
    background-color: #fffbeb;
    padding: 14px 16px;
    margin: 14px 0;
    border-radius: 4px;
    border-left: 3px solid #f59e0b;
}

.description-box pre,
.description-box code {
    font-family: "DejaVu Sans Mono", monospace;
    white-space: pre-wrap;
    word-wrap: break-word;
    margin: 0;
    font-size: 9px;
    color: #92400e;
}

.note-box {
    background-color: #f0f9ff;
    padding: 12px 14px;
    margin: 14px 0;
    border-radius: 4px;
    border-left: 3px solid #0ea5e9;
    font-size: 10px;
    color: #0369a1;
}

/* === FOOTER === */
.report-section-footer {
    margin-top: 24px;
    padding: 14px;
    background-color: #f8fafc;
    border-top: 1px solid #e2e8f0;
    font-size: 9px;
    color: #64748b;
    text-align: center;
    page-break-inside: avoid;
}

.footer-date {
    margin-bottom: 4px;
    font-weight: 500;
}

.footer-page {
    font-size: 8px;
}

/* === BADGES === */
.badge {
    display: inline-block;
    padding: 3px 8px;
    background-color: #dbeafe;
    color: #1e3a5f;
    border-radius: 3px;
    font-size: 9px;
    font-weight: 600;
    margin: 0 3px 0 0;
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
    color: #0f172a;
    font-weight: 700;
}

/* === PRINT OPTIMIZATION === */
@media print {
    body {
        background-color: #ffffff;
    }

    .report-section {
        page-break-inside: avoid;
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
