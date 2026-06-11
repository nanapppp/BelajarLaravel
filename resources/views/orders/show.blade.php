@extends('layouts.app')

@section('title', 'Detail Pesanan #'.str_pad($order->id,4,'0',STR_PAD_LEFT).' - Nanap Shop')

@section('content')

<style>
    /* Header */
    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 1.75rem 2rem;
        color: white;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    .detail-header::after {
        content:''; position:absolute; top:-50px; right:-50px;
        width:200px; height:200px; border-radius:50%;
        background:rgba(255,255,255,0.06);
    }
    .detail-header h4 { font-weight:700; margin:0; }
    .detail-header p  { margin:0.25rem 0 0; opacity:.85; font-size:.9rem; }

    .back-btn {
        background: rgba(255,255,255,0.2);
        border: 1.5px solid rgba(255,255,255,0.45);
        border-radius: 0.5rem;
        color: white;
        padding: 0.5rem 1.1rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .back-btn:hover { background: rgba(255,255,255,0.32); color: white; }

    /* Status Badge */
    .status-badge-lg {
        padding: 0.5rem 1.2rem;
        border-radius: 0.6rem;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .status-pending  { background:#fff8f0; color:#c05621; border:1.5px solid #f6ad5580; }
    .status-process  { background:#ebf8ff; color:#2b6cb0; border:1.5px solid #4299e180; }
    .status-shipped  { background:#e6f0ff; color:#3c4fa8; border:1.5px solid #667eea80; }
    .status-done     { background:#f0fff4; color:#22543d; border:1.5px solid #38a16980; }
    .status-cancelled{ background:#fff5f5; color:#c53030; border:1.5px solid #f5656580; }

    /* Timeline */
    .timeline-section {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        margin-bottom: 1.5rem;
    }
    .timeline { position: relative; padding-left: 1.75rem; }
    .timeline::before {
        content:''; position:absolute; left:7px; top:4px; bottom:4px;
        width:2px; background:#e2e8f0; border-radius:2px;
    }
    .tl-item {
        position: relative;
        padding-bottom: 1.5rem;
        padding-left: 1rem;
    }
    .tl-item:last-child { padding-bottom: 0; }
    .tl-dot {
        position: absolute; left: -1.75rem; top: 3px;
        width: 16px; height: 16px; border-radius: 50%;
        background: #e2e8f0; border: 2px solid white;
        box-shadow: 0 0 0 2px #e2e8f0;
        display: flex; align-items: center; justify-content: center;
    }
    .tl-dot.active { background: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.25); }
    .tl-dot.done   { background: #68d391; box-shadow: 0 0 0 3px rgba(104,211,145,0.25); }
    .tl-dot.cancel { background: #f56565; box-shadow: 0 0 0 3px rgba(245,101,101,0.25); }
    .tl-title { font-weight: 600; font-size: 0.88rem; color: #2d3748; }
    .tl-time  { font-size: 0.78rem; color: #a0aec0; margin-top: 2px; }

    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .info-card-header {
        padding: 0.9rem 1.25rem;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        font-weight: 700;
        font-size: 0.88rem;
        color: #4a5568;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .info-card-header i { color: #667eea; }
    .info-card-body { padding: 1.25rem; }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.55rem 0;
        border-bottom: 1px dashed #f0f0f0;
        font-size: 0.875rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-key   { color: #718096; flex-shrink: 0; min-width: 120px; }
    .info-value { color: #2d3748; font-weight: 600; text-align: right; }

    /* Product Table */
    .product-table { width: 100%; border-collapse: collapse; }
    .product-table thead th {
        background: #f8f9fa;
        padding: 0.75rem 1rem;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #718096;
        border-bottom: 1px solid #e9ecef;
    }
    .product-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .product-table tbody tr:last-child td { border-bottom: none; }
    .product-table tbody tr:hover td { background: #f8f9ff; }

    .product-thumb {
        width: 52px; height: 52px; object-fit: cover;
        border-radius: 0.5rem; border: 1px solid #e2e8f0;
    }
    .product-thumb-ph {
        width: 52px; height: 52px; border-radius: 0.5rem;
        background: linear-gradient(135deg,#667eea22,#764ba222);
        display: flex; align-items: center; justify-content: center;
        color: #667eea; font-size: 1.2rem;
    }
    .product-name { font-weight: 600; color: #2d3748; font-size: 0.9rem; }
    .product-cat  { font-size: 0.78rem; color: #718096; margin-top: 2px; }
    .price-text   { font-weight: 600; color: #667eea; }

    /* Summary */
    .summary-box {
        background: #f8f9fc;
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-top: 0.5rem;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        padding: 0.4rem 0;
        color: #4a5568;
    }
    .summary-row.total {
        border-top: 2px solid #e2e8f0;
        margin-top: 0.5rem;
        padding-top: 0.75rem;
        font-size: 1.05rem;
        font-weight: 700;
        color: #2d3748;
    }
    .summary-row.total span:last-child { color: #667eea; }

    /* Section Title */
    .section-label {
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #a0aec0;
        margin-bottom: 0.75rem;
    }

    /* Action Buttons */
    .btn-cancel-order {
        background: white;
        color: #e53e3e;
        border: 1.5px solid #e53e3e;
        border-radius: 0.5rem;
        padding: 0.55rem 1.25rem;
        font-size: 0.88rem;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-cancel-order:hover { background: #e53e3e; color: white; }
    .btn-reorder {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.55rem 1.25rem;
        font-size: 0.88rem;
        font-weight: 600;
        transition: opacity 0.2s, transform 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .btn-reorder:hover { opacity: 0.88; transform: translateY(-1px); color: white; }
</style>

@php
    $statusMap = [
        'pending'    => ['label'=>'Menunggu Pembayaran', 'class'=>'status-pending',   'icon'=>'fa-clock'],
        'processing' => ['label'=>'Sedang Diproses',     'class'=>'status-process',   'icon'=>'fa-cog fa-spin'],
        'shipped'    => ['label'=>'Sedang Dikirim',      'class'=>'status-shipped',   'icon'=>'fa-truck'],
        'completed'  => ['label'=>'Pesanan Selesai',     'class'=>'status-done',      'icon'=>'fa-check-circle'],
        'cancelled'  => ['label'=>'Dibatalkan',          'class'=>'status-cancelled', 'icon'=>'fa-times-circle'],
    ];
    $s = $statusMap[$order->status] ?? ['label'=>$order->status,'class'=>'','icon'=>'fa-circle'];

    $steps = [
        ['key'=>'pending',    'icon'=>'fa-clock',        'label'=>'Order Diterima',   'desc'=>'Menunggu konfirmasi'],
        ['key'=>'processing', 'icon'=>'fa-cog',           'label'=>'Diproses',         'desc'=>'Sedang dipersiapkan'],
        ['key'=>'shipped',    'icon'=>'fa-truck',         'label'=>'Dikirim',          'desc'=>'Dalam perjalanan'],
        ['key'=>'completed',  'icon'=>'fa-check-circle',  'label'=>'Selesai',          'desc'=>'Pesanan diterima'],
    ];
    $stepOrder = ['pending'=>0,'processing'=>1,'shipped'=>2,'completed'=>3,'cancelled'=>-1];
    $curStep   = $stepOrder[$order->status] ?? 0;
@endphp

{{-- Header --}}
<div class="detail-header mt-2">
    <div>
        <h4><i class="fas fa-receipt me-2"></i>Order #{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</h4>
        <p>Dipesan pada {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <span class="status-badge-lg {{ $s['class'] }}">
            <i class="fas {{ $s['icon'] }}"></i>{{ $s['label'] }}
        </span>
        <a href="{{ route('orders.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    {{-- Left Column --}}
    <div class="col-lg-8">

        {{-- Timeline --}}
        @if($order->status !== 'cancelled')
        <div class="timeline-section">
            <div class="section-label"><i class="fas fa-route me-1"></i>Status Pengiriman</div>
            <div class="timeline">
                @foreach($steps as $i => $step)
                @php
                    $isDone   = $i <  $curStep;
                    $isActive = $i == $curStep;
                    $dotClass = $isDone ? 'done' : ($isActive ? 'active' : '');
                @endphp
                <div class="tl-item">
                    <div class="tl-dot {{ $dotClass }}">
                        @if($isDone)
                            <i class="fas fa-check" style="font-size:8px;color:white;"></i>
                        @endif
                    </div>
                    <div class="tl-title" style="{{ (!$isDone && !$isActive) ? 'color:#a0aec0' : '' }}">
                        {{ $step['label'] }}
                    </div>
                    <div class="tl-time">
                        @if($isDone || $isActive)
                            {{ $isActive ? 'Saat ini' : 'Selesai' }}
                        @else
                            Menunggu
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Product Items --}}
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-box"></i> Produk Dipesan
                <span class="ms-auto text-secondary" style="font-weight:400;">{{ $order->items->count() }} item</span>
            </div>
            <div class="info-card-body p-0">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->product->image ?? null)
                                        <img src="{{ asset('storage/'.$item->product->image) }}" class="product-thumb" alt="">
                                    @else
                                        <div class="product-thumb-ph"><i class="fas fa-box"></i></div>
                                    @endif
                                    <div>
                                        <div class="product-name">{{ $item->product->name ?? 'Produk dihapus' }}</div>
                                        <div class="product-cat">{{ $item->product->category->name ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-secondary" style="font-size:.82rem;">{{ $item->quantity }}</span>
                            </td>
                            <td class="text-end price-text">Rp {{ number_format($item->price,0,',','.') }}</td>
                            <td class="text-end">
                                <strong>Rp {{ number_format($item->quantity * $item->price,0,',','.') }}</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Summary --}}
                <div class="p-3 pt-0">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Subtotal ({{ $order->items->sum('quantity') }} item)</span>
                            <span>Rp {{ number_format($order->items->sum(fn($i)=>$i->price*$i->quantity),0,',','.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Ongkos Kirim</span>
                            <span>{{ $order->shipping_cost > 0 ? 'Rp '.number_format($order->shipping_cost,0,',','.') : 'Gratis' }}</span>
                        </div>
                        @if(($order->discount ?? 0) > 0)
                        <div class="summary-row" style="color:#38a169">
                            <span>Diskon</span>
                            <span>- Rp {{ number_format($order->discount,0,',','.') }}</span>
                        </div>
                        @endif
                        <div class="summary-row total">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($order->total_price,0,',','.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Right Column --}}
    <div class="col-lg-4">

        {{-- Order Info --}}
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-info-circle"></i> Info Pesanan
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-key">No. Order</span>
                    <span class="info-value">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Tanggal</span>
                    <span class="info-value">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Metode Bayar</span>
                    <span class="info-value">{{ $order->payment_method ?? 'Transfer Bank' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Status Bayar</span>
                    <span class="info-value">
                        @if($order->payment_status === 'paid')
                            <span class="badge" style="background:#f0fff4;color:#22543d;font-size:.78rem;">
                                <i class="fas fa-check-circle me-1"></i>Lunas
                            </span>
                        @else
                            <span class="badge" style="background:#fff8f0;color:#c05621;font-size:.78rem;">
                                <i class="fas fa-clock me-1"></i>Menunggu
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-map-marker-alt"></i> Alamat Pengiriman
            </div>
            <div class="info-card-body">
                <div class="mb-2">
                    <div style="font-weight:700;font-size:.9rem;color:#2d3748;">{{ $order->recipient_name ?? auth()->user()->name }}</div>
                    <div style="font-size:.82rem;color:#718096;">{{ $order->recipient_phone ?? '-' }}</div>
                </div>
                <div style="font-size:.875rem;color:#4a5568;line-height:1.6;">
                    {{ $order->shipping_address ?? 'Alamat tidak tersedia' }}
                </div>
            </div>
        </div>

        {{-- Notes --}}
        @if($order->notes)
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-sticky-note"></i> Catatan
            </div>
            <div class="info-card-body">
                <p style="font-size:.875rem;color:#4a5568;margin:0;font-style:italic;">"{{ $order->notes }}"</p>
            </div>
        </div>
        @endif

        {{-- Actions --}}
        <div class="d-flex flex-column gap-2">
            @if($order->status === 'pending' && $order->payment_status !== 'paid')
                <a href="{{ route('orders.payment', $order->id) }}" class="btn-reorder w-100 justify-content-center">
                    <i class="fas fa-qrcode me-1"></i>Bayar via QRIS
                </a>
            @endif

            @if($order->status === 'pending')
                <form method="POST" action="{{ route('orders.cancel', $order->id) }}"
                      onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-cancel-order w-100">
                        <i class="fas fa-times me-1"></i>Batalkan Pesanan
                    </button>
                </form>
            @endif

            @if($order->status === 'completed')
                <a href="{{ route('products.index') }}" class="btn-reorder w-100 justify-content-center">
                    <i class="fas fa-redo"></i>Pesan Lagi
                </a>
            @endif

            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                <i class="fas fa-list me-1"></i>Semua Pesanan
            </a>
        </div>

    </div>
</div>

@endsection