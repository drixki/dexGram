<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    
    <!-- icon-->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Photopie') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

    {{-- CSS --}}
    <link id="themeColors" rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" />

    {{-- CSS LAYOUTS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-layouts.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">

    {{-- STACK STYLE --}}
    @stack('style')

    <style>
        #toast-container {
            top: 15px;
        }

        #list-search-photos {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
            alt="loader" class="lds-ripple img-fluid" />
    </div>

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header w-100">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link sidebartoggler nav-icon-hover ms-n3 cursor-pointer" id="headerCollapse"
                                data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                                aria-controls="offcanvasWithBothOptions">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link nav-icon-hover" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="ti ti-search"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="d-block d-lg-none">
                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/dark-logo.svg"
                            class="dark-logo" width="50" alt="" />
                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/light-logo.svg"
                            class="light-logo" width="50" alt="" />
                    </div>
                    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="p-2">
                            <i class="ti ti-dots fs-7"></i>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0)"
                                class="nav-link d-flex d-lg-none align-items-center justify-content-center"
                                type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                                aria-controls="offcanvasWithBothOptions">
                                <i class="ti ti-align-justified fs-7"></i>
                            </a>
                            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                                <li class="nav-item dropdown">
                                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <div class="user-profile-img">
                                                <img id="photo-profile-nav"
                                                    src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('assets/images/profile/user-1.jpg') }}"
                                                    class="rounded-circle" style="object-fit: cover" width="35"
                                                    height="35" alt="" />
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                        aria-labelledby="drop1">
                                        <div class="profile-dropdown position-relative" data-simplebar>
                                            <div class="py-3 px-7 pb-0">
                                                <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                            </div>
                                            <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                <img id="photo-profile-master"
                                                    src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('assets/images/profile/user-1.jpg') }}"
                                                    class="rounded-circle" style="object-fit: cover" width="80"
                                                    height="80" alt="" />
                                                <div class="ms-3">
                                                    <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                                                    <span class="mb-1 d-block text-dark">User</span>
                                                    <p class="mb-0 d-flex text-dark align-items-center gap-2">
                                                        <i class="ti ti-mail fs-4"></i>{{ Auth::user()->email }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="message-body">

                                            </div>
                                            <div class="d-grid py-4 px-7 pt-8">
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                    class="btn btn-outline-danger">Log Out</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    style="display: none;">{{ csrf_field() }}</form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!--  Mobilenavbar -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <nav class="sidebar-nav scroll-sidebar">
            <div class="offcanvas-header justify-content-between">
                <img src="{{ asset('assets/icon/favicon.ico') }}"
                    alt="" class="img-fluid">
                <h2 class="mb-0 fs-8 fw-bolder">Dexgram</h2>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body profile-dropdown mobile-navbar" data-simplebar="" data-simplebar>
                <ul id="sidebarnav">
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('home') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-home"></i>
                            </span>
                            <span class="hide-menu">Beranda</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('my-photo') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-photo"></i>
                            </span>
                            <span class="hide-menu">Foto Saya</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('my-album') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-album"></i>
                            </span>
                            <span class="hide-menu">Album Saya</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('liked-photos') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-photo-heart"></i>
                            </span>
                            <span class="hide-menu">Foto Favorit</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('my-category') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-category"></i>
                            </span>
                            <span class="hide-menu">Kategori Saya</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!--  Search Bar -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-1">
                <div class="modal-header border-bottom">
                    <input type="search" class="form-control fs-3" placeholder="Cari disini" id="search" />
                    <span data-bs-dismiss="modal" class="lh-1 cursor-pointer">
                        <i class="ti ti-x fs-5 ms-3"></i>
                    </span>
                </div>
                <div class="modal-body message-body" data-simplebar="">
                    <h5 class="mb-0 fs-5 p-1">Cari Foto</h5>
                    <ul class="list mb-0 py-2">
                        <li class="p-1 mb-1 bg-hover-light-black" id="list-search-photos">
                            Temukan foto dengan inputkan kata kunci!
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--  Import Js Files -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--  core files -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!--  current page js files -->
    <script src="{{ asset('assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/toastr-init.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    {{-- Ajax Setup --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    {{-- Ajax Setup --}}

    {{-- Ajax search  photos --}}
    <script>
        $(document).ready(function() {
            $('#search').on('input', function() {
                const keyword = $(this).val();
                const url = '{{ route('search-photos') }}';

                if (keyword !== '') {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: {
                            keyword: keyword
                        },
                        success: function(response) {
                            var list = $('#list-search-photos');
                            list.empty();

                            if (response.length > 0) {
                                // Jika ada hasil pencarian, tambahkan hasil ke daftar
                                $.each(response, function(index, photo) {
                                    var listItem = `
                                    <li class="p-1 mb-1 bg-hover-light-black">
                                        <a href="view-detail-photo/${photo.slug}">
                                            <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                <img src="/storage/${photo.file_path}" class="rounded-2" style="object-fit: cover" width="80" height="80" alt="" />
                                                <div class="ms-3">
                                                    <h5 class="mb-1 fs-3">${photo.title}</h5>
                                                    ${photo.description ? `<span class="mb-1 d-block text-dark">${photo.description}</span>` : ''}
                                                    <p class="mb-0 d-flex text-dark align-items-center gap-2">
                                                        <i class="ti ti-user fs-4"></i>${photo.belongs_to_user.name}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                `;
                                    list.append(listItem);
                                });
                            } else {
                                // Jika tidak ada hasil, tampilkan pesan "Foto tidak ditemukan"
                                list.html(
                                    '<li class="p-1 mb-1 bg-hover-light-black">Foto tidak ditemukan</li>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    var list = $('#list-search-photos');
                    list.html(
                        '<li class="p-1 mb-1 bg-hover-light-black">Temukan foto dengan inputkan kata kunci!</li>'
                    );
                }
            });
        });
    </script>
    {{-- Ajax search  photos --}}

    {{-- STACK SCRIPT --}}
    @stack('script')

    <script>
        toastr.options = {
            "positionClass": "toast-top-center",
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 3000,
        };
        @if (session()->has('error'))
            toastr.error('{{ session('error') }}');
        @elseif (session()->has('success'))
            toastr.success('{{ session('success') }}');
        @elseif (session()->has('warning'))
            toastr.warning('{{ session('warning') }}');
        @endif
    </script>
</body>

</html>
