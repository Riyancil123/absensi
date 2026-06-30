@extends('layouts.app')

@section('title', 'Input Presensi')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('presensi.index') }}" class="w-10 h-10 rounded-xl bg-white hover:bg-slate-100 border border-slate-100 flex items-center justify-center text-slate-500 hover:text-slate-700 transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-slate-800">Catat Kehadiran: {{ $kelas->nama_mata_kuliah }}</h1>
                <p class="text-xs text-slate-400 font-medium">Input presensi mahasiswa secara kolektif untuk Ruang: {{ $kelas->ruangan }}.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('presensi.store') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="kelas_kuliah_id" value="{{ $kelas->id }}">

        <!-- Date and Quick Actions Card -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="space-y-1.5 w-full md:w-72">
                <label for="tanggal" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Presensi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i class="fa-solid fa-calendar-day"></i>
                    </span>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-semibold">
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2.5 w-full md:w-auto justify-end">
                <button type="button" onclick="markAll('Hadir')" class="px-4 py-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 text-emerald-700 font-semibold text-xs rounded-xl transition-all flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Set Semua Hadir</span>
                </button>
                <button type="button" onclick="markAll('Alpa')" class="px-4 py-2 bg-rose-50 hover:bg-rose-100 border border-rose-100 text-rose-700 font-semibold text-xs rounded-xl transition-all flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-user-xmark text-xs"></i>
                    <span>Set Semua Alpa</span>
                </button>
            </div>
        </div>

        <!-- Student Attendance Table -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6 w-36">NIM</th>
                            <th class="py-4 px-6">Nama Lengkap</th>
                            <th class="py-4 px-6 w-24">Kelas</th>
                            <th class="py-4 px-6 w-96 text-center">Status Kehadiran</th>
                            <th class="py-4 px-6">Keterangan (Opsional)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        @foreach($mahasiswas as $index => $mhs)
                            <tr class="hover:bg-slate-50/30 transition-colors group">
                                <td class="py-4 px-6 text-center text-slate-400">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-4 px-6 font-semibold text-slate-800">
                                    {{ $mhs->username }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="block font-bold text-slate-800">{{ $mhs->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold">{{ $mhs->jurusan }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-full">
                                        {{ $mhs->kelas }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-3">
                                        <!-- Hadir -->
                                        <label class="relative flex items-center justify-center px-4 py-2 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 select-none transition-all has-[:checked]:bg-emerald-500 has-[:checked]:border-emerald-500 has-[:checked]:text-white has-[:checked]:shadow-sm">
                                            <input type="radio" name="presensi[{{ $mhs->id }}][status]" value="Hadir" class="sr-only" checked onclick="toggleKeterangan({{ $mhs->id }}, false)">
                                            <span class="text-xs font-bold">Hadir</span>
                                        </label>

                                        <!-- Sakit -->
                                        <label class="relative flex items-center justify-center px-4 py-2 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 select-none transition-all has-[:checked]:bg-blue-500 has-[:checked]:border-blue-500 has-[:checked]:text-white has-[:checked]:shadow-sm">
                                            <input type="radio" name="presensi[{{ $mhs->id }}][status]" value="Sakit" class="sr-only" onclick="toggleKeterangan({{ $mhs->id }}, true)">
                                            <span class="text-xs font-bold">Sakit</span>
                                        </label>

                                        <!-- Izin -->
                                        <label class="relative flex items-center justify-center px-4 py-2 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 select-none transition-all has-[:checked]:bg-amber-500 has-[:checked]:border-amber-500 has-[:checked]:text-white has-[:checked]:shadow-sm">
                                            <input type="radio" name="presensi[{{ $mhs->id }}][status]" value="Izin" class="sr-only" onclick="toggleKeterangan({{ $mhs->id }}, true)">
                                            <span class="text-xs font-bold">Izin</span>
                                        </label>

                                        <!-- Alpa -->
                                        <label class="relative flex items-center justify-center px-4 py-2 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 select-none transition-all has-[:checked]:bg-rose-500 has-[:checked]:border-rose-500 has-[:checked]:text-white has-[:checked]:shadow-sm">
                                            <input type="radio" name="presensi[{{ $mhs->id }}][status]" value="Alpa" class="sr-only" onclick="toggleKeterangan({{ $mhs->id }}, false)">
                                            <span class="text-xs font-bold">Alpa</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <input type="text" name="presensi[{{ $mhs->id }}][keterangan]" id="keterangan-{{ $mhs->id }}" disabled placeholder="Hadir tidak perlu keterangan" class="w-full px-3 py-1.5 bg-slate-100 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-brand-500 focus:bg-white transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Submit footer -->
            <div class="p-6 border-t border-slate-100 bg-slate-50/30 flex items-center justify-end gap-3">
                <a href="{{ route('presensi.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white font-semibold text-sm rounded-xl shadow-md shadow-brand-600/15 transition-all">
                    Simpan Presensi
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Toggle active state and requirement of Keterangan input
    function toggleKeterangan(mahasiswaId, show) {
        const input = document.getElementById('keterangan-' + mahasiswaId);
        if(input) {
            if(show) {
                input.removeAttribute('disabled');
                input.placeholder = "Tulis alasan sakit/izin...";
                input.classList.remove('bg-slate-100');
            } else {
                input.value = "";
                input.setAttribute('disabled', 'true');
                input.placeholder = "Hadir tidak perlu keterangan";
                input.classList.add('bg-slate-100');
            }
        }
    }

    // Set all radio buttons to a specific status
    function markAll(status) {
        const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
        radios.forEach(radio => {
            radio.checked = true;
            
            // Trigger change event to update form states
            const changeEvent = new Event('change', { bubbles: true });
            radio.dispatchEvent(changeEvent);

            // Fetch student ID from name: "presensi[ID][status]"
            const nameMatch = radio.name.match(/presensi\[(\d+)\]/);
            if(nameMatch && nameMatch[1]) {
                const mhsId = nameMatch[1];
                const showKet = (status === 'Sakit' || status === 'Izin');
                toggleKeterangan(mhsId, showKet);
            }
        });
    }

    // Refresh on date change
    const dateInput = document.getElementById('tanggal');
    if(dateInput) {
        dateInput.addEventListener('change', function() {
            window.location.href = "{{ route('presensi.create') }}?tanggal=" + this.value + "&kelas_kuliah_id={{ $kelas->id }}";
        });
    }
</script>
@endsection
