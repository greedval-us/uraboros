<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">

<style>

body {
    font-family: dejavusans, sans-serif;
    font-size: 12px;
    color: #1f2937;
    line-height: 1.5;
}

.page-break {
    page-break-before: always;
}

.report-section {
    margin-bottom: 25px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    page-break-inside: avoid;
}

.report-section-title {
    font-size: 16px;
    font-weight: bold;
    color: #111827;
    margin-bottom: 12px;
    border-left: 4px solid #2563eb;
    padding-left: 10px;
}

.report-subsection-title {
    font-family: dejavusans, sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #1e3a8a;
    margin: 15px 0 8px;
    border-left: 3px solid #3b82f6;
    padding-left: 8px;
}

.report-chart {
    margin-top: 18px;
    padding: 12px;
    background-color: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    text-align: center;
}

.report-chart-title {
    font-size: 13px;
    font-weight: bold;
    color: #1e3a8a;
    margin-bottom: 8px;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 4px;
}

.report-caption {
    font-size: 10px;
    color: #6b7280;
    margin-top: 6px;
}

.report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    margin-top: 10px;
}

.report-table th {
    text-align: left;
    padding: 6px 8px;
    background-color: #e0f2fe;
    color: #1e3a8a;
    border-bottom: 1px solid #cbd5e1;
}

.report-table td {
    padding: 5px 8px;
    border-bottom: 1px solid #f1f5f9;
}

.report-table tbody tr:nth-child(even) {
    background-color: #f9fafb;
}

.description-box pre {
    font-family: 'DejaVu Sans', 'Courier New', monospace;
    white-space: pre-wrap;
    word-wrap: break-word;
    margin: 0;
}

.report-section-footer {
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
