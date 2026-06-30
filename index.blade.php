@extends('layouts.app')

@section('title', 'Riwayat Presensi')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Riwayat Presensi Harian</h1>
            <p class="text-xs text-slate-400 font-medium">Daftar sesi kehadiran mahasiswa yang telah direkam ke sistem berdasarkan tanggal dan kelas kuliah.</p>
        </div>
    </div>

    <!-- Filter & Search Date Bar -->
    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('presensi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <!-- Search Date Input -->
            <div class="space-y-1.5 w-full">
                <label for="tanggal" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Filter Tanggal</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i class="fa-solid fa-calendar-day"></i>
                    </span>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $searchDate }}" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-semibold">
                </div>
            </div>

            <!-- Kelas Kuliah Filter -->
            <div class="space-y-1.5 w-full">
                <label for="kelas_kuliah_id" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Filter Kelas Kuliah</label>
                <select name="kelas_kuliah_id" id="kelas_kuliah_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-semibold">
                    <option value="">Semua Kelas Kuliah</option>
                    @foreach($listKelas as $k)
                        <option value="{{ $k->id }}" {{ $searchKelas == $k->id ? 'selected' : '' }}>{{ $k->nama_mata_kuliah }} ({{ $k->ruangan }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons for filter -->
            <div class="flex gap-2.5 w-full">
                <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm py-2.5 rounded-xl transition-all flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    <span>Cari</span>
                </button>
                @if($searchDate || $searchKelas)
                    <a href="{{ route('presensi.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm rounded-xl transition-all flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        @if($sessions->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Informasi Kelas & Sesi</th>
                            <th class="py-4 px-6">Dosen Pengampu</th>
                            <th class="py-4 px-6 text-center">Peserta</th>
                            <th class="py-4 px-6 text-center text-emerald-600">Hadir</th>
                            <th class="py-4 px-6 text-center text-blue-600">Sakit</th>
                            <th class="py-4 px-6 text-center text-amber-600">Izin</th>
                            <th class="py-4 px-6 text-center text-rose-600">Alpa</th>
                            <th class="py-4 px-6 w-36 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        @foreach($sessions as $index => $sess)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="py-4 px-6 text-center text-slate-400">
                                    {{ $sessions->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center border border-brand-100 shrink-0">
                                            <i class="fa-solid fa-graduation-cap text-xs"></i>
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-800">{{ $sess->kelasKuliah ? $sess->kelasKuliah->nama_mata_kuliah : 'Kelas Terhapus' }}</span>
                                            <span class="text-[10px] text-slate-400 font-semibold">{{ \Carbon\Carbon::parse($sess->tanggal)->translatedFormat('l, d F Y') }} &bull; Ruang: {{ $sess->kelasKuliah ? $sess->kelasKuliah->ruangan : '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-slate-500 text-xs font-semibold">
                                    {{ $sess->kelasKuliah && $sess->kelasKuliah->dosen ? $sess->kelasKuliah->dosen->name : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center font-bold text-slate-700">
                                    {{ $sess->total_mahasiswa }} Mhs
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full">
                                        {{ $sess->hadir_count }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100 rounded-full">
                                        {{ $sess->sakit_count }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100 rounded-full">
                                        {{ $sess->izin_count }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 rounded-full">
                                        {{ $sess->alpa_count }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Sesi -->
                                        <a href="{{ route('presensi.edit', $sess->tanggal) }}?kelas_kuliah_id={{ $sess->kelas_kuliah_id }}" class="w-8.5 h-8.5 rounded-lg bg-slate-50 hover:bg-brand-50 text-slate-400 hover:text-brand-600 border border-slate-100 hover:border-brand-100 flex items-center justify-center transition-colors" title="Ubah Absensi">
                                            <i class="fa-solid fa-pencil text-xs"></i>
                                        </a>
                                        <!-- Cetak Laporan -->
                                        <a href="{{ route('presensi.print', ['tanggal' => $sess->tanggal, 'kelas_kuliah_id' => $sess->kelas_kuliah_id]) }}" target="_blank" class="w-8.5 h-8.5 rounded-lg bg-slate-50 hover:bg-indigo-50 text-slate-400 hover:text-indigo-600 border border-slate-100 hover:border-indigo-100 flex items-center justify-center transition-colors" title="Cetak Laporan">
                                            <i class="fa-solid fa-print text-xs"></i>
                                        </a>
                                        <!-- Hapus Sesi -->
                                        <form action="{{ route('presensi.destroy', $sess->tanggal) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="kelas_kuliah_id" value="{{ $sess->kelas_kuliah_id }}">
                                            <button type="button" data-confirm-delete="Apakah Anda yakin ingin menghapus seluruh data presensi untuk kelas {{ $sess->kelasKuliah ? $sess->kelasKuliah->nama_mata_kuliah : '' }} pada tanggal {{ \Carbon\Carbon::parse($sess->tanggal)->translatedFormat('d F Y') }}?" class="w-8.5 h-8.5 rounded-lg bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-600 border border-slate-100 hover:border-rose-100 flex items-center justify-center transition-colors" title="Hapus Presensi">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Wrapper -->
            <div class="p-5 border-t border-slate-100 bg-slate-50/30">
                {{ $sessions->links() }}
            </div>
        @else
            <div class="py-20 text-center space-y-4">
                <div class="w-16 h-16 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-300 mx-auto">
                    <i class="fa-solid fa-calendar-xmark text-2xl"></i>
                </div>
                <div class="max-w-xs mx-auto space-y-1">
                    <h3 class="font-bold text-slate-700">Belum Ada Riwayat Presensi</h3>
                    <p class="text-xs text-slate-400 font-medium">Belum ada pencatatan kehadiran yang dicari atau disimpan.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
