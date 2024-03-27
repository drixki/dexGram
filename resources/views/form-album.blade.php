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
    @if (isset($album))
        {{-- Header --}}
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Edit Album</h4>
                        <p class="mb-8">Di halaman ini, anda dapat mengedit album yang sudah anda upload.</p>
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
        <form action="{{ route('update-album', $album->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" name="title" id="title-input"
                                class="form-control @error('title') is-invalid @enderror" value="{{ $album->title }}"
                                placeholder="Beri judul untuk album anda.">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Album</label>
                            <textarea name="description" id="description-input" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Beri deskripsi untuk album anda.">{{ $album->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('my-album') }}" type="button" class="btn btn-danger">Kembali</a>
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
                        <h4 class="fw-semibold mb-8">Unggah Album</h4>
                        <p class="mb-8">Di halaman ini, anda dapat mengupload album.</p>
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
        <form action="{{ route('upload-album') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" name="title" id="title-input"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Beri judul untuk album anda." value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Album</label>
                            <textarea name="description" id="description-input" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Beri deskripsi untuk foto anda.">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('my-album') }}" type="button" class="btn btn-danger">Kembali</a>
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
@endpush
