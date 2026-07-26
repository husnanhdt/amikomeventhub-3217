@extends('layouts.app')
@section('title', 'Pembayaran - ' . $transaction->event->title)
@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-black mb-2">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mb-8">Mohon selesaikan pembayaran tiket Anda untuk event <strong>{{ $transaction->event->title }}</strong>.</p>

        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 mb-8">
            <p class="text-sm text-slate-400 font-bold uppercase tracking-wider mb-1">Total Tagihan</p>
            <h3 class="text-4xl font-extrabold text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-400 mt-2">Order ID: {{ $transaction->order_id }}</p>
        </div>

        <button id="pay-button" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition animate-bounce-in">
            Bayar Sekarang
        </button>
    </div>
</main>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    const snapToken = '{{ $transaction->snap_token }}';
    const payButton = document.getElementById('pay-button');
    
    // Simpan HTML asli button
    const originalButtonHtml = payButton.innerHTML;
    
    if (!snapToken || snapToken === 'null' || snapToken === '') {
        payButton.disabled = true;
        payButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
        payButton.classList.add('bg-gray-400', 'cursor-not-allowed');
        payButton.innerHTML = 'Token Pembayaran Tidak Tersedia';
    } else {
        payButton.onclick = function() {
            setLoadingState(true);
            
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    // Redirect otomatis
                    window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
                },
                onPending: function(result) {
                    window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
                },
                onError: function(result) {
                    setLoadingState(false);
                    alert("Pembayaran Gagal! Silakan coba lagi atau hubungi admin.");
                },
                onClose: function() {
                    setLoadingState(false);
                }
            });
        };
        
        // Auto-click setelah 2 detik
        setTimeout(function() {
            if (!payButton.disabled) {
                payButton.click();
            }
        }, 2000);
    }
    
    // Fungsi untuk set loading state
    function setLoadingState(isLoading) {
        if (isLoading) {
            payButton.disabled = true;
            payButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700', 'animate-bounce-in');
            payButton.classList.add('bg-indigo-400', 'cursor-wait');
            payButton.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memproses Pembayaran...</span>
                </span>
            `;
        } else {
            payButton.disabled = false;
            payButton.classList.remove('bg-indigo-400', 'cursor-wait');
            payButton.classList.add('bg-indigo-600', 'hover:bg-indigo-700', 'animate-bounce-in');
            payButton.innerHTML = originalButtonHtml;
        }
    }
</script>
<style>
    @keyframes bounce-in {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }

        70% {
            transform: scale(1.05);
            opacity: 1;
        }

        100% {
            transform: scale(1);
        }
    }

    .animate-bounce-in {
        animation: bounce-in 0.4s ease-out forwards;
    }
</style>
@endsection