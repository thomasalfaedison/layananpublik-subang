<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Layanan Detail</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; }
        h2 { margin: 0 0 10px 0; }
        h3 { margin: 15px 0 8px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #444; padding: 6px; vertical-align: top; }
        th { background: #f0f0f0; text-align: left; }
        .no-border td, .no-border th { border: 0; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    @foreach ($details as $detail)
        @php
            $model = $detail['model'];
            $allLayananKomponen = $detail['allLayananKomponen'];
        @endphp

        @include('layanan._export-pdf-detail')

        @if (! $loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
