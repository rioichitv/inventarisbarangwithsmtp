@extends('layouts.app')

@section('title', isset($barang) ? 'Edit Barang' : 'Tambah Barang')

@section('content')

<div class="page-title">
    <i class="bi bi-{{ isset($barang) ? 'pencil-square' : 'plus-circle' }}"></i>
    {{ isset($barang) ? 'Edit Barang' : 'Tambah Barang Baru' }}
</div>

<form method="POST"
      action="{{ isset($barang) ? route('barang.update', $barang) : route('barang.store') }}"
      enctype="multipart/form-data"
      novalidate>
    @csrf
    @if(isset($barang)) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-md-8">

            {{-- Informasi Dasar --}}
            <div class="form-section">
                <div class="form-section-header">
                    <i class="bi bi-info-circle"></i> Informasi Dasar
                </div>
                <div class="form-section-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Kode Barang <span class="required">*</span></label>
                            <input type="text" name="kode_barang"
                                   value="{{ old('kode_barang', $barang->kode_barang ?? $kode ?? '') }}"
                                   class="form-control @error('kode_barang') is-invalid @enderror"
                                   placeholder="IT-001" required>
                            @error('kode_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Barang <span class="required">*</span></label>
                            <input type="text" name="nama_barang"
                                   value="{{ old('nama_barang', $barang->nama_barang ?? '') }}"
                                   class="form-control @error('nama_barang') is-invalid @enderror"
                                   placeholder="Contoh: Laptop Dell Latitude 5420" required>
                            @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="required">*</span></label>
                            <input type="text" name="kategori" id="kategoriInput"
                                   value="{{ old('kategori', $barang->kategori ?? '') }}"
                                   class="form-control" placeholder="Komputer, Jaringan, Printer..." required>
                            <div class="field-hint">Ketik bebas atau pilih dari saran</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Barang <span class="required">*</span></label>
                            <input type="number" name="jumlah_barang" min="0"
                                   value="{{ old('jumlah_barang', $barang->jumlah_barang ?? 1) }}"
                                   class="form-control @error('jumlah_barang') is-invalid @enderror" required>
                            @error('jumlah_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status & Lokasi --}}
            <div class="form-section">
                <div class="form-section-header">
                    <i class="bi bi-geo-alt"></i> Status & Lokasi
                </div>
                <div class="form-section-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Kondisi <span class="required">*</span></label>
                            <select name="kondisi" class="form-select" required>
                                @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $k)
                                <option value="{{ $k }}"
                                    {{ old('kondisi', $barang->kondisi ?? 'Baik') == $k ? 'selected' : '' }}>
                                    {{ $k }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status <span class="required">*</span></label>
                            <select name="status" class="form-select" required>
                                @foreach(['Tersedia','Digunakan','Dipinjam','Rusak'] as $s)
                                <option value="{{ $s }}"
                                    {{ old('status', $barang->status ?? 'Tersedia') == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Lokasi <span class="required">*</span></label>
                            <input type="text" name="lokasi"
                                   value="{{ old('lokasi', $barang->lokasi ?? '') }}"
                                   class="form-control" placeholder="Ruang IT, Lantai 2..." required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Penanggung Jawab <span class="required">*</span></label>
                            <input type="text" name="penanggung_jawab" id="pjInput"
                                   value="{{ old('penanggung_jawab', $barang->penanggung_jawab ?? '') }}"
                                   class="form-control" placeholder="Nama penanggung jawab" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Spesifikasi --}}
            <div class="form-section">
                <div class="form-section-header">
                    <i class="bi bi-file-text"></i> Spesifikasi & Keterangan
                </div>
                <div class="form-section-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Spesifikasi Teknis</label>
                            <textarea name="spesifikasi" rows="4" class="form-control"
                                      placeholder="Contoh: Intel Core i5, RAM 16GB, SSD 512GB...">{{ old('spesifikasi', $barang->spesifikasi ?? '') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan Tambahan</label>
                            <textarea name="keterangan" rows="3" class="form-control"
                                      placeholder="Catatan atau informasi tambahan...">{{ old('keterangan', $barang->keterangan ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            {{-- Foto --}}
            <div class="form-section">
                <div class="form-section-header">
                    <i class="bi bi-image"></i> Foto Barang <span class="required">*</span>
                </div>
                <div class="form-section-body">
                    @if(isset($barang) && $barang->foto)
                    <div style="text-align:center;margin-bottom:12px">
                        <img src="{{ Storage::url($barang->foto) }}" alt="Foto"
                             style="max-height:160px;border-radius:8px;object-fit:cover;width:100%">
                        <div style="font-size:11px;color:#aaa;margin-top:4px">Foto saat ini</div>
                    </div>
                    @endif
                    <div class="foto-drop" id="fotoDropzone">
                        <i class="bi bi-cloud-upload"></i>
                        <p>Klik atau seret foto ke sini<br>
                           <span style="font-size:11px">JPG, PNG, WEBP • Maks 2MB</span>
                        </p>
                    </div>
                    <input type="file" name="foto" id="fotoInput" accept="image/*" style="display:none"
                           class="@error('foto') is-invalid @enderror">
                    @error('foto')
                        <div style="color:#f44336;font-size:11px;margin-top:4px">{{ $message }}</div>
                    @enderror
                    @if(!isset($barang))
                        <div style="font-size:11px;color:#e53935;margin-top:5px">
                            <i class="bi bi-exclamation-circle me-1"></i>Foto wajib diisi
                        </div>
                    @endif
                    <div id="fotoPreview" style="display:none;margin-top:10px;text-align:center">
                        <img id="fotoPreviewImg" style="max-height:140px;border-radius:8px;object-fit:cover;width:100%">
                        <div id="fotoFileName" style="font-size:11px;color:#aaa;margin-top:4px"></div>
                    </div>
                    <button type="button" onclick="document.getElementById('fotoInput').click()"
                            style="width:100%;margin-top:10px;background:#eef0fb;border:1px solid #d0d4f0;color:#3b2db5;border-radius:6px;padding:7px;font-size:12px;cursor:pointer">
                        <i class="bi bi-upload me-1"></i> Pilih Foto
                    </button>
                </div>
            </div>

            {{-- Dokumen --}}
            <div class="form-section">
                <div class="form-section-header">
                    <i class="bi bi-file-earmark-pdf"></i> Dokumen Pendukung
                </div>
                <div class="form-section-body">
                    @if(isset($barang) && $barang->dokumen)
                    <div style="background:#eef0fb;border-radius:6px;padding:8px 12px;font-size:12px;color:#3b2db5;margin-bottom:10px">
                        <i class="bi bi-file-earmark-check me-1"></i>
                        Dokumen tersimpan —
                        <a href="{{ Storage::url($barang->dokumen) }}" target="_blank"
                           style="font-weight:600;color:#3b2db5">Lihat</a>
                    </div>
                    @endif
                    <input type="file" name="dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx"
                           class="form-control @error('dokumen') is-invalid @enderror">
                    <div class="field-hint">PDF, Word, Excel • Maks 5MB</div>
                    @error('dokumen')<div style="color:#f44336;font-size:11px;margin-top:3px">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Tips --}}
            <div class="form-section">
                <div class="form-section-header">
                    <i class="bi bi-lightbulb"></i> Tips
                </div>
                <div class="form-section-body">
                    <ul style="font-size:12px;color:#888;padding-left:16px;margin:0;line-height:1.8">
                        <li>Kode barang harus unik</li>
                        <li>Ketik kategori bebas</li>
                        <li>Foto membantu identifikasi barang</li>
                    </ul>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="form-section">
                <div class="form-section-body" style="padding:16px">
                    <div style="display:flex;gap:10px">
                        <a href="{{ route('barang.index') }}" class="btn-cancel"
                           style="flex:1;padding:11px;font-size:13px;border-radius:8px;display:flex;align-items:center;justify-content:center;gap:6px;text-align:center">
                            <i class="bi bi-x-lg"></i> Batal
                        </a>
                        <button type="submit" class="btn-save"
                                style="flex:2;padding:11px;font-size:13px;border-radius:8px;display:flex;align-items:center;justify-content:center;gap:6px">
                            <i class="bi bi-save"></i>
                            {{ isset($barang) ? 'Simpan Perubahan' : 'Simpan Barang' }}
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</form>

@endsection

@push('scripts')
<script>
$(function () {
    // Gabungkan kategori dari tabel kategori + barang yang sudah ada
    var katFromBarang = @json(\App\Models\Barang::whereNotNull('kategori')->distinct()->pluck('kategori'));
    var katFromKategori = @json(\App\Models\Kategori::orderBy('nama_kategori')->pluck('nama_kategori'));

    // Gabung dan hapus duplikat
    var katList = [...new Set([...katFromKategori, ...katFromBarang])];

    if (!katList.length) {
        katList = ['Komputer & Laptop','Jaringan','Printer & Scanner',
                   'Monitor & Display','Server & Storage','Aksesoris IT',
                   'UPS & Power','Telepon & Komunikasi'];
    }

    $('#kategoriInput').autocomplete({
        source: katList,
        minLength: 0,
        select: function(e, ui) {
            $(this).val(ui.item.value);
            return false;
        }
    }).on('focus', function(){ $(this).autocomplete('search', ''); });

    var pjList = @json(\App\Models\Barang::whereNotNull('penanggung_jawab')->distinct()->pluck('penanggung_jawab'));
    if (!pjList.length) pjList = ['Admin IT','Kepala IT','Staff IT','Teknisi'];
    $('#pjInput').autocomplete({ source: pjList, minLength: 0 })
        .on('focus', function(){ $(this).autocomplete('search',''); });

    const drop  = document.getElementById('fotoDropzone');
    const input = document.getElementById('fotoInput');
    drop.addEventListener('click', () => input.click());
    drop.addEventListener('dragover',  e => { e.preventDefault(); drop.style.borderColor='#5c6bc0'; });
    drop.addEventListener('dragleave', () => { drop.style.borderColor=''; });
    drop.addEventListener('drop', e => {
        e.preventDefault(); drop.style.borderColor='';
        if (e.dataTransfer.files[0]) { input.files = e.dataTransfer.files; preview(e.dataTransfer.files[0]); }
    });
    input.addEventListener('change', function(){ if(this.files[0]) preview(this.files[0]); });

    function preview(file) {
        const r = new FileReader();
        r.onload = e => {
            document.getElementById('fotoPreviewImg').src = e.target.result;
            document.getElementById('fotoFileName').textContent = file.name;
            document.getElementById('fotoPreview').style.display = 'block';
        };
        r.readAsDataURL(file);
    }

    // ── VALIDASI SEBELUM SUBMIT ──
    $('form').on('submit', function(e) {
        const isEdit = {{ isset($barang) ? 'true' : 'false' }};
        let errors = [];

        if (!$('input[name="kode_barang"]').val().trim())
            errors.push({ msg: 'Kode Barang wajib diisi', el: $('input[name="kode_barang"]') });

        if (!$('input[name="nama_barang"]').val().trim())
            errors.push({ msg: 'Nama Barang wajib diisi', el: $('input[name="nama_barang"]') });

        if (!$('input[name="kategori"]').val().trim())
            errors.push({ msg: 'Kategori wajib diisi', el: $('input[name="kategori"]') });

        if (!$('input[name="jumlah_barang"]').val().trim())
            errors.push({ msg: 'Jumlah Barang wajib diisi', el: $('input[name="jumlah_barang"]') });

        if (!$('input[name="lokasi"]').val().trim())
            errors.push({ msg: 'Lokasi wajib diisi', el: $('input[name="lokasi"]') });

        if (!$('input[name="penanggung_jawab"]').val().trim())
            errors.push({ msg: 'Penanggung Jawab wajib diisi', el: $('input[name="penanggung_jawab"]') });

        if (!isEdit && !document.getElementById('fotoInput').files.length)
            errors.push({ msg: 'Foto anda masih belum terisi!', el: $('#fotoDropzone') });

        if (errors.length > 0) {
            e.preventDefault();
            e.stopPropagation();
            // Gunakan fungsi showToast global dari layout
            showToast(errors[0].msg, 'error');
            if (errors[0].el) {
                errors[0].el.focus();
            }
            return false;
        }
    });
});
</script>
@endpush
