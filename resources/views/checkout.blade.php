@extends('layouts.landlayout')

@section('content')
<div class="mx-auto max-w-3xl px-6 py-12 lg:px-8">
    <div class="mb-8">
        <p class="mb-2 text-sm font-bold uppercase tracking-[.18em] text-teal-700">Beli Sekarang</p>
        <h1 class="text-3xl font-bold text-slate-900">Konfirmasi Pembelian</h1>
        <p class="mt-2 text-slate-500">Pastikan produk dan jumlahnya sudah sesuai sebelum pesanan dibuat.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ $errors->first() }}</div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="border-b border-slate-100 pb-5">
            @foreach($items as $item)
                <div class="flex items-start justify-between gap-4 {{ !$loop->last ? 'mb-4' : '' }}">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-teal-700">{{ $item['category'] }}</p>
                        <h2 class="mt-2 text-lg font-bold text-slate-900">{{ $item['name'] }}</h2>
                        <p class="mt-1 text-sm text-slate-500">Jumlah: {{ $item['quantity'] }}</p>
                        <a href="{{ config('products.inventory_spreadsheet_url') }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-teal-700 hover:text-teal-900">
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i> Lihat detail stok
                        </a>
                    </div>
                    <p class="text-right font-bold text-slate-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                </div>
            @endforeach
            <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                <span class="font-semibold text-slate-600">Total transaksi</span>
                <span class="text-xl font-bold text-slate-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('checkout.confirm') }}" method="POST" class="mt-6" id="checkout-form">
            @csrf
            <section class="mb-6 border-b border-slate-100 pb-6" aria-labelledby="branch-selection-title">
                <h2 id="branch-selection-title" class="text-base font-bold text-slate-900">Pilih cabang Optik Gumelar</h2>
                <p class="mt-1 text-sm text-slate-500">Izinkan akses lokasi untuk menghitung perkiraan jarak garis lurus ke setiap cabang.</p>
                <input type="hidden" name="buyer_latitude" id="buyer-latitude" value="{{ old('buyer_latitude') }}">
                <input type="hidden" name="buyer_longitude" id="buyer-longitude" value="{{ old('buyer_longitude') }}">
                <button type="button" id="locate-button" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-teal-700 px-4 py-2.5 text-sm font-bold text-white hover:bg-teal-800">
                    <i class="bi bi-geo-alt" aria-hidden="true"></i>
                    <span>Izinkan lokasi & hitung jarak</span>
                </button>
                <p id="location-status" class="mt-3 text-sm text-slate-500" role="status" aria-live="polite">Lokasi belum diambil.</p>
                <div id="branch-options" class="mt-4 grid gap-3 sm:grid-cols-2" role="radiogroup" aria-labelledby="branch-selection-title"></div>
                @error('branch_id')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
                @error('buyer_latitude')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
                @error('buyer_longitude')<p class="mt-2 text-sm text-rose-700">{{ $message }}</p>@enderror
            </section>
            <label for="notes" class="block text-sm font-semibold text-slate-700">Catatan pesanan <span class="font-normal text-slate-400">(opsional)</span></label>
            <textarea id="notes" name="notes" rows="3" maxlength="500" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-teal-500 focus:outline-none" placeholder="Tambahkan kebutuhan atau catatan khusus"></textarea>
            <label class="mt-5 flex items-start gap-3 text-sm text-slate-600">
                <input type="checkbox" name="terms" value="1" required class="mt-1 h-4 w-4 rounded border-slate-300 text-teal-700 focus:ring-teal-500">
                <span>Saya memastikan data pesanan benar dan bersedia datang ke toko untuk konfirmasi serta proses selanjutnya.</span>
            </label>
            <button type="submit" id="confirm-order" disabled class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-3 text-sm font-bold text-white hover:bg-teal-800 disabled:cursor-not-allowed disabled:opacity-50"><i class="bi bi-check2-circle"></i> Konfirmasi dan Buat Pesanan</button>
        </form>
    </div>
</div>

<script>
    const branches = @json($branches);
    const locateButton = document.getElementById('locate-button');
    const locationStatus = document.getElementById('location-status');
    const branchOptions = document.getElementById('branch-options');
    const confirmOrder = document.getElementById('confirm-order');
    const latitudeInput = document.getElementById('buyer-latitude');
    const longitudeInput = document.getElementById('buyer-longitude');
    const oldBranchId = @json(old('branch_id'));

    function calculateDistanceKm(latitude, longitude, branch) {
        const radians = value => value * Math.PI / 180;
        const latitudeDelta = radians(branch.latitude - latitude);
        const longitudeDelta = radians(branch.longitude - longitude);
        const value = Math.sin(latitudeDelta / 2) ** 2
            + Math.cos(radians(latitude)) * Math.cos(radians(branch.latitude)) * Math.sin(longitudeDelta / 2) ** 2;

        return 6371 * 2 * Math.atan2(Math.sqrt(value), Math.sqrt(1 - value));
    }

    function renderBranches(latitude, longitude) {
        branchOptions.innerHTML = '';

        Object.entries(branches).forEach(([id, branch]) => {
            const distance = calculateDistanceKm(latitude, longitude, branch);
            const label = document.createElement('label');
            label.className = 'flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-4 transition has-[:checked]:border-teal-700 has-[:checked]:bg-teal-50';
            label.innerHTML = `<input type="radio" name="branch_id" value="${id}" class="mt-1 h-4 w-4 accent-teal-700" ${id === oldBranchId ? 'checked' : ''} required><span><span class="block font-bold text-slate-900">${branch.name}</span><span class="mt-1 block text-sm text-slate-500">${branch.address}</span><span class="mt-2 block text-sm font-semibold text-teal-700">${distance.toFixed(2)} km · perkiraan garis lurus</span></span>`;
            label.querySelector('input').addEventListener('change', () => {
                confirmOrder.disabled = false;
            });
            branchOptions.appendChild(label);
        });

        confirmOrder.disabled = !branchOptions.querySelector('input:checked');
    }

    locateButton.addEventListener('click', () => {
        if (!navigator.geolocation) {
            locationStatus.textContent = 'Browser ini tidak mendukung akses lokasi.';
            locationStatus.className = 'mt-3 text-sm text-rose-700';
            return;
        }

        locateButton.disabled = true;
        locationStatus.textContent = 'Meminta lokasi perangkat...';
        locationStatus.className = 'mt-3 text-sm text-slate-500';

        navigator.geolocation.getCurrentPosition(position => {
            const { latitude, longitude } = position.coords;
            latitudeInput.value = latitude;
            longitudeInput.value = longitude;
            locationStatus.textContent = 'Lokasi berhasil ditemukan. Pilih salah satu cabang berdasarkan jarak.';
            renderBranches(latitude, longitude);
            locateButton.disabled = false;
        }, error => {
            const message = error.code === error.PERMISSION_DENIED
                ? 'Akses lokasi ditolak. Izinkan lokasi di pengaturan browser untuk melanjutkan.'
                : 'Lokasi tidak dapat ditemukan. Periksa GPS atau koneksi, lalu coba lagi.';
            locationStatus.textContent = message;
            locationStatus.className = 'mt-3 text-sm text-rose-700';
            locateButton.disabled = false;
        }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 60000 });
    });
</script>
@endsection