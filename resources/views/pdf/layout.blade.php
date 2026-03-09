<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">

<style>

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #1f2937;
    line-height: 1.5;
}

/* PAGE BREAK */

.page-break {
    page-break-before: always;
}

/* ===== HEADER ===== */

.report-header {
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #2563eb;
}

.report-title {
    font-size: 20px;
    font-weight: bold;
    color: #1e3a8a;
}

.report-date {
    font-size: 11px;
    color: #6b7280;
    margin-top: 4px;
}

/* ===== SECTION ===== */

.section {
    margin-bottom: 22px;
}

.section-title {
    font-size: 14px;
    font-weight: bold;
    color: #111827;
    margin-bottom: 10px;
    border-left: 4px solid #2563eb;
    padding-left: 8px;
}

/* ===== TABLE META ===== */

table.meta-table {
    width: 100%;
    border-collapse: collapse;
}

table.meta-table td {
    padding: 7px 10px;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: top;
}

table.meta-table td.label {
    width: 30%;
    font-weight: bold;
    color: #374151;
    background-color: #f9fafb;
}

table.meta-table td.value {
    width: 70%;
}

/* ===== DESCRIPTION ===== */

.description-box {
    margin-top: 12px;
    padding: 10px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
}

.description-box pre {
    font-family: DejaVu Sans, sans-serif;
    white-space: pre-wrap;
    word-wrap: break-word;
    margin: 0;
}

/* ===== TAGS ===== */

.tags {
    margin-top: 8px;
}

.tag {
    display: inline-block;
    font-size: 10px;
    padding: 3px 6px;
    margin: 2px 4px 2px 0;
    background: #e5e7eb;
    color: #374151;
    border-radius: 3px;
}

/* ===== CHARTS ===== */

.chart-container {
    margin-bottom: 35px;
    padding: 15px;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
}

.chart-title {
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 8px;
    color: #1e3a8a;
}

.chart-block-title {
    font-size: 13px;
    font-weight: bold;
    color: #1e3a8a;
    margin-bottom: 10px;
    padding-bottom: 6px;
    border-bottom: 1px solid #e5e7eb;
}

.mini-description {
    font-size: 10px;
    color: #6b7280;
    margin-top: 6px;
}

/* ===== LEADERS TABLE ===== */

.leaders-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
}

.leaders-table th {
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
    padding: 6px 4px;
    background: #f3f4f6;
}

.leaders-table td {
    padding: 5px 4px;
    border-bottom: 1px solid #f1f1f1;
}

.color-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 4px;
}

/* ===== SHARE BOX ===== */

.share-box {
    margin-top: 10px;
    font-size: 11px;
    color: #374151;
    background: #f9fafb;
    padding: 6px 8px;
    border-radius: 4px;
}

/* ===== FOOTER ===== */

.report-footer {
    margin-top: 30px;
    padding-top: 10px;
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
