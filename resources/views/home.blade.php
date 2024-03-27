@extends('layouts.app')

@push('style')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .photo-container {
            width: 100%;
            columns: 4;
            column-gap: 20px
        }

        .photo-container .box {
            width: 100%;
            margin-bottom: 10px;
            break-inside: avoid;
        }

        #img {
            max-width: 100%;
            border-radius: 15px;
        }

        @media (max-width: 1200px) {
            .photo-container {
                width: calc(100% - 40px);
                columns: 3;
            }
        }

        @media (max-width: 768px) {
            .photo-container {
                columns: 2;
            }
        }

        @media (max-width: 480px) {
            .photo-container {
                columns: 1;
            }
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            opacity: 0;
            transition: opacity 0.5s;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
        }

        .overlay:hover {
            opacity: 1;
            /* Munculkan overlay saat dihover */
        }

        .overlay h3 {
            margin: 0;
            padding: 10px;
            text-align: center;
            color: #fff;
        }

        .hover-underline:hover {
            text-decoration: underline;
        }

        .share-btn {
            cursor: pointer;
            /* Menjadikan kursor menjadi tanda tangan saat di hover */
            transition: transform 0.3s;
            /* Mengatur durasi animasi */
        }

        /* Menambahkan transformasi saat tombol dihover */
        .share-btn:hover {
            transform: scale(1.2);
            /* Memperbesar ukuran tombol saat dihover */
        }
    </style>
@endpush

@section('content')
    {{-- Header --}}
    <div class="card w-100 bg-light-info overflow-hidden shadow-none">
        <div class="card-body py-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-6">
                    <h5 class="fw-semibold mb-9 fs-5">Selamat datang di Photopie! {{ Auth::user()->name }}</h5>
                    <p class="mb-9">
                        Upload karyamu disini
                    </p>
                    <a class="btn btn-primary" href="{{ route('create-photo') }}">Upload Foto
                        Sekarang</a>
                </div>
                <div class="col-sm-5">
                    <div class="position-relative mb-n7 text-end">
                        <img src="{{ asset('assets/images/backgrounds/welcome-bg2.png') }}" alt=""
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Header --}}

    {{-- Foto General --}}
    <h4 class="mb-3 fw-semibold">Jelajahi foto..</h4>
    {{-- Card post --}}
    @if ($photos->isNotEmpty())
        <div class="photo-container w-100">
            @foreach ($photos as $item)
                <div class="overflow-hidden box">
                    <div class="position-relative">
                        <a href="{{ route('view-detail-photo', $item->slug) }}">
                            <img id="img" src="{{ Storage::url($item->file_path) }}" class="card-img-top rounded-6"
                                alt="...">
                            <div class="overlay d-flex flex-column">
                                <h3>{{ Str::limit($item->title, 20) }}</h3>
                                <p>{{ Str::limit($item->description, 30) }}</p>
                                <div class="d-flex gap-1 justify-content-center align-items-center fs-6">
                                    {{-- Jumlah Like --}}
                                    <i class="fas fa-heart fs-5"></i>
                                    <span id="like-count">{{ $item->likesCount() }}</span>
                                    {{-- Jumlah Like --}}

                                    {{-- Jumlah View --}}
                                    <i class="ti ti-eye fs-5"></i>
                                    {{ $item->viewsCount() }}
                                    {{-- Jumlah View --}}

                                    {{-- Button share --}}
                                    <i class="ti ti-share share-btn"
                                        onclick="share('{{ route('view-detail-photo', $item->slug) }}')"></i>
                                    {{-- Button share --}}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 pt-1">
                        <div class="d-flex gap-2 align-items-center pt-2">
                            <img class="rounded-circle"
                                src="{{ $item->belongsToUser->avatar ? Storage::url($item->belongsToUser->avatar) : asset('assets/images/profile/user-1.jpg') }}"
                                alt="Profile Picture" style="width: 40px; height: 40px; object-fit: cover">
                            <a href="{{ route('profile-public', encrypt($item->belongsToUser->id)) }}"
                                class="fw-bold text-dark hover-underline">{{ $item->belongsToUser->name }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @include('components.no-data')
    @endif
    {{-- Card post --}}
    {{-- Foto General --}}

    {{-- Foto yang di sukai --}}
    <div class="d-flex justify-content-between pt-5">
        <h4 class="mb-3 fw-semibold">Foto yang anda sukai..</h4>
        <a href="{{ route('liked-photos') }}" class="text-dark hover-underline">Lihat selengkapnya</a>
    </div>
    {{-- Card post --}}
    @if ($likedPhotos->isNotEmpty())
        <div class="photo-container w-100">
            @foreach ($likedPhotos as $item)
                <div class="overflow-hidden box">
                    <div class="position-relative">
                        <a href="{{ route('view-detail-photo', $item->slug) }}">
                            <img id="img" src="{{ Storage::url($item->file_path) }}" class="card-img-top rounded-6"
                                alt="...">
                            <div class="overlay d-flex flex-column">
                                <h3>{{ Str::limit($item->title, 20) }}</h3>
                                <p>{{ Str::limit($item->description, 30) }}</p>
                                <div class="d-flex gap-1 justify-content-center align-items-center fs-6">
                                    {{-- Jumlah Like --}}
                                    <i class="fas fa-heart fs-5"></i>
                                    <span id="like-count">{{ $item->likesCount() }}</span>
                                    {{-- Jumlah Like --}}

                                    {{-- Jumlah View --}}
                                    <i class="ti ti-eye fs-5"></i>
                                    {{ $item->viewsCount() }}
                                    {{-- Jumlah View --}}

                                    {{-- Button share --}}
                                    <i class="ti ti-share share-btn"
                                        onclick="share('{{ route('view-detail-photo', $item->slug) }}')"></i>
                                    {{-- Button share --}}
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 pt-1">
                        <div class="d-flex gap-2 align-items-center pt-2">
                            <img class="rounded-circle"
                                src="{{ $item->belongsToUser->avatar ? Storage::url($item->belongsToUser->avatar) : asset('assets/images/profile/user-1.jpg') }}"
                                alt="Profile Picture" style="width: 40px; height: 40px; object-fit: cover">
                            <a href="{{ route('profile-public', encrypt($item->belongsToUser->id)) }}"
                                class="fw-bold text-dark hover-underline">{{ $item->belongsToUser->name }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @include('components.no-data')
    @endif
  
@endsection

@push('script')
    {{-- Script Share --}}
    <script>
        function share(url) {
            // Membuat elemen textarea sementara untuk menyalin URL
            var tempInput = document.createElement("textarea");
            tempInput.value = url;
            document.body.appendChild(tempInput);

            // Memilih dan menyalin URL
            tempInput.select();
            document.execCommand("copy");

            // Menghapus elemen textarea sementara
            document.body.removeChild(tempInput);

            // Swal message
            Swal.fire({
                title: 'Sukses',
                text: "URL telah disalin ke clipboard: " + url,
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        }

        // Mencegah perilaku default dari anchor tag
        document.querySelectorAll('.share-btn').forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault(); // Mencegah navigasi ke href
            });
        });
    </script>
    {{-- Script Share --}}
@endpush
