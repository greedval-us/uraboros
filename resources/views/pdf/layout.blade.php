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

        /* ===== SECTIONS ===== */
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

        /* ===== TABLE ===== */
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

@foreach($sections as $section)
    @include($section->view(), $section->data())
@endforeach

<div class="report-footer">
    Отчет сформирован автоматически • {{ config('app.name') }}
</div>

</body>
</html>
