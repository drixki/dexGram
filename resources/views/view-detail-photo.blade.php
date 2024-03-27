@extends('layouts.app')

@push('style')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #comments-container {
            max-height: 300px;
            /* Batas tinggi kontainer komentar */
            overflow-y: auto;
            /* Mengaktifkan scroll jika konten melebihi batas tinggi */
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

            #row {
                gap: 0.5rem;
            }
        }

        @media (max-width: 768px) {
            .photo-container {
                columns: 2;
            }

            #row {
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .photo-container {
                columns: 1;
            }

            #row {
                gap: 0.5rem;
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

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            max-width: 600px;
            user-select: none;

            &>* {
                margin: .5rem 0.5rem;
            }
        }



        .checkbox-group-legend {
            font-size: 1.5rem;
            font-weight: 700;
            color: #9c9c9c;
            text-align: center;
            line-height: 1.125;
            margin-bottom: 1.25rem;
        }

        .checkbox-input {
            // Code to hide the input
            clip: rect(0 0 0 0);
            clip-path: inset(100%);
            height: 1px;
            overflow: hidden;
            position: absolute;
            white-space: nowrap;
            width: 1px;

            &:checked+.checkbox-tile {
                border-color: #2260ff;
                box-shadow: 0 5px 10px rgba(#000, 0.1);
                color: #2260ff;

                &:before {
                    transform: scale(1);
                    opacity: 1;
                    background-color: #2260ff;
                    border-color: #2260ff;
                }

                .checkbox-icon,
                .checkbox-label {
                    color: #2260ff;
                }
            }

            &:focus+.checkbox-tile {
                border-color: #2260ff;
                box-shadow: 0 5px 10px rgba(#000, 0.1), 0 0 0 4px #b5c9fc;

                &:before {
                    transform: scale(1);
                    opacity: 1;
                }
            }
        }

        .checkbox-tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 7rem;
            min-height: 7rem;
            border-radius: 0.5rem;
            border: 2px solid #b5bfd9;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(#000, 0.1);
            transition: 0.15s ease;
            cursor: pointer;
            position: relative;

            &:before {
                content: "";
                position: absolute;
                display: block;
                width: 1.25rem;
                height: 1.25rem;
                border: 2px solid #b5bfd9;
                background-color: #fff;
                border-radius: 50%;
                top: 0.25rem;
                left: 0.25rem;
                opacity: 0;
                transform: scale(0);
                transition: 0.25s ease;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='192' height='192' fill='%23FFFFFF' viewBox='0 0 256 256'%3E%3Crect width='256' height='256' fill='none'%3E%3C/rect%3E%3Cpolyline points='216 72.005 104 184 48 128.005' fill='none' stroke='%23FFFFFF' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'%3E%3C/polyline%3E%3C/svg%3E");
                background-size: 12px;
                background-repeat: no-repeat;
                background-position: 50% 50%;
            }

            &:hover {
                border-color: #2260ff;

                &:before {
                    transform: scale(1);
                    opacity: 1;
                }
            }
        }

        .checkbox-icon {
            transition: .375s ease;
            color: #494949;

            svg {
                width: 3rem;
                height: 3rem;
            }
        }

        .checkbox-label {
            color: #707070;
            transition: .375s ease;
            text-align: center;
        }

        .hover-underline:hover {
            text-decoration: underline;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush

@section('content')
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Detail Foto</h4>
                    <p class="mb-8">Halaman yang berisi detail foto {{ $photo->title }}.</p>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="" id="foto"
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Photo content --}}
    <div class="card shadow-none">
        <div class="card-body p-0">
            <div class="row" id="row">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                        <img src="{{ Storage::url($photo->file_path) }}" alt="" class="w-100 h-auto rounded-2"
                            id="foto">
                    </div>
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-between">

                    {{-- Detail Info Section --}}
                    <div class="shop-content">
                        <h4 class="fw-semibold text-capitalize">{{ $photo->title }}</h4>
                        @if ($photo->description)
                            <p class="mb-3">{{ $photo->description }}</p>
                        @else
                            <p class="mb-3">Foto ini tidak memiliki deskripsi.</p>
                        @endif
                        <div class="d-flex align-items-center gap-4 pb-2">
                            {{-- jumlah views --}}
                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" title="Jumlah Tayangan">
                                <i class="ti ti-eye text-dark fs-5"></i>
                                {{ $photo->viewsCount() }}
                            </div>
                            {{-- jumlah views --}}

                            {{-- jumlah like --}}
                            <div class="d-flex align-items-center gap-2 heart-icon"
                                onclick="toggleLike('{{ route('like-photo', $photo->id) }}')">
                                <i class="fas fa-heart fs-5 {{ $photo->isLiked() ? 'text-danger' : '' }} cursor-pointer"
                                    data-bs-toggle="tooltip" title="Suka"></i>
                                <span id="like-count">{{ $photo->likesCount() }}</span>
                            </div>
                            {{-- jumlah like --}}

                            {{-- jumlah download --}}
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('download-photo', $photo->id) }}">
                                    <i class="ti ti-download text-dark fs-5 cursor-pointer" data-bs-toggle="tooltip"
                                        title="Unduh"></i>
                                </a>
                                <span id="download-count">{{ $photo->downloads }}</span>
                            </div>
                            {{-- jumlah download --}}

                            {{-- tambah ke album --}}
                            <i class="ti ti-circle-plus text-dark fs-5 cursor-pointer" onclick="openAlbum()"
                                data-bs-toggle="tooltip" title="Tambahkan ke Album"></i>
                            {{-- tambah ke album --}}

                            <div class="d-flex align-itemsn-center fs-2 ms-auto"><i
                                    class="ti ti-point text-dark"></i>{{ $photo->created_at->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </div>

                    {{-- Author --}}
                    <div class="p-2 pt-1">
                        <div class="d-flex gap-2 align-items-center pt-2">
                            <img class="rounded-circle"
                                src="{{ $photo->belongsToUser->avatar ? Storage::url($photo->belongsToUser->avatar) : asset('assets/images/profile/user-1.jpg') }}"
                                alt="Profile Picture" style="width: 40px; height: 40px;">
                            <a href="{{ route('profile-public', encrypt($photo->belongsToUser->id)) }}"
                                class="fw-bold text-dark hover-underline">{{ $photo->belongsToUser->name }}</a>
                        </div>
                    </div>
                    {{-- Author --}}

                    {{-- Main Komentar Section --}}
                    @if ($photo->comment_permit == true)
                        <div class="position-relative py-4">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <h4 class="mb-0 fw-semibold">Jumlah Komentar</h4>
                                <span id="comment-count"
                                    class="badge bg-light-primary text-primary fs-4 fw-semibold px-6 py-8 rounded">{{ $photo->commentsCount() }}</span>
                            </div>
                            {{-- Comment Section --}}
                            <div id="comments-container">
                                @forelse ($photo->hasManyComments as $item)
                                    <div class="p-4 rounded-2 bg-light mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ asset($item->belongsToUser->avatar ? 'storage/' . $item->belongsToUser->avatar : 'assets/images/profile/user-1.jpg') }}"
                                                alt="" class="rounded-circle" width="33" height="33"
                                                style="object-fit: cover">
                                            <h6 class="fw-semibold mb-0 fs-4">{{ $item->belongsToUser->name }}</h6>
                                            <p class="text-muted mb-0">{{ $item->created_at->diffForHumans() }}</p>
                                            <div class="ms-auto">
                                                <div class="dropdown">
                                                    <a class="" href="javascript:void(0)" id="m1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-4"></i>
                                                    </a>
                                                    @if ($item->user_id == Auth::user()->id)
                                                        <ul class="dropdown-menu" aria-labelledby="m1">
                                                            <li>
                                                                <form action="{{ route('delete-comment', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item delete-btn">
                                                                        <i
                                                                            class="ti ti-trash text-muted me-1 fs-4"></i>Hapus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <p class="my-3">{{ $item->content }}</p>
                                    </div>
                                @empty
                                    Tidak ada komentar.
                                @endforelse
                            </div>
                            {{-- Comment Section --}}
                        </div>
                    @endif
                    {{-- Main Komentar Section --}}

                    {{-- Upload Komentar Section --}}
                    @if ($photo->comment_permit == true)
                        <div class="comment mt-auto sticky-comment-section">
                            <h4 class="mb-4 fw-semibold">Beri Komentar</h4>
                            <form id="komentar-form" action="{{ route('post-comment', ['foto_id' => $photo->id]) }}"
                                method="POST">
                                @csrf
                                @method('POST')
                                <textarea id="comment-content" class="form-control mb-2" name="content" rows="5"></textarea>
                                <button id="submit-comment" class="btn btn-primary">Kirim Komentar</button>
                            </form>
                        </div>
                    @endif
                    {{-- Upload Komentar Section --}}

                </div>
            </div>
        </div>
    </div>
    {{-- Photo content --}}

    {{-- Foto Lainnya --}}
    <div class="related-products pt-7">
        <h4 class="mb-3 fw-semibold">Jelajahi foto lain nya..</h4>
        <div class="photo-container w-100">
            @forelse ($other_photos as $item)
                <div class="overflow-hidden box">
                    <div class="position-relative">
                        <a href="{{ route('view-detail-photo', $item->slug) }}">
                            <img id="img" src="{{ Storage::url($item->file_path) }}"
                                class="card-img-top rounded-4" alt="...">
                            <div class="overlay d-flex flex-column">
                                <h3>{{ $item->title }}</h3>
                                <p>{{ $item->description }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 pt-1">
                        <div class="d-flex gap-2 align-items-center pt-2">
                            <img class="rounded-circle"
                                src="{{ $item->belongsToUser->avatar ? Storage::url($item->belongsToUser->avatar) : asset('assets/images/profile/user-1.jpg') }}"
                                alt="Profile Picture" style="width: 40px; height: 40px;">
                            <span class="fw-bold">{{ $item->belongsToUser->name }}</span>
                        </div>
                    </div>
                </div>
            @empty
                Tidak ada foto lain nya.
            @endforelse
        </div>
    </div>
    {{-- Foto Lainnya --}}

    {{-- Modal Album --}}
    <div class="modal fade" id="album-modal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="albumModalLabel">Tambahkan ke Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-to-album-form" action="{{ route('add-to-album', $photo->id) }}" method="POST">
                        @csrf
                        <div class="scrollable-album-list">
                            <fieldset class="checkbox-group">
                                @forelse ($albums as $item)
                                    <div class="checkbox">
                                        <label class="checkbox-wrapper">
                                            <input type="checkbox" class="checkbox-input" value="{{ $item->id }}"
                                                name="album_id[]" />
                                            <span class="checkbox-tile">
                                                <span class="checkbox-label">{{ Str::limit($item->title, 10) }}</span>
                                            </span>
                                        </label>
                                    </div>
                                @empty
                                    <p>Anda belum memiliki album, <a class="text-primary"
                                            href="{{ route('create-album') }}">Buat Album Sekarang</a></p>
                                @endforelse
                            </fieldset>
                            <!-- Tombol Submit -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Album --}}
@endsection

@push('script')
    {{-- Script untuk comment --}}
    <script>
        $(document).ready(function() {
            $('#komentar-form').on('submit', function(e) {
                e.preventDefault();

                commentContent = $('#comment-content').val();

                if (!commentContent) {
                    $('#error-comment').text('Komentar tidak boleh kosong!');
                } else {
                    $('#error-comment').text('');
                    this.submit();
                }
            })
        });
    </script>

    {{-- Script untuk delete komentar --}}
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();

                var form = $(this).closest('form');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus komentar ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    {{-- Script untuk delete komentar --}}

    {{-- Script untuk like dan unlike --}}
    <script>
        function toggleLike(url) {
            $.ajax({
                url: url,
                type: 'POST',
                success: function(response) {
                    $('#like-count').text(response.likes_count);
                    if (response.is_liked) {
                        $('.heart-icon i').addClass('text-danger');
                    } else {
                        $('.heart-icon i').removeClass('text-danger');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
    {{-- Script untuk like dan unlike --}}

    {{-- Script untuk buka modal --}}
    <script>
        function openAlbum() {
            $('#album-modal').modal('show');
        }
    </script>
    {{-- Script untuk buka modal --}}

    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
@endpush
