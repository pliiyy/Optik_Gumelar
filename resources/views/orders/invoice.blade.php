<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Faktur {{ $transactionCode }} | Optik Gumelar</title>
    <style>
        :root {
            color: #17233b;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        * { box-sizing: border-box; }

        body { margin: 0; padding: 24px; background: #eef1f5; }

        .toolbar {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 0 auto 18px;
        }

        .toolbar button,
        .toolbar a {
            border: 0;
            border-radius: 6px;
            padding: 10px 16px;
            color: #fff;
            background: #075b64;
            cursor: pointer;
            font: inherit;
            font-weight: 700;
            text-decoration: none;
        }

        .invoice-sheet {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 1100px;
            min-height: 690px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 8px 28px rgba(23, 35, 59, .12);
        }

        .invoice-copy {
            position: relative;
            min-width: 0;
            padding: 24px;
        }

        .invoice-copy + .invoice-copy {
            border-left: 1px dashed #8993a3;
        }

        .branch-line,
        .invoice-number {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            color: #1472ad;
            font-size: 10px;
            font-weight: 700;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 94px;
            margin: 10px 0 14px;
            border-bottom: 1px solid #d9dee7;
        }

        .brand img {
            width: 98px;
            height: 82px;
            object-fit: contain;
        }

        .brand h1 {
            margin: 0;
            color: #c74358;
            font-size: 24px;
            line-height: 1.1;
        }

        .branch-details {
            margin: 0 0 18px;
            color: #285a91;
            font-size: 9px;
            line-height: 1.6;
            text-align: center;
        }

        .customer-details {
            display: grid;
            grid-template-columns: 52px 1fr;
            gap: 6px 10px;
            margin: 14px 0 18px;
        }

        .label {
            color: #1472ad;
            font-weight: 700;
            text-transform: uppercase;
        }

        .prescription {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            text-align: center;
        }

        .prescription th,
        .prescription td {
            height: 26px;
            border: 1px solid #3484d5;
            padding: 5px;
        }

        .prescription th { color: #1472ad; }

        .lens-diagram {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 20px 0;
        }

        .lens-circle {
            display: grid;
            width: 108px;
            height: 108px;
            place-items: center;
            border: 1px solid #7292b2;
            border-radius: 50%;
            color: #315985;
            font-size: 10px;
        }

        .product-table {
            width: 100%;
            margin: 20px 0 14px;
            border-collapse: collapse;
        }

        .product-table th {
            padding: 7px 4px;
            border-bottom: 1px solid #aab3c0;
            color: #1472ad;
            text-align: left;
        }

        .product-table td {
            padding: 8px 4px;
            border-bottom: 1px solid #e5e8ed;
            vertical-align: top;
        }

        .numeric { text-align: right !important; white-space: nowrap; }

        .total-row td {
            border-top: 1px solid #17233b;
            border-bottom: 0;
            font-size: 14px;
            font-weight: 700;
        }

        .status {
            margin-top: 18px;
            color: #c74358;
            font-size: 13px;
            font-weight: 700;
            text-align: right;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 28px;
            color: #1472ad;
            font-size: 10px;
        }

        .signature span:last-child { color: #17233b; }

        @media (max-width: 760px) {
            body { padding: 10px; }
            .invoice-sheet { grid-template-columns: 1fr; }
            .invoice-copy + .invoice-copy { border-top: 1px dashed #8993a3; border-left: 0; }
        }

        @media print {
            @page { size: A4 landscape; margin: 7mm; }
            body { padding: 0; background: #fff; }
            .toolbar { display: none; }
            .invoice-sheet { max-width: none; min-height: 0; box-shadow: none; }
            .invoice-copy { padding: 12px; }
            .brand img { width: 78px; height: 66px; }
            .brand h1 { font-size: 20px; }
        }
    </style>
</head>
<body>
    <nav class="toolbar" aria-label="Aksi faktur">
        <button type="button" onclick="window.print()">Cetak Faktur</button>
        <a href="{{ route('orders.index') }}">Kembali ke Transaksi</a>
    </nav>

    <main class="invoice-sheet">
        <section class="invoice-copy" aria-label="Salinan resep dan pemeriksaan">
            <div class="branch-line">
                <span>{{ strtoupper($branch['name'] ?? 'OPTIK GUMELAR') }}</span>
                <span>No. {{ $transactionCode }}</span>
            </div>
            <header class="brand">
                <img src="{{ asset('logo.png') }}" alt="Logo Optik Gumelar">
                <h1>OPTIK<br>GUMELAR</h1>
            </header>
            <p class="branch-details">
                {{ $branch['address'] ?? 'Layanan optik dan pemeriksaan mata' }}
                @if(!empty($branch['phone']))<br>HP: {{ $branch['phone'] }}@endif
            </p>
            <div class="customer-details">
                <span class="label">Nama</span><span>{{ $customer->name ?? 'Pelanggan' }}</span>
                <span class="label">Alamat</span><span>________________________________________</span>
                <span class="label">HP</span><span>________________________________________</span>
            </div>
            <table class="prescription">
                <thead><tr><th></th><th>SPH</th><th>CYL</th><th>AX</th><th>PD</th></tr></thead>
                <tbody>
                    <tr><th>OD</th><td></td><td></td><td></td><td></td></tr>
                    <tr><th>OS</th><td></td><td></td><td></td><td></td></tr>
                    <tr><th>ADD</th><td colspan="4"></td></tr>
                </tbody>
            </table>
            <div class="lens-diagram" aria-hidden="true">
                <div class="lens-circle">OD</div>
                <div class="lens-circle">OS</div>
            </div>
            <p><span class="label">Lensa</span> _________________________________</p>
            <p><span class="label">Frame</span> _________________________________</p>
            <div class="signature"><span>Selesai tanggal</span><span>________________ &nbsp; Paraf __________</span></div>
        </section>

        <section class="invoice-copy" aria-label="Salinan faktur transaksi">
            <div class="branch-line">
                <span>{{ strtoupper($branch['name'] ?? 'OPTIK GUMELAR') }}</span>
                <span>No. {{ $transactionCode }}</span>
            </div>
            <header class="brand">
                <img src="{{ asset('logo.png') }}" alt="Logo Optik Gumelar">
                <h1>OPTIK<br>GUMELAR</h1>
            </header>
            <p class="branch-details">
                {{ $branch['address'] ?? 'Layanan optik dan pemeriksaan mata' }}
                @if(!empty($branch['phone']))<br>HP: {{ $branch['phone'] }}@endif
            </p>
            <div class="customer-details">
                <span class="label">Nama</span><span>{{ $customer->name ?? 'Pelanggan' }}</span>
                <span class="label">Email</span><span>{{ $customer->email ?? '-' }}</span>
                <span class="label">Tanggal</span><span>{{ $issuedAt?->format('d-m-Y H:i') ?? now()->format('d-m-Y H:i') }}</span>
            </div>
            <table class="product-table">
                <thead>
                    <tr><th>Produk</th><th class="numeric">Qty</th><th class="numeric">Jumlah</th></tr>
                </thead>
                <tbody>
                    @foreach($orders as $invoiceOrder)
                        <tr>
                            <td>
                                <strong>{{ $invoiceOrder->product_name ?: ($invoiceOrder->lens?->name ?? $invoiceOrder->frame?->name ?? $invoiceOrder->accessory?->name ?? ucfirst($invoiceOrder->product_type)) }}</strong>
                                @if($invoiceOrder->product_category)<br><small>{{ $invoiceOrder->product_category }}</small>@endif
                            </td>
                            <td class="numeric">{{ $invoiceOrder->quantity }}</td>
                            <td class="numeric">Rp {{ number_format($invoiceOrder->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">Jumlah Harga</td>
                        <td class="numeric">Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            @if($orderBranch = $orders->first()?->branch_name)
                <p><span class="label">Cabang</span> {{ $orderBranch }}</p>
            @endif
            <p><span class="label">No. Transaksi</span> {{ $transactionCode }}</p>
            <p><span class="label">Status</span> {{ strtoupper($orders->first()?->status ?? 'pending') }}</p>
            <div class="status">TERIMA KASIH</div>
            <div class="signature"><span>Optik Gumelar</span><span>Pelanggan</span></div>
        </section>
    </main>
</body>
</html>
