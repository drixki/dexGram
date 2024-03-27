@extends('layouts.app')

@push('style')
@endpush

@section('content')
    @if (isset($category))
        {{-- Header --}}
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Edit Kategori</h4>
                        <p class="mb-8">Di halaman ini, anda dapat mengedit kategori yang sudah anda buat.</p>
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
        <form action="{{ route('category-update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name-input"
                                class="form-control @error('name') is-invalid @enderror" value="{{ $category->name }}"
                                placeholder="Beri nama untuk kategori anda.">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Kategori</label>
                            <textarea name="description" id="description-input" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Beri deskripsi untuk kategori anda.">{{ $category->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('my-category') }}" type="button" class="btn btn-danger">Kembali</a>
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
                        <h4 class="fw-semibold mb-8">Tambah Kategori</h4>
                        <p class="mb-8">Di halaman ini, anda dapat menambah kategori.</p>
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
        <form action="{{ route('category-post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name-input"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Beri name untuk kategori anda." value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Kategori</label>
                            <textarea name="description" id="description-input" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Beri deskripsi untuk foto anda.">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('my-category') }}" type="button" class="btn btn-danger">Kembali</a>
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
