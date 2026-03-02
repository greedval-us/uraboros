<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; } h2 {
        font-size: 15px;
        margin-bottom: 8px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .info-table td {
        padding: 6px 8px;
        vertical-align: top;
    }

    .info-table .label {
        width: 30%;
        font-weight: bold;
        background: #f3f3f3;
    }

    .info-table .value {
        width: 70%;
    }

    .description {
        margin-top: 10px;
    }

    .description-text {
        margin-top: 4px;
        white-space: normal;
        word-wrap: break-word;
    }

    .flags {
        margin-top: 8px;
        font-size: 11px;
        color: #555;
    }

    hr {
        margin: 12px 0;
        border: none;
        border-top: 1px solid #ddd;
    }

    </style>
</head>
<body>

@foreach($sections as $section)
    @include($section->view(), $section->data())
@endforeach

</body>
</html>
