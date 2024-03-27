@extends('layouts.app')

@push('style')
    <style>
        #imagePreview {
            object-fit: cover;
        }

        [disabled] {
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
    @if (isset($photo))
        {{-- Header --}}
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Edit Foto</h4>
                        <p class="mb-8">Di halaman ini, anda dapat mengedit foto yang sudah anda upload.</p>
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

        {{-- Edit Form --}}
        <form action="{{ route('update-photo', $photo->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                        <div class="position-relative">
                            <img class="rounded w-100 h-100 cursor-pointer" id="imagePreview"
                                src="{{ Storage::url($photo->file_path) }}" alt="Preview Image">
                        </div>
                        <input type="file" name="photo" id="photo"
                            class="d-none @error('photo') is-invalid @enderror">
                        @error('photo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" name="title" id="title-input"
                                class="form-control @error('title') is-invalid @enderror" value="{{ $photo->title }}"
                                placeholder="Beri judul untuk foto anda.">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi (opsional)</label>
                            <textarea name="description" id="description-input" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Beri deskripsi untuk foto anda.">{{ $photo->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Kategori {Opsional}</label>
                            <select name="category" class="form-select" id="category">
                                @if ($category->isNotEmpty())
                                    <option disabled selected>Pilih Kategori</option>
                                    @foreach ($category as $item)
                                        @if ($photo->category_id == $item->id)
                                            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option disabled selected>Anda tidak memiliki kategori</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Visibilitas</label>
                            <select name="visibility" class="form-select" id="visibility">
                                <option value="public" {{ $photo->visibility == 'public' ? 'selected' : '' }}>Publik
                                </option>
                                <option value="private" {{ $photo->visibility == 'private' ? 'selected' : '' }}>Privat
                                </option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="form-check">
                                <input class="form-check-input primary" type="checkbox" name="commentPermit"
                                    id="comment-permit" {{ $photo->comment_permit = true ? 'checked' : '' }}>
                                <label class="form-check-label text-dark" for="comment-permit">
                                    Ijinkan Komentar
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('my-photo') }}" type="button" class="btn btn-danger">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- Edit Form --}}
    @else
        {{-- Header --}}
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Unggah Foto</h4>
                        <p class="mb-8">Di halaman ini, anda dapat mengupload foto.</p>
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

        {{-- Upload Form --}}
        <form action="{{ route('upload-photo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                        <div class="position-relative">
                            <img class="rounded w-100 h-100 cursor-pointer" id="imagePreview"
                                src="{{ asset('assets/images/pen.png') }}" alt="Preview Image">
                        </div>
                        <input type="file" name="photo" id="photo"
                            class="d-none @error('photo') is-invalid @enderror">
                        @error('photo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" name="title" id="title-input"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Beri judul untuk foto anda." required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi (opsional)</label>
                            <textarea name="description" id="description-input" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Beri deskripsi untuk foto anda."></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Kategori {Opsional}</label>
                            <select name="category" class="form-select" id="category">
                                @if ($category->isNotEmpty())
                                    <option disabled selected>Pilih Kategori</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @else
                                    <option disabled selected>Anda tidak memiliki kategori</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Visibilitas</label>
                            <select name="visibility" class="form-select disabled" id="visibility">
                                <option value="public" selected>Publik</option>
                                <option value="private">Privat</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="form-check">
                                <input class="form-check-input primary" type="checkbox" name="commentPermit"
                                    id="comment-permit" checked>
                                <label class="form-check-label text-dark" for="comment-permit">
                                    Ijinkan Komentar
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('my-photo') }}" type="button" class="btn btn-danger">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- Upload Form --}}
    @endif
@endsection

@push('script')
    <script>
        // Mengambil elemen-elemen yang diperlukan
        const imagePreview = document.getElementById('imagePreview');
        const photoInput = document.getElementById('photo');
        const titleInput = document.getElementById('title-input');
        const descriptionInput = document.getElementById('description-input');
        const submitButton = document.querySelector('button[type="submit"]');
        const commentPermit = document.getElementById('comment-permit');
        const category = document.getElementById('category');
        const visibility = document.getElementById('visibility');
        const formInputs = [titleInput, descriptionInput, submitButton, commentPermit, visibility, category];

        document.addEventListener('DOMContentLoaded', function() {

            @if (request()->routeIs('create-photo'))
                // Cek apakah photo input kosong atau tidak saat halaman dimuat
                const file = photoInput.files[0];
                if (!file) {
                    // Jika photo input kosong, beri atribut disabled pada input-input yang diperlukan
                    formInputs.forEach(input => {
                        input.setAttribute('disabled', 'disabled');
                    });
                }
            @endif

            // Tambahkan event listener saat gambar pratinjau diklik
            imagePreview.addEventListener('click', function() {
                // Memicu klik pada input file
                photoInput.click();
            });

            // Tambahkan event listener saat input file berubah
            photoInput.addEventListener('change', function() {
                const file = photoInput.files[0];
                if (file) {
                    // Membaca file gambar sebagai URL data
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Menampilkan gambar yang dikonfirmasi di pratinjau
                        imagePreview.src = e.target.result;

                        // Menghapus kelas disabled dan mengatur kursor
                        formInputs.forEach(input => {
                            input.removeAttribute('disabled');
                            input.style.cursor = 'auto';
                        });
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika tidak ada file yang dipilih, beri atribut disabled pada elemen-elemen yang diperlukan
                    formInputs.forEach(input => {
                        input.setAttribute('disabled', 'disabled');
                        input.style.cursor = 'not-allowed';
                    });

                    // Atur pratinjau gambar menjadi kosong
                    imagePreview.src = '{{ asset('assets/images/pen.png') }}';
                }
            });
        });
    </script>
@endpush
