@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-5 space-y-6" x-data="profileApp()">
    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20 shadow-xl flex items-center gap-5">
        <div
            class="w-20 h-20 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center border-4 border-white/20 shadow-lg">
            <span class="text-3xl">👤</span>
        </div>

        <div class="flex-1">
            <h2 class="text-2xl font-bold text-white" x-text="name || 'Hamba Allah'"></h2>
            <p class="text-sm text-blue-300 opacity-80" x-text="formatDate(actualToday)"></p>
        </div>
    </div>

    <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-6 border border-white/20 shadow-xl">
        <div class="flex justify-between items-end mb-4">
            <h3 class="font-bold text-lg">Ramadhan Progress</h3>
            <span class="text-blue-400 font-black text-2xl" x-text="calculateProgress() + '%'"></span>
        </div>

        <div x-data="profileApp()" x-init="init()"
            class="w-full h-6 bg-slate-800 rounded-full border border-white/10 overflow-hidden p-1">
            <div :style="'width: ' + calculateProgress() + '%'"
                class="h-full bg-gradient-to-r from-blue-600 to-blue-400 rounded-full transition-all duration-1000 ease-out shadow-[0_0_15px_rgba(59,130,246,0.5)]">
            </div>
        </div>

        <div class="flex justify-between mt-3 text-[10px] uppercase tracking-widest opacity-50">
            <span>Hari 1</span>
            <span x-text="`Target: Hari ${ramadhanDay} dari 30`"></span>
            <span>Hari 30</span>
        </div>

    </div>

    <div class="grid grid-cols-1 gap-3">
        <button @click="window.location.href='/?edit=true'"
            class="w-full bg-white/5 hover:bg-white/10 p-4 rounded-2xl border border-white/10 flex justify-between items-center transition">
            <div class="flex items-center gap-3">
                <span>✏️</span>
                <span class="font-medium">Ubah Nama Panggilan</span>
            </div>
            <span class="opacity-30">➔</span>
        </button>

        <div class="w-full bg-white/5 p-4 rounded-2xl border border-white/10 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span>📅</span>
                <span class="font-medium">Mulai Ramadhan</span>
            </div>
            <input type="date" x-model="startDate" @change="saveSettings()"
                class="bg-transparent text-blue-300 font-bold outline-none text-right">
        </div>
    </div>
</div>

<script>
    function profileApp() {
        return {
            name: localStorage.getItem('user_name') || '',
            startDate: localStorage.getItem('ramadhan_start') || '', 
            actualToday: new Date().toISOString().split('T')[0],
            ramadhanDay: 0,

            init() {
                this.calculateRamadhanDay();
            },

            formatDate(dateString) {
                if (!dateString) return '-';
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            },

            calculateRamadhanDay() {
                if (!this.startDate) {
                    this.ramadhanDay = 0;
                    return;
                }

                const start = new Date(this.startDate);
                const now = new Date();
                
                start.setHours(0, 0, 0, 0);
                now.setHours(0, 0, 0, 0);

                const timeDiff = now.getTime() - start.getTime();
                const diffDays = Math.floor(timeDiff / (1000 * 60 * 60 * 24)) + 1;
                
                this.ramadhanDay = diffDays > 0 ? diffDays : 0;
            },

            calculateProgress() {
                if (this.ramadhanDay <= 0) return 0;

                let progress = Math.round((this.ramadhanDay / 30) * 100);
                
                return Math.min(Math.max(progress, 0), 100);
            },

            saveSettings() {
                localStorage.setItem('ramadhan_start', this.startDate);
                this.calculateRamadhanDay();
                console.log("Tanggal mulai disimpan:", this.startDate);
            }
        }
    }
</script>
@endsection