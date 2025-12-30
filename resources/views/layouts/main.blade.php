<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Default') | Layanan Publik Kabupaten Subang</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- AdminLTE 3 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- make browser scroll smooth, when using # for redirect -->
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini {{ isset($_COOKIE['sidebarStatus']) && $_COOKIE['sidebarStatus'] === 'closed' ? 'sidebar-collapse' : '' }}">
    <div class="wrapper">

        {{-- Navbar --}}
        @include('layouts._navbar')

        {{-- Sidebar --}}
        @include('layouts._sidebar')

        {{-- Main Header --}}

        {{-- Content --}}
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">@yield('title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            @isset($breadcrumbs)
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/') }}">
                                            Beranda
                                        </a>
                                    </li>
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        @if (isset($breadcrumb['label']) && isset($breadcrumb['url']) && !$loop->last)
                                            <li class="breadcrumb-item">
                                                <a href="{{ $breadcrumb['url'] }}">
                                                    {{ $breadcrumb['label'] }}
                                                </a>
                                            </li>
                                        @else
                                            <li class="breadcrumb-item active">
                                                {{ $breadcrumb }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            @endisset
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @foreach (['success', 'warning', 'danger'] as $msg)
                        @if (session()->has($msg))
                            <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
                                {{ session(key: $msg) }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                            </div>
                        @endif
                    @endforeach

                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        {{-- Footer --}}
        @include('layouts._footer')

    </div>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <!-- Bootstrap 4 & Popper.js Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <!-- Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js Data Labels plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        if (window.Chart && window.ChartDataLabels) {
            Chart.register(ChartDataLabels);
        }
    </script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        document.querySelectorAll('.ckeditor').forEach(el => {
            ClassicEditor
                .create(el)
                .then(editor => {

                    // Optional: atur width 100% juga
                    const wrapper = editor.ui.view.editable.element.closest('.ck-editor');
                    if (wrapper) wrapper.style.width = '100%';
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

    <script>
        const popupCenter = ({url, title, w, h}) => {
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

            const width = window.innerWidth ?? document.documentElement.clientWidth ?? screen.width;
            const height = window.innerHeight ?? document.documentElement.clientHeight ?? screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft;
            const top = (height - h) / 2 / systemZoom + dualScreenTop;

            const newWindow = window.open(url, title, `
                scrollbars=yes,
                width=${w / systemZoom},
                height=${h / systemZoom},
                top=${top},
                left=${left}
            `);

            if (window.focus) newWindow.focus();
        };
    </script>

    @stack('scripts')
</body>

</html>
