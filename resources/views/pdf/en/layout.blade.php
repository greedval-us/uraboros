<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; }
    </style>
</head>
<body>

@foreach($sections as $section)
    @include($section->view(), $section->data())
@endforeach

</body>
</html>
