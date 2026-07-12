@extends('layouts.app')

@section('title', isset($barangKeluar) ? 'Edit Barang Keluar' : 'Tambah Barang Keluar')

@section('content')

<div class="page-title">
    <i class="bi bi-{{ isset($barangKeluar) ? 'pencil-square' : 'plus-circle' }}"></i>
    {{ isset($barangKeluar) ? 'Edit Barang Keluar' : 'Tambah Barang Keluar' }}
</div>

<form method="POST" enctype="multipart/form-data"
      action="{{ isset($barangKeluar) ? route('barang-keluar.update', $barangKeluar) : route('barang-keluar.store') }}"
      novalidate>
    @csrf
    @if(isset($barangKeluar)) @method('PUT') @endif

    <div class="row g-4">

        {{-- ── KOLOM KIRI ── --}}
        <div class="col-md-8">

            <div class="form-section">
                <div class="form-section-header">
                    <i class="bi bi-info-circle"></i> Informasi Pengeluaran
                </div>
                <div class="form-section-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">No. Keluar <span class="required">*</span></label>
                            <input type="text" name="no_keluar"
                                   value="{{ old('no_keluar', $barangKeluar->no_keluar ?? $no_keluar ?? '') }}"
                                   class="form-control @error('no_keluar') is-invalid @enderror"
                                   placeholder="BK-0001" required>
                            @error('no_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Keluar <span class="required">*</span></label>
                            <input type="date" name="tanggal_keluar"
                                   value="{{ old('tanggal_keluar', isset($barangKeluar) ? $barangKeluar->tanggal_keluar->format('Y-m-d') : date('Y-m-d')) }}"
                                   class="form-control @error('tanggal_keluar') is-invalid @enderror" required>
                            @error('tanggal_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Petugas</label>
                            <input type="text" name="petugas" id="petugasInput"
                                   value="{{ old('petugas', $barangKeluar->petugas ?? '') }}"
                                   class="form-control" placeholder="Nama petugas">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Pilih Barang <span class="required">*</span></label>
                            <select name="barang_id" id="barangSelect"
                                    class="form-select @error('barang_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangs as $b)
                                <option value="{{ $b->id }}" data-stok="{{ $b->jumlah_barang }}"
                                    {{ old('barang_id', $barangKeluar->barang_id ?? '') == $b->id ? 'selected' : '' }}>
                                    [{{ $b->kode_barang }}] {{ $b->nama_barang }} — Stok: {{ $b->jumlah_barang }}
                                </option>
                                @endforeach
                            </select>
                            @error('barang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Keluar <span class="required">*</span></label>
                            <input type="number" name="jumlah" id="jumlahInput" min="1"
                                   value="{{ old('jumlah', $barangKeluar->jumlah ?? 1) }}"
                                   class="form-control @error('jumlah') is-invalid @enderror" required>
                            <div class="field-hint" id="stokInfo"></div>
                            @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-header">
                    <i class="bi bi-person-check"></i> Data Penerima
                </div>
                <div class="form-section-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Penerima <span class="required">*</span></label>
                            <input type="text" name="penerima"
                                   value="{{ old('penerima', $barangKeluar->penerima ?? '') }}"
                                   class="form-control @error('penerima') is-invalid @enderror"
                                   placeholder="Nama penerima" required>
                            @error('penerima')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bagian / Divisi</label>
                            <input type="text" name="bagian"
                                   value="{{ old('bagian', $barangKeluar->bagian ?? '') }}"
                                   class="form-control" placeholder="IT, HRD, Finance...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keperluan</label>
                            <input type="text" name="keperluan"
                                   value="{{ old('keperluan', $barangKeluar->keperluan ?? '') }}"
                                   class="form-control" placeholder="Penggantian, Pinjam, Permanen...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="form-control"
                                      placeholder="Catatan tambahan...">{{ old('keterangan', $barangKeluar->keterangan ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── KOLOM KANAN ── --}}
        <div class="col-md-4">

            {{-- Stok info --}}
            <div class="form-section" id="stokCard" style="display:none">
                <div class="form-section-header">
                    <i class="bi bi-box-seam"></i> Stok Tersedia
                </div>
                <div class="form-section-body" style="text-align:center;padding:20px">
                    <div style="font-size:42px;font-weight:700;color:#3b2db5;line-height:1" id="stokAngka">0</div>
                    <div style="font-size:12px;color:#aaa;margin-top:4px">unit tersedia</div>
                    <div style="font-size:12px;color:#555;margin-top:8px;font-weight:600" id="stokNama"></div>
                </div>
            </div>

            {{-- Foto --}}
            <div class="form-section">
                <div class="form-section-header">
                    <i class="bi bi-image"></i> Foto Barang Keluar <span class="required">*</span>
                </div>
                <div class="form-section-body">
                    @if(isset($barangKeluar) && $barangKeluar->foto)
                    <div style="text-align:center;margin-bottom:12px">
                        <img src="{{ Storage::url($barangKeluar->foto) }}" alt="Foto"
                             style="max-height:140px;border-radius:8px;object-fit:cover;width:100%">
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
                    @if(!isset($barangKeluar))
                        <div style="font-size:11px;color:#e53935;margin-top:4px">
                            <i class="bi bi-exclamation-circle me-1"></i>Foto wajib diisi
                        </div>
                    @endif
                    <div id="fotoPreview" style="display:none;margin-top:10px;text-align:center">
                        <img id="fotoPreviewImg" style="max-height:130px;border-radius:8px;object-fit:cover;width:100%">
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
                    @if(isset($barangKeluar) && $barangKeluar->dokumen)
                    <div style="background:#eef0fb;border-radius:6px;padding:8px 12px;font-size:12px;color:#3b2db5;margin-bottom:10px">
                        <i class="bi bi-file-earmark-check me-1"></i>
                        Dokumen tersimpan —
                        <a href="{{ Storage::url($barangKeluar->dokumen) }}" target="_blank"
                           style="font-weight:600;color:#3b2db5">Lihat</a>
                    </div>
                    @endif
                    <input type="file" name="dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx"
                           class="form-control @error('dokumen') is-invalid @enderror">
                    <div class="field-hint">PDF, Word, Excel • Maks 5MB</div>
                    @error('dokumen')<div style="color:#f44336;font-size:11px;margin-top:3px">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Tombol --}}
            <div class="form-section">
                <div class="form-section-body" style="padding:16px">
                    <div style="display:flex;gap:10px">
                        <a href="{{ route('barang-keluar.index') }}" class="btn-cancel"
                           style="flex:1;padding:11px;font-size:13px;border-radius:8px;display:flex;align-items:center;justify-content:center;gap:6px">
                            <i class="bi bi-x-lg"></i> Batal
                        </a>
                        <button type="submit" class="btn-save"
                                style="flex:2;padding:11px;font-size:13px;border-radius:8px;display:flex;align-items:center;justify-content:center;gap:6px">
                            <i class="bi bi-save"></i>
                            {{ isset($barangKeluar) ? 'Simpan Perubahan' : 'Simpan' }}
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
    // Stok info saat pilih barang
    function updateStok() {
        const opt  = $('#barangSelect option:selected');
        const stok = parseInt(opt.data('stok')) || 0;
        if ($('#barangSelect').val()) {
            $('#stokAngka').text(stok);
            $('#stokNama').text(opt.text().split('—')[0].trim());
            $('#stokCard').show();
            $('#jumlahInput').attr('max', stok);
            $('#stokInfo').html(
                '<span style="color:' + (stok > 0 ? '#2e7d32' : '#c62828') + '">' +
                '<b>' + stok + '</b> unit tersedia</span>'
            );
        } else {
            $('#stokCard').hide();
            $('#stokInfo').html('');
        }
    }
    $('#barangSelect').on('change', updateStok).trigger('change');

    // Autocomplete petugas
    var pj = @json(\App\Models\Barang::whereNotNull('penanggung_jawab')->distinct()->pluck('penanggung_jawab'));
    if (!pj.length) pj = ['Admin IT','Kepala IT','Staff IT','Teknisi'];
    $('#petugasInput').autocomplete({ source: pj, minLength: 0 })
        .on('focus', function(){ $(this).autocomplete('search',''); });

    // Autocomplete bagian/divisi
    var bagianList = @json(\App\Models\BarangKeluar::whereNotNull('bagian')->distinct()->pluck('bagian'));
    if (!bagianList.length) {
        bagianList = ['IT','HRD','Finance','Marketing','Operasional',
                      'Manajemen','Logistik','Procurement','Keuangan',
                      'Administrasi','Akademik','Umum'];
    }
    $('input[name="bagian"]').attr('id','bagianInput').autocomplete({
        source: bagianList,
        minLength: 0
    }).on('focus', function(){ $(this).autocomplete('search',''); });

    // Foto drag & drop + preview
    const drop  = document.getElementById('fotoDropzone');
    const input = document.getElementById('fotoInput');
    drop.addEventListener('click', () => input.click());
    drop.addEventListener('dragover',  e => { e.preventDefault(); drop.style.borderColor='#5c6bc0'; });
    drop.addEventListener('dragleave', () => { drop.style.borderColor=''; });
    drop.addEventListener('drop', e => {
        e.preventDefault(); drop.style.borderColor='';
        if (e.dataTransfer.files[0]) { input.files = e.dataTransfer.files; previewFoto(e.dataTransfer.files[0]); }
    });
    input.addEventListener('change', function(){ if(this.files[0]) previewFoto(this.files[0]); });

    function previewFoto(file) {
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
        const isEdit = {{ isset($barangKeluar) ? 'true' : 'false' }};
        let errors = [];

        if (!$('input[name="no_keluar"]').val().trim())
            errors.push({ msg: 'No. Keluar wajib diisi', el: $('input[name="no_keluar"]') });

        if (!$('input[name="tanggal_keluar"]').val().trim())
            errors.push({ msg: 'Tanggal Keluar wajib diisi', el: $('input[name="tanggal_keluar"]') });

        if (!$('select[name="barang_id"]').val().trim())
            errors.push({ msg: 'Pilih Barang wajib diisi', el: $('select[name="barang_id"]') });

        if (!$('input[name="jumlah"]').val().trim())
            errors.push({ msg: 'Jumlah Keluar wajib diisi', el: $('input[name="jumlah"]') });

        if (!$('input[name="penerima"]').val().trim())
            errors.push({ msg: 'Nama Penerima wajib diisi', el: $('input[name="penerima"]') });

        if (!isEdit && !document.getElementById('fotoInput').files.length)
            errors.push({ msg: 'Foto anda masih belum terisi!', el: $('#fotoDropzone') });

        if (errors.length > 0) {
            e.preventDefault();
            e.stopPropagation();
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
