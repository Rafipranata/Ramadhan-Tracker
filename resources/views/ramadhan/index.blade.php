<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramadhan Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            /* Versi revisi gradasi: Deep Blue ke Midnight */
            background: linear-gradient(to bottom right, #000428, #004e92);
            min-height: 100vh;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="text-white font-sans antialiased" x-data="trackerApp()">

    <div x-show="!nameSet" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/90 backdrop-blur-sm">
        <div class="bg-slate-900 border border-white/20 p-8 rounded-3xl w-full max-w-sm text-center shadow-2xl">
            <div class="mb-6">
                <div class="w-20 h-20 bg-blue-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">🌙</span>
                </div>
                <h2 class="text-2xl font-bold">Ahlan wa Sahlan</h2>
                <p class="text-gray-400 text-sm mt-2">Silakan masukkan nama Anda untuk memulai tracking ibadah.</p>
            </div>
            <input type="text" x-model="tempName" placeholder="Masukkan Nama..."
                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 mb-4 outline-none focus:ring-2 focus:ring-blue-500">
            <button @click="saveName()"
                class="w-full bg-blue-600 py-3 rounded-xl font-bold transition active:scale-95">Mulai</button>
        </div>
    </div>

    <div class="max-w-md mx-auto p-5 space-y-6">
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <p class="text-sm opacity-80">Selamat Datang,</p>
                    <h2 class="text-xl font-bold" x-text="name || '{nama}'"></h2>
                </div>
                <p class="text-xs opacity-70" x-text="formatDate(currentViewDate)"></p>
            </div>
            <div class="text-center py-4">
                <h1 class="text-5xl font-extrabold tracking-widest" x-text="currentTime">00:00</h1>
                <p class="mt-2 text-blue-300 uppercase tracking-widest text-sm">Waktu</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <button class="bg-white/10 hover:bg-white/20 p-4 rounded-xl border border-white/10 transition">
                Al-Quran
            </button>
            <button class="bg-white/10 hover:bg-white/20 p-4 rounded-xl border border-white/10 transition">
                Doa Harian
            </button>
        </div>

        <div class="bg-white/5 p-4 rounded-xl border border-white/10 flex items-center gap-3">
            <input type="date" x-model="startDate"
                class="bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-sm flex-1 outline-none">
            <button @click="saveSettings()" class="bg-blue-600 px-4 py-2 rounded-lg text-sm font-bold">Simpan</button>
        </div>



        <div class="bg-white/10 backdrop-blur-lg rounded-t-3xl p-6 border-t border-x border-white/20 min-h-[500px]">
            <div class="text-center mb-6">
                <h3 class="text-lg font-bold">Ramadhan ke-<span x-text="ramadhanDay">1</span></h3>
                <p class="text-[10px] opacity-50 italic uppercase tracking-widest">Ibadah Hari Ini</p>
            </div>

            <div class="bg-white/5 rounded-2xl p-3 mb-4 border border-white/10 flex items-center justify-between">
                <button @click="changeDate(-1)" class="p-2 hover:bg-white/10 rounded-full transition">
                    ◀ </button>

                <div class="text-center">
                    <span class="font-bold text-blue-300"
                        x-text="currentViewDate === actualToday ? 'Hari Ini' : currentViewDate"></span>
                </div>

                <button @click="changeDate(1)" :disabled="currentViewDate === actualToday"
                    :class="currentViewDate === actualToday ? 'opacity-20' : ''"
                    class="p-2 hover:bg-white/10 rounded-full transition">
                    ▶ </button>
            </div>

            <template x-if="currentViewDate !== actualToday">
                <div
                    class="bg-yellow-500/20 text-yellow-200 text-[10px] p-2 rounded-lg text-center mb-4 border border-yellow-500/30">
                    Anda sedang melihat riwayat hari sebelumnya.
                </div>
            </template>

            <div class="flex justify-around mb-8 border-b border-white/10">
                <button @click="activeTab = 'salat'"
                    :class="activeTab === 'salat' ? 'border-b-2 border-blue-400 text-blue-400' : 'opacity-40'"
                    class="pb-3 text-xs font-bold uppercase transition-all">Salat</button>
                <button @click="activeTab = 'quran'"
                    :class="activeTab === 'quran' ? 'border-b-2 border-blue-400 text-blue-400' : 'opacity-40'"
                    class="pb-3 text-xs font-bold uppercase transition-all">Quran</button>
                <button @click="activeTab = 'daily'"
                    :class="activeTab === 'daily' ? 'border-b-2 border-blue-400 text-blue-400' : 'opacity-40'"
                    class="pb-3 text-xs font-bold uppercase transition-all">Daily</button>
            </div>

            <div x-show="activeTab === 'salat'" x-transition:enter.duration.300ms>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="opacity-50 border-b border-white/5 text-xs">
                            <th class="py-2 text-left">WAKTU</th>
                            <th class="py-2 text-center">FARDU</th>
                            <th class="py-2 text-center">SUNNAH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="sholat in ['Fajr', 'Zuhr', 'Asr', 'Maghrib', 'Isha', 'Tarawih', 'Duha']"
                            :key="sholat">
                            <tr class="border-b border-white/5">
                                <td class="py-4 font-bold" x-text="sholat"></td>
                                <td class="py-4 text-center">
                                    <input type="checkbox" @change="toggleCheck(sholat, 'fardu')"
                                        :checked="getCheck(sholat, 'fardu')" class="w-5 h-5 accent-blue-500">
                                </td>
                                <td class="py-4 text-center">
                                    <input type="checkbox" @change="toggleCheck(sholat, 'sunnah')"
                                        :checked="getCheck(sholat, 'sunnah')" class="w-5 h-5 accent-blue-500">
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div x-show="activeTab === 'quran'" x-transition:enter.duration.300ms>
                <div class="flex items-center gap-2 mb-6">
                    <div class="p-2 bg-green-500/20 rounded-lg">📖</div>
                    <h3 class="text-xl font-bold">Quran Tracker</h3>
                </div>

                <div class="space-y-4">
                    <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                        <label class="block text-[10px] uppercase tracking-widest opacity-50 mb-2 text-center">Pilih
                            Juz</label>
                        <select x-model="quranData.juz" @change="saveQuran()"
                            class="w-full bg-slate-900/50 text-white rounded-xl p-3 outline-none border border-white/10 appearance-none text-center font-bold">
                            <option value="">-- Pilih Juz --</option>
                            <template x-for="n in 30" :key="n">
                                <option :value="n" :selected="quranData.juz == n" x-text="'Juz ' + n"></option>
                            </template>
                        </select>
                    </div>

                    <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                        <label class="block text-[10px] uppercase tracking-widest opacity-50 mb-2 text-center">Pilih
                            Surah</label>
                        <select x-model="quranData.surah" @change="saveQuran()"
                            class="w-full bg-slate-900/50 text-white rounded-xl p-3 outline-none border border-white/10 appearance-none text-center font-bold">
                            <option value="">-- Pilih Surah --</option>
                            <template x-for="(sName, index) in surahList" :key="index">
                                <option :value="sName" :selected="quranData.surah == sName"
                                    x-text="(index + 1) + '. ' + sName"></option>
                            </template>
                        </select>
                    </div>

                    <div class="bg-white/5 p-4 rounded-2xl border border-white/10 text-center">
                        <label class="block text-[10px] uppercase tracking-widest opacity-50 mb-2">Progres Ayat</label>
                        <input type="text" x-model="quranData.ayat" @input="saveQuran()" placeholder="1-7"
                            class="w-full bg-transparent text-2xl font-bold text-center outline-none focus:text-green-400">
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'daily'" x-transition:enter.duration.300ms
                class="text-center py-20 opacity-30 italic text-sm">
                Fitur Daily Checklist sedang disiapkan... 🌙
            </div>
        </div>
    </div>
    <div class="h-32"></div>
    <nav
        class="fixed bottom-0 left-0 right-0 bg-slate-900/80 backdrop-blur-lg border-t border-white/10 pb-6 pt-3 px-6 z-50">
        <div class="max-w-md mx-auto flex justify-between items-center">

            <a href="{{ route('home') }}"
                class="flex flex-col items-center gap-1 transition-all {{ request()->routeIs('home') ? 'text-blue-400 scale-110' : 'text-white/40' }}">
                <div class="text-xl">🏠</div>
                <span class="text-[10px] font-medium">Home</span>
            </a>

            <a href="{{ route('dzikir') }}"
                class="flex flex-col items-center gap-1 transition-all {{ request()->routeIs('dzikir') ? 'text-blue-400 scale-110' : 'text-white/40' }}">
                <div class="text-xl">📿</div>
                <span class="text-[10px] font-medium">Dzikir</span>
            </a>

            <a href="{{ route('profile') }}"
                class="flex flex-col items-center gap-1 transition-all {{ request()->routeIs('profile') ? 'text-blue-400 scale-110' : 'text-white/40' }}">
                <div class="text-xl">👤</div>
                <span class="text-[10px] font-medium">User</span>
            </a>

        </div>
    </nav>




    <script>
        function trackerApp() {
        return {
            name: localStorage.getItem('user_name') || '',
            tempName: '',
            nameSet: !!localStorage.getItem('user_name'),
            activeTab: 'salat',
            startDate: localStorage.getItem('ramadhan_start') || '',
            currentTime: '',

            
            
            // --- LOGIKA HISTORY TANGGAL ---
            // actualToday adalah jangkar tanggal hari ini (tidak berubah)
            actualToday: new Date().toISOString().split('T')[0],
            // currentViewDate adalah tanggal yang sedang dibuka di UI (bisa maju/mundur)
            currentViewDate: new Date().toISOString().split('T')[0],

            formatDate(dateString) {
            if(!dateString) return '';
            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        },
            
            ramadhanDay: 1,

init() {
                // 1. Jalankan update jam pertama kali
                this.updateTime(); 

                // 2. Set interval agar jam terus berjalan setiap detik
                setInterval(() => {
                    this.updateTime();
                }, 1000);

                // 3. Logika Edit Nama dari URL (agar pop-up muncul saat klik dari Profile)
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('edit')) {
                    this.nameSet = false;
                    this.tempName = this.name;
                }

                this.calculateRamadhanDay();
                this.loadDailyData();
            },

            // Fungsi khusus untuk mengupdate jam
            updateTime() {
                const now = new Date();
                this.currentTime = now.getHours().toString().padStart(2, '0') + ':' + 
                                 now.getMinutes().toString().padStart(2, '0');
            },

            // Fungsi navigasi tanggal
            changeDate(offset) {
                let d = new Date(this.currentViewDate);
                d.setDate(d.getDate() + offset);
                
                // Mencegah user melihat masa depan (opsional)
                if (d > new Date()) return;

                this.currentViewDate = d.toISOString().split('T')[0];
                this.loadDailyData();
                this.calculateRamadhanDay();
            },

            // Memuat data dari localstorage berdasarkan tanggal yang aktif
            loadDailyData() {
                const date = this.currentViewDate;
                this.quranData.juz = localStorage.getItem(`${date}_quran_juz`) || '';
                this.quranData.surah = localStorage.getItem(`${date}_quran_surah`) || '';
                this.quranData.ayat = localStorage.getItem(`${date}_quran_ayat`) || '';
            },

            saveName() {
                if (this.tempName.trim()) {
                    this.name = this.tempName;
                    localStorage.setItem('user_name', this.name);
                    this.nameSet = true;

                    // Bersihkan URL tanpa reload halaman agar tanda ?edit=true hilang
                    const url = new URL(window.location);
                    url.searchParams.delete('edit');
                    window.history.replaceState({}, '', url);
                }
            },

            saveSettings() {
                localStorage.setItem('ramadhan_start', this.startDate);
                this.calculateRamadhanDay();
            },

            calculateRamadhanDay() {
                if (!this.startDate) return;
                const start = new Date(this.startDate);
                // Menghitung ramadhan ke-n berdasarkan tanggal yang sedang DILIHAT
                const target = new Date(this.currentViewDate);
                
                start.setHours(0,0,0,0);
                target.setHours(0,0,0,0);
                
                const diffDays = Math.floor((target - start) / (1000 * 60 * 60 * 24)) + 1;
                this.ramadhanDay = diffDays > 0 ? diffDays : 1;
            },

            // --- LOGIKA SHOLAT (HISTORY BASED) ---
            toggleCheck(sholat, tipe) {
                const date = this.currentViewDate;
                const id = `${date}_${sholat}_${tipe}`;
                const val = localStorage.getItem(id) === 'true';
                localStorage.setItem(id, !val);
            },
            getCheck(sholat, tipe) {
                const date = this.currentViewDate;
                return localStorage.getItem(`${date}_${sholat}_${tipe}`) === 'true';
            },

            // --- LOGIKA QURAN (HISTORY BASED) ---
            quranData: { juz: '', surah: '', ayat: '' },
            
            saveQuran() {
                const date = this.currentViewDate;
                localStorage.setItem(`${date}_quran_juz`, this.quranData.juz);
                localStorage.setItem(`${date}_quran_surah`, this.quranData.surah);
                localStorage.setItem(`${date}_quran_ayat`, this.quranData.ayat);
            },

            surahList: [
                "Al-Fatihah", "Al-Baqarah", "Ali 'Imran", "An-Nisa'", "Al-Ma'idah", "Al-An'am", 
                "Al-A'raf", "Al-Anfal", "At-Tawbah", "Yunus", "Hud", "Yusuf", "Ar-Ra'd", 
                "Ibrahim", "Al-Hijr", "An-Nahl", "Al-Isra'", "Al-Kahf", "Maryam", "Ta-Ha", 
                "Al-Anbiya'", "Al-Hajj", "Al-Mu'minun", "An-Nur", "Al-Furqan", "Ash-Shu'ara'", 
                "An-Naml", "Al-Qasas", "Al-'Ankabut", "Ar-Rum", "Surah Luqman","Surah As-Sajda",
                "Surah Al-Ahzab","Surah Ya-Sin","Surah Az-Zumar","Surah Fussilat","Surah Al-Ahqaf",
                "Surah Muhammad","Surah Al-Fath","Surah Al-Hujurat","Surah Qamar","Surah Ar-Rahman",
                "Surah Al-Mulk","Surah Al-Qalam","Surah Al-Haaqqa","Surah Al-Ma'arij","Surah Nuh",
                "Surah Al-Jinn","Surah Al-Muzzammil","Surah Al-Mudaththir","Surah Al-Qiyama",
                "Surah Al-Insan","Surah Al-Mursalat","Surah An-Naba","Surah An-Nazi'at","Surah Abasa",
                "Surah At-Takwir","Surah Al-Infitar","Surah Al-Mutaffifin","Surah Al-Inshiqaq",
                "Surah Al-Buruj","Surah At-Tariq","Surah Al-A'la","Surah Al-Ghashiya","Surah Al-Fajr",
                "Surah Al-Balad","Surah Ash-Shams","Surah Al-Lail","Surah Ad-Duhaa","Surah Al-Inshirah",
                "Surah At-Tin","Surah Al-Alaq","Surah Al-Qadr","Surah Al-Bayyina","Surah Az-Zalzalah",
                "Surah Al-Adiyat","Surah Al-Qari'ah","Surah At-Takatsur","Surah Al-Asr",
                "Surah Al-Humazah","Surah Al-Fil","Surah Quraish","Surah Al-Ma'un","Surah Al-Kawthar",
                "Surah Al-Kafirun","Surah An-Nasr","Surah Al-Masad","Surah Al-Ikhlas","Surah Al-Falaq","Surah An-Nas"
            ]
        }
    }
    </script>
</body>

</html>