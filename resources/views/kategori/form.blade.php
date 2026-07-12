@extends('layouts.app')

@section('title', $kategori ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')

<div class="page-title">
    <i class="bi bi-{{ $kategori ? 'pencil-square' : 'plus-circle' }}"></i>
    {{ $kategori ? 'Edit Kategori' : 'Tambah Kategori' }}
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="form-section">
            <div class="form-section-header">
                <i class="bi bi-tag"></i>
                {{ $kategori ? 'Edit Data Kategori' : 'Data Kategori Baru' }}
            </div>
            <div class="form-section-body">
                <form method="POST"
                      action="{{ $kategori ? route('kategori.update', $kategori) : route('kategori.store') }}">
                    @csrf
                    @if($kategori) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="required">*</span></label>
                        <input type="text" name="nama_kategori"
                               value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}"
                               class="form-control @error('nama_kategori') is-invalid @enderror"
                               placeholder="Contoh: Komputer & Laptop" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="form-control"
                                  placeholder="Deskripsi singkat kategori ini...">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
                    </div>

                    <div style="display:flex;gap:10px;justify-content:flex-end">
                        <a href="{{ route('kategori.index') }}" class="btn-cancel">
                            <i class="bi bi-x-lg me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn-save">
                            <i class="bi bi-save me-1"></i>
                            {{ $kategori ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
