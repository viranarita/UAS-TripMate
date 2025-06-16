@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="min-h-screen pt-25 bg-gray-100 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md text-center">

        @if(session('payment_success'))
            {{-- Tampilan setelah pembayaran --}}
            <h2 class="text-2xl font-semibold text-green-600 mb-4">Pembayaran Berhasil!</h2>
            <p class="text-gray-700 mb-4">Terima kasih! Pembayaran Anda telah kami terima.</p>
            <a href="{{ route('index') }}" class="inline-block mt-4 px-6 py-2 bg-primary text-white rounded hover:bg-red-700 transition">
                Kembali ke Beranda
            </a>
        @else
            {{-- Tampilan form pembayaran --}}
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ringkasan Pembayaran</h2>
            <div class="mb-4">
                <p class="text-gray-600">Total yang harus dibayar:</p>
                <p class="text-3xl font-bold text-primary mt-2">
                    Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}
                </p>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-500">*Ini adalah halaman dummy. Tidak ada transaksi yang benar-benar dilakukan.</p>
            </div>

            <form action="{{ route('payment') }}" method="POST">
                @csrf
                <input type="hidden" name="total_price" value="{{ $totalPrice ?? 0 }}">
                <input type="hidden" name="list_id" value="{{ $listId }}">
                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition">
                    Konfirmasi Pembayaran
                </button>
            </form>            
        @endif

    </div>
</div>
@endsection
