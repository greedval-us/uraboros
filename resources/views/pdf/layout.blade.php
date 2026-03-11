<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">

<style>

/* ===== Общие стили документа ===== */
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #1f2937;
    line-height: 1.5;
    background-color: #f9fafb;
    margin: 0;
    padding: 0;
}

/* ===== PAGE BREAK ===== */
.page-break {
    page-break-before: always;
}

/* ===== HEADER ===== */
.report-header {
    margin-bottom: 20px;
    padding: 12px 20px;
    background-color: #e0f2fe;
    border-left: 6px solid #2563eb;
    border-radius: 6px;
}

.report-title {
    font-size: 20px;
    font-weight: bold;
    color: #1e3a8a;
    margin: 0;
}

.report-date {
    font-size: 11px;
    color: #6b7280;
    margin-top: 2px;
}

/* ===== SECTIONS ===== */
.section {
    margin: 25px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    page-break-inside: avoid;
}

.section-title {
    font-size: 16px;
    font-weight: bold;
    color: #111827;
    margin-bottom: 12px;
    border-left: 4px solid #2563eb;
    padding-left: 10px;
}

.subsection-title {
    font-size: 14px;
    font-weight: 600;
    color: #1e3a8a;
    margin: 18px 0 10px;
    border-left: 3px solid #3b82f6;
    padding-left: 8px;
}

/* ===== TEXT & LISTS ===== */
p {
    margin: 10px 0;
}

ul {
    margin: 8px 0 12px 20px;
    color: #4b5563;
}

ul li {
    margin-bottom: 5px;
}

/* ===== DESCRIPTION BOX ===== */
.description-box {
    margin-top: 10px;
    padding: 12px;
    background-color: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 12px;
}

.description-box pre {
    white-space: pre-wrap;
    word-wrap: break-word;
    margin: 0;
}

/* ===== CHART CONTAINERS ===== */
.chart-container {
    margin-top: 18px;
    padding: 12px;
    background-color: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    text-align: center;
}

.chart-block-title {
    font-size: 13px;
    font-weight: bold;
    color: #1e3a8a;
    margin-bottom: 10px;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 4px;
}

.mini-description {
    font-size: 10px;
    color: #6b7280;
    margin-top: 6px;
}

/* ===== TABLES ===== */
.leaders-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    margin-top: 12px;
}

.leaders-table th {
    text-align: left;
    padding: 6px 8px;
    background-color: #e0f2fe;
    color: #1e3a8a;
    border-bottom: 1px solid #cbd5e1;
}

.leaders-table td {
    padding: 5px 8px;
    border-bottom: 1px solid #f1f5f9;
}

.leaders-table tbody tr:nth-child(even) {
    background-color: #f9fafb;
}

.leaders-table tbody tr:hover {
    background-color: #e0f2fe;
    transition: background-color 0.2s ease;
}

/* ===== COLOR DOT (для визуализации) ===== */
.color-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 4px;
}

/* ===== TAGS ===== */
.tag {
    display: inline-block;
    font-size: 10px;
    padding: 2px 6px;
    margin: 2px 3px 2px 0;
    background-color: #e5e7eb;
    color: #374151;
    border-radius: 4px;
}

/* ===== SHARE BOX ===== */
.share-box {
    margin-top: 10px;
    font-size: 11px;
    color: #374151;
    background-color: #f3f4f6;
    padding: 6px 10px;
    border-radius: 6px;
}

/* ===== FOOTER ===== */
.report-footer {
    margin-top: 30px;
    padding: 12px 0;
    border-top: 1px solid #e5e7eb;
    font-size: 10px;
    color: #6b7280;
    text-align: center;
}

</style>
</head>

<body>

{{-- ===== RENDER REPORT SECTIONS ===== --}}

@foreach($sections as $section)

    @include($section->view(), $section->data())

@endforeach

</body>
</html>
