@extends('layouts.app')

@section('title', 'Pesanan Saya - Nanap Shop')

@section('content')

<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .page-header::after {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
    }
    .page-header::before {
        content: '';
        position: absolute;
        bottom: -60px; left: -30px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .page-header h2 { font-weight: 700; font-size: 1.75rem; margin: 0; }
    .page-header p  { margin: 0.4rem 0 0; opacity: 0.85; }

    /* Stat Cards */
    .stat-card {
        border: none;
        border-radius: 0.75rem;
        padding: 1.25rem 1.5rem;
        color: white;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
    .stat-card .icon {
        width: 50px; height: 50px; border-radius: 0.6rem;
        background: rgba(255,255,255,0.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; flex-shrink: 0;
    }
    .stat-card .num  { font-size: 1.6rem; font-weight: 700; line-height: 1; }
    .stat-card .lbl  { font-size: 0.82rem; opacity: 0.88; margin-top: 2px; }
    .bg-grad-all    { background: linear-gradient(135deg,#667eea,#764ba2); }
    .bg-grad-pending{ background: linear-gradient(135deg,#f6ad55,#e07b39); }
    .bg-grad-proc   { background: linear-gradient(135deg,#4299e1,#2b6cb0); }
    .bg-grad-done   { background: linear-gradient(135deg,#68d391,#38a169); }
    .bg-grad-cancel { background: linear-gradient(135deg,#f56565,#c53030); }

    /* Order Card */
    .order-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        margin-bottom: 1.25rem;
        transition: box-shadow 0.25s, transform 0.25s;
        overflow: hidden;
    }
    .order-card:hover {
        box-shadow: 0 8px 25px rgba(102,126,234,0.18);
        transform: translateY(-2px);
    }
    .order-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .order-id { font-weight: 700; font-size: 0.95rem; color: #2d3748; }
    .order-date { font-size: 0.8rem; color: #718096; }
    .order-body { padding: 1.25rem; }

    .product-thumb {
        width: 54px; height: 54px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }
    .product-thumb-placeholder {
        width: 54px; height: 54px;
        border-radius: 0.5rem;
        background: linear-gradient(135deg,#667eea22,#764ba222);
        display: flex; align-items: center; justify-content: center;
        color: #667eea; font-size: 1.2rem; flex-shrink: 0;
    }
    .item-name  { font-weight: 600; font-size: 0.92rem; color: #2d3748; }
    .item-quantity   { font-size: 0.8rem; color: #718096; }
    .item-price { font-weight: 600; color: #667eea; white-space: nowrap; }

    .order-footer {
        padding: 0.85rem 1.25rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .total-label { font-size: 0.85rem; color: #718096; }
    .total-value { font-size: 1.15rem; font-weight: 700; color: #2d3748; }

    /* Status Badge */
    .status-badge {
        padding: 0.35rem 0.85rem;
        border-radius: 0.5rem;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .status-pending  { background: #fff8f0; color: #c05621; border: 1px solid #f6ad5580; }
    .status-process  { background: #ebf8ff; color: #2b6cb0; border: 1px solid #4299e180; }
    .status-shipped  { background: #f0fff4; color: #2f855a; border: 1px solid #68d39180; }
    .status-done     { background: #f0fff4; color: #22543d; border: 1px solid #38a16980; }
    .status-cancelled{ background: #fff5f5; color: #c53030; border: 1px solid #f5656580; }

    /* Filter Bar */
    .filter-bar {
        background: white;
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }
    .filter-bar .form-select, .filter-bar .form-control {
        border-radius: 0.5rem;
        border: 1.5px solid #e2e8f0;
        font-size: 0.875rem;
        max-width: 200px;
        transition: border-color 0.2s;
    }
    .filter-bar .form-select:focus, .filter-bar .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #a0aec0;
    }
    .empty-state i { font-size: 3.5rem; margin-bottom: 1rem; }
    .empty-state h5 { color: #4a5568; font-weight: 600; }

    /* Action Buttons */
    .btn-detail {
        background: linear-gradient(135deg,#667eea,#764ba2);
        color: white; border: none;
        border-radius: 0.5rem;
        padding: 0.4rem 1rem;
        font-size: 0.82rem;
        font-weight: 600;
        transition: opacity 0.2s, transform 0.2s;
    }
    .btn-detail:hover { opacity: 0.88; transform: translateY(-1px); color: white; }
    .btn-cancel {
        background: white;
        color: #e53e3e;
        border: 1.5px solid #e53e3e;
        border-radius: 0.5rem;
        padding: 0.4rem 1rem;
        font-size: 0.82rem;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-cancel:hover { background: #e53e3e; color: white; }

    /* More items pill */
    .more-items {
        font-size: 0.78rem;
        color: #667eea;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        background: #f0f4ff;
        border-radius: 99px;
        display: inline-block;
        margin-top: 0.5rem;
    }
</style>

{{-- Page Header --}}
<div class="page-header mt-2">
    <h2><i class="fas fa-receipt me-2"></i>Pesanan Saya</h2>
    <p>Pantau dan kelola semua pesanan Anda di sini</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card bg-grad-all">
            <div class="icon"><i class="fas fa-shopping-bag"></i></div>
            <div>
                <div class="num">{{ $orders->count() }}</div>
                <div class="lbl">Semua Order</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-grad-pending">
            <div class="icon"><i class="fas fa-clock"></i></div>
            <div>
                <div class="num">{{ $orders->where('status','pending')->count() }}</div>
                <div class="lbl">Menunggu</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-grad-proc">
            <div class="icon"><i class="fas fa-truck"></i></div>
            <div>
                <div class="num">{{ $orders->whereIn('status',['processing','shipped'])->count() }}</div>
                <div class="lbl">Diproses</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-grad-done">
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="num">{{ $orders->where('status','completed')->count() }}</div>
                <div class="lbl">Selesai</div>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="filter-bar">
    <i class="fas fa-filter text-secondary"></i>
    <span class="fw-600 text-secondary" style="font-size:.875rem; font-weight:600;">Filter:</span>
    <form method="GET" action="{{ route('orders.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending"    {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="processing" {{ request('status')=='processing'?'selected':'' }}>Diproses</option>
            <option value="shipped"    {{ request('status')=='shipped'?'selected':'' }}>Dikirim</option>
            <option value="completed"  {{ request('status')=='completed'?'selected':'' }}>Selesai</option>
            <option value="cancelled"  {{ request('status')=='cancelled'?'selected':'' }}>Dibatalkan</option>
        </select>
        <input type="month" name="month" class="form-control" value="{{ request('month') }}" onchange="this.form.submit()">
        @if(request()->anyFilled(['status','month']))
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-times me-1"></i>Reset
            </a>
        @endif
    </form>
</div>

{{-- Order List --}}
@forelse($orders as $order)

@php
    $statusMap = [
        'pending'    => ['label'=>'Menunggu',  'class'=>'status-pending',   'icon'=>'fa-clock'],
        'processing' => ['label'=>'Diproses',   'class'=>'status-process',   'icon'=>'fa-cog fa-spin'],
        'shipped'    => ['label'=>'Dikirim',    'class'=>'status-shipped',   'icon'=>'fa-truck'],
        'completed'  => ['label'=>'Selesai',    'class'=>'status-done',      'icon'=>'fa-check-circle'],
        'cancelled'  => ['label'=>'Dibatalkan', 'class'=>'status-cancelled', 'icon'=>'fa-times-circle'],
    ];
    $s = $statusMap[$order->status] ?? ['label'=>$order->status,'class'=>'','icon'=>'fa-circle'];
    $previewItems = $order->items->take(3);
    $remaining    = $order->items->count() - 3;
@endphp

<div class="order-card">
    {{-- Header --}}
    <div class="order-card-header">
        <div>
            <div class="order-id"><i class="fas fa-hashtag me-1" style="color:#667eea"></i>Order-{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</div>
            <div class="order-date"><i class="fas fa-calendar-alt me-1"></i>{{ $order->created_at->format('d M Y, H:i') }}</div>
        </div>
        <span class="status-badge {{ $s['class'] }}">
            <i class="fas {{ $s['icon'] }}"></i>{{ $s['label'] }}
        </span>
    </div>

    {{-- Items Preview --}}
    <div class="order-body">
        @foreach($previewItems as $item)
        <div class="d-flex align-items-center gap-3 mb-2">
            @if($item->product->image ?? null)
                <img src="{{ asset('storage/'.$item->product->image) }}" class="product-thumb" alt="{{ $item->product->name }}">
            @else
                <div class="product-thumb-placeholder"><i class="fas fa-box"></i></div>
            @endif
            <div class="flex-grow-1">
                <div class="item-name">{{ $item->product->name ?? 'Produk dihapus' }}</div>
                <div class="item-quantity">{{ $item->quantity }} barang &times; <span class="item-price">Rp {{ number_format($item->price,0,',','.') }}</span></div>
            </div>
            <div class="item-price">Rp {{ number_format($item->quantity * $item->price,0,',','.') }}</div>
        </div>
        @endforeach

        @if($remaining > 0)
            <div><span class="more-items"><i class="fas fa-plus me-1"></i>{{ $remaining }} produk lainnya</span></div>
        @endif
    </div>

    {{-- Footer --}}
    <div class="order-footer">
        <div>
            <div class="total-label">Total Pembayaran</div>
            <div class="total-value">Rp {{ number_format($order->total_price,0,',','.') }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('orders.show', $order->id) }}" class="btn-detail">
                <i class="fas fa-eye me-1"></i>Detail
            </a>
            @if($order->status === 'pending')
                <form method="POST" action="{{ route('orders.cancel', $order->id) }}"
                      onsubmit="return confirm('Batalkan pesanan ini?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-cancel">
                        <i class="fas fa-times me-1"></i>Batalkan
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@empty
<div class="card empty-state">
    <i class="fas fa-shopping-bag"></i>
    <h5 class="mt-2">Belum ada pesanan</h5>
    <p class="mb-3" style="font-size:.88rem;">Yuk mulai belanja dan temukan produk favoritmu!</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">
        <i class="fas fa-store me-2"></i>Mulai Belanja
    </a>
</div>
@endforelse

{{-- Pagination --}}
@if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $orders->links() }}
</div>
@endif

@endsection