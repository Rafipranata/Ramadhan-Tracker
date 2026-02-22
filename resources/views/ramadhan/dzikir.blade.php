@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-5 space-y-6" x-data="dzikirCounter()">
    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl text-center">
        <h2 class="text-xl font-bold text-blue-300">Tasbih Digital</h2>
        <p class="text-xs opacity-60 uppercase tracking-widest mt-1">Fokus & Istiqomah</p>
    </div>

    <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 shadow-2xl flex flex-col items-center justify-center min-h-[450px]">
        
        <div @click="increment()" 
             class="w-64 h-64 rounded-full border-8 border-blue-500/30 flex items-center justify-center bg-white/5 shadow-[0_0_50px_rgba(59,130,246,0.2)] cursor-pointer active:scale-95 transition-transform duration-75 relative overflow-hidden group">
            
            <div class="absolute inset-0 bg-blue-500/10 opacity-0 group-active:opacity-100 transition-opacity"></div>
            
            <span class="text-7xl font-black tracking-tighter text-white" x-text="count">0</span>
        </div>

        <p class="mt-8 text-sm opacity-50 animate-pulse">Ketuk lingkaran untuk menghitung</p>

        <div class="grid grid-cols-1 w-full gap-4 mt-10">
            <button @click="resetCount()" 
                    class="bg-red-500/20 hover:bg-red-500/40 border border-red-500/50 py-4 rounded-2xl font-bold text-red-200 transition active:scale-95">
                Mulai Ulang (Reset)
            </button>
        </div>
    </div>

    <div class="bg-blue-500/10 border border-blue-500/20 p-4 rounded-xl text-center">
        <p class="text-xs text-blue-200 italic">"Basahilah lidahmu dengan terus berdzikir kepada Allah."</p>
    </div>
</div>

<script>
    function dzikirCounter() {
        return {
            // Mengambil hitungan terakhir dari storage agar tidak hilang saat pindah halaman
            count: parseInt(localStorage.getItem('dzikir_count')) || 0,
            
            increment() {
                this.count++;
                this.save();
                // Opsional: Tambahkan getaran (vibrate) singkat di HP
                if (navigator.vibrate) navigator.vibrate(50);
            },
            
            resetCount() {
                if(confirm('Mulai ulang hitungan dari 0?')) {
                    this.count = 0;
                    this.save();
                }
            },
            
            save() {
                localStorage.setItem('dzikir_count', this.count);
            }
        }
    }
</script>
@endsection