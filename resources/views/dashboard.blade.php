<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-gray-700 uppercase text-sm">Sistem Inventaris - {{ auth()->user()->role }}</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if(session('success'))
            <div class="p-3 bg-indigo-600 text-white text-[10px] font-bold rounded uppercase shadow-sm">
                INFO: {{ session('success') }}
            </div>
        @endif

        @if(auth()->user()->role == 'admin')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-white border rounded shadow-sm">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-3">Manajemen User</h3>
                <form action="{{ route('user.store') }}" method="POST" class="flex flex-col gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Nama" class="text-xs border-gray-300 rounded focus:ring-0" required>
                    <input type="email" name="email" placeholder="Email" class="text-xs border-gray-300 rounded focus:ring-0" required>
                    <input type="password" name="password" placeholder="Pass" class="text-xs border-gray-300 rounded focus:ring-0" required>
                    <select name="role" class="text-xs border-gray-300 rounded focus:ring-0">
                        <option value="peminjam">Siswa</option>
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button class="bg-indigo-600 text-white py-2 rounded text-[10px] font-bold uppercase hover:bg-indigo-700 transition">Simpan User</button>
                </form>
            </div>

            <div class="space-y-4">
                <div class="p-4 bg-white border rounded shadow-sm">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-3">Tambah Kategori</h3>
                    <form action="{{ route('kategori.store') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="nama_kategori" placeholder="Kategori Baru" class="text-xs flex-1 border-gray-300 rounded focus:ring-0" required>
                        <button class="bg-gray-800 text-white px-4 py-1 rounded text-[10px] font-bold uppercase hover:bg-black transition">Simpan</button>
                    </form>
                </div>
                
                <div class="p-4 bg-white border rounded shadow-sm">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-3">Update Master Alat</h3>
                    <form action="{{ route('barang.store') }}" method="POST" class="flex flex-col gap-2">
                        @csrf
                        <div class="flex gap-2">
                            <select name="kategori_id" class="text-xs border-gray-300 rounded flex-1 focus:ring-0">
                                @foreach($kategoris as $k) <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option> @endforeach
                            </select>
                            <input type="number" name="stok" placeholder="Stok" class="text-xs w-20 border-gray-300 rounded focus:ring-0" required>
                        </div>
                        <input type="text" name="nama_barang" placeholder="Nama Alat Baru" class="text-xs border-gray-300 rounded focus:ring-0" required>
                        <button class="bg-indigo-600 text-white py-2 rounded text-[10px] font-bold uppercase hover:bg-indigo-700 transition">Tambah Alat</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white border rounded shadow-sm">
            <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-3">Input Peminjaman Manual</h3>
            <form action="{{ route('pinjam.adminStore') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-2">
                @csrf
                <select name="user_id" class="text-xs border-gray-300 rounded focus:ring-0">
                    @foreach($users->where('role', 'peminjam') as $u) <option value="{{ $u->id }}">{{ $u->name }}</option> @endforeach
                </select>
                <select name="barang_id" class="text-xs border-gray-300 rounded focus:ring-0">
                    @foreach($barangs as $b) <option value="{{ $b->id }}">{{ $b->nama_barang }}</option> @endforeach
                </select>
                <input type="number" name="jumlah" value="1" min="1" class="text-xs border-gray-300 rounded focus:ring-0">
                <button class="bg-indigo-600 text-white text-[10px] font-bold uppercase rounded hover:bg-indigo-700 transition">Input Pinjam</button>
            </form>
        </div>
        @endif

        @if(auth()->user()->role == 'petugas' || auth()->user()->role == 'admin')
        <div class="p-4 bg-white border rounded shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Daftar Transaksi</h3>
                @if(auth()->user()->role == 'petugas') 
                    <button onclick="window.print()" class="bg-blue-600 text-white px-3 py-1 text-[9px] rounded font-bold no-print shadow-sm">CETAK LAPORAN</button> 
                @endif
            </div>
            <table class="w-full text-left text-[11px]">
                <thead>
                    <tr class="border-b text-gray-400 uppercase font-black">
                        <th class="py-2">Peminjam</th>
                        <th class="py-2">Alat</th>
                        <th class="py-2 text-center">Status</th>
                        <th class="py-2 text-right no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $p)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 font-medium">{{ $p->user->name }}</td>
                        <td class="py-3">{{ $p->barang->nama_barang ?? '-' }} ({{ $p->jumlah }})</td>
                        <td class="py-3 text-center">
                            <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase italic bg-gray-100 {{ strtoupper($p->status) == 'APPROVED' ? 'text-blue-600' : 'text-indigo-500' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="py-3 text-right no-print">
                            @php $st = strtoupper($p->status); @endphp
                            
                            {{-- AKSI KHUSUS PETUGAS (SETUJU/TOLAK) --}}
                            @if(auth()->user()->role == 'petugas')
                                @if($st == 'PENDING')
                                    <a href="{{ route('pinjam.status', [$p->id, 'approved']) }}" class="text-green-600 font-bold border border-green-600 px-2 py-1 rounded text-[9px] mr-1 hover:bg-green-50">SETUJU</a>
                                    <a href="{{ route('pinjam.status', [$p->id, 'rejected']) }}" class="text-red-500 font-bold border border-red-500 px-2 py-1 rounded text-[9px] hover:bg-red-50">TOLAK</a>
                                @endif
                            @endif

                            {{-- AKSI UNTUK PETUGAS & ADMIN (ISI KEMBALI & HAPUS) --}}
                            @if($st == 'APPROVED')
                                <a href="{{ route('pinjam.status', [$p->id, 'returned']) }}" class="bg-indigo-600 text-white px-2 py-1 rounded text-[9px] font-bold hover:bg-indigo-700">KEMBALI</a>
                            @endif
                            
                            <form action="{{ route('pinjam.destroy', $p->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-gray-300 ml-2 hover:text-red-500 transition font-bold" onclick="return confirm('Hapus transaksi ini?')">HAPUS</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if(auth()->user()->role == 'peminjam')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-white border rounded shadow-sm">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-4 tracking-tighter">Form Pinjam Alat</h3>
                <form action="{{ route('pinjam.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <select id="siswa_filter" class="w-full text-xs border-gray-300 rounded focus:ring-0">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $k) <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option> @endforeach
                    </select>
                    <select name="barang_id" id="siswa_alat" class="w-full text-xs border-gray-300 rounded focus:ring-0" required>
                        <option value="">Pilih Alat</option>
                        @foreach($barangs as $b) 
                            <option value="{{ $b->id }}" data-kategori="{{ $b->kategori_id }}" data-stok="{{ $b->stok }}">
                                {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                            </option> 
                        @endforeach
                    </select>
                    <input type="number" name="jumlah" id="siswa_jumlah" min="1" value="1" class="w-full text-xs border-gray-300 rounded focus:ring-0" required>
                    <button class="w-full bg-green-600 text-white py-2 rounded text-[10px] font-bold uppercase hover:bg-green-700 transition shadow-sm">Kirim Pengajuan</button>
                </form>
            </div>

            <div class="p-4 bg-white border rounded shadow-sm md:col-span-2">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-4 tracking-tighter">Riwayat Pinjaman Saya</h3>
                <table class="w-full text-left text-[11px]">
                    <thead><tr class="border-b text-gray-400 uppercase font-bold"><th class="py-2">Barang</th><th class="py-2">Jumlah</th><th class="py-2 text-center">Status</th></tr></thead>
                    <tbody>
                        @forelse($peminjamans->where('user_id', auth()->id()) as $p)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="py-3 font-medium">{{ $p->barang->nama_barang ?? '-' }}</td>
                            <td class="py-3">{{ $p->jumlah }}</td>
                            <td class="py-3 text-center uppercase font-extrabold text-[9px] text-indigo-500 italic">{{ $p->status }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="py-6 text-center text-gray-400 italic">Belum ada riwayat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if(auth()->user()->role == 'admin')
        <div class="p-4 bg-gray-50 border rounded shadow-sm text-[10px]">
            <h3 class="font-bold text-gray-400 uppercase mb-3 tracking-widest">Audit Log Aktifitas</h3>
            <div class="max-h-24 overflow-y-auto space-y-1 custom-scrollbar">
                @foreach($logs as $log)
                <div class="flex justify-between border-b border-gray-100 py-1">
                    <span><strong>{{ $log->user->name ?? 'Sistem' }}</strong>: {{ $log->activity }}</span>
                    <span class="text-gray-300 italic">{{ $log->created_at->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <script>
        const filterKat = document.getElementById('siswa_filter');
        const selectAlat = document.getElementById('siswa_alat');
        const inputJumlah = document.getElementById('siswa_jumlah');

        filterKat?.addEventListener('change', function() {
            let katId = this.value;
            selectAlat.querySelectorAll('option').forEach(opt => {
                if(opt.value === "") return;
                opt.style.display = (katId === "" || opt.getAttribute('data-kategori') === katId) ? 'block' : 'none';
            });
            selectAlat.value = "";
        });

        selectAlat?.addEventListener('change', function() {
            let stok = this.options[this.selectedIndex].getAttribute('data-stok');
            if(stok) {
                inputJumlah.max = stok;
                inputJumlah.placeholder = "Max: " + stok;
            }
        });
    </script>
</x-app-layout>