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

        .overlay-icons {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .overlay-icons a {
            display: inline-block;
            margin-right: 5px;
            color: #fff;
            font-size: 18px;
        }
    </style>
@endpush

@section('content')
    @if (isset($private_photos))
        {{-- Header --}}
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Album Privat</h4>
                        <p class="mb-8">Album yang berisi foto-foto anda, dengan visibilitas privat.</p>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt=""
                                class="img-fluid mb-n4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Header --}}

        {{-- Foreach data private photos --}}
        @if ($private_photos->isNotEmpty())
            <div class="photo-container w-100">
                @foreach ($private_photos as $item)
                    <div class="overflow-hidden box">
                        <div class="position-relative">
                            <img id="img" src="{{ Storage::url($item->file_path) }}" class="card-img-top rounded-6"
                                alt="...">
                            <div class="overlay d-flex flex-column">
                                <h4 class="card-title mb-1 text-light truncate">{{ $item->title }}</h4>
                                <h6 class="card-text fw-normal text-light d-inline-block text-truncate">
                                    {{ $item->description }}
                                </h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            @include('components.no-data')
        @endif
        {{-- Foreach data photos --}}
    @else
        {{-- Header --}}
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Ini adalah isi dari album berjudul "{{ $album->title }}"</h4>
                        <p class="mb-8">Album ini berisi {{ $album->photosCount() }} foto.</p>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt=""
                                class="img-fluid mb-n4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Header --}}

        {{-- Foreach data photos --}}
        @if ($album->photos->isNotEmpty())
            <div class="photo-container w-100">
                @foreach ($album->photos as $item)
                    <div class="overflow-hidden box">
                        <div class="position-relative">
                            <img id="img" src="{{ Storage::url($item->file_path) }}" class="card-img-top rounded-6"
                                alt="...">
                            <div class="overlay d-flex flex-column">
                                <h4 class="card-title mb-1 text-light truncate">{{ $item->title }}</h4>
                                <h6 class="card-text fw-normal text-light d-inline-block text-truncate">
                                    {{ $item->description }}
                                </h6>
                                <div class="overlay-icons">
                                    <a class="delete-btn cursor-pointer"
                                        data-url="{{ route('delete-from-album', ['photo' => $item->id, 'album' => $album->id]) }}"><i
                                            class="ti ti-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            @include('components.no-data')
        @endif
        {{-- Foreach data photos --}}
    @endif
@endsection

@push('script')
    <script>
        $(document).ready(() => {
            $('.delete-btn').on('click', function() {

                let url = $(this).data('url');
                let box = $(this).closest('.box');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus album ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Sukses',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                    box.remove();
                                } else {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: response.message,
                                        icon: 'error',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                }
                            }
                        })
                    }
                });
            });
        });
    </script>
@endpush
