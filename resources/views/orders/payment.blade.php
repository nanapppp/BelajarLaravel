@extends('layouts.app')

@section('title', 'Bayar via QRIS - Order #'.str_pad($order->id,4,'0',STR_PAD_LEFT))

@section('content')

<style>
    .payment-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 1.75rem 2rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .payment-header::after {
        content:''; position:absolute; top:-50px; right:-50px;
        width:200px; height:200px; border-radius:50%;
        background:rgba(255,255,255,0.06);
    }
    .payment-header h4 { font-weight:700; margin:0; }
    .payment-header p  { margin:0.3rem 0 0; opacity:.85; font-size:.9rem; }

    .back-btn {
        background: rgba(255,255,255,0.2);
        border: 1.5px solid rgba(255,255,255,0.45);
        border-radius: 0.5rem;
        color: white;
        padding: 0.45rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: background 0.2s;
    }
    .back-btn:hover { background:rgba(255,255,255,0.32); color:white; }

    /* QRIS Card */
    .qris-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(102,126,234,0.12);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .qris-header {
        background: linear-gradient(135deg,#667eea,#764ba2);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .qris-header span { color:white; font-weight:700; font-size:1rem; }
    .qris-logo {
        background: white;
        border-radius: 0.4rem;
        padding: 0.25rem 0.6rem;
        font-size: 0.78rem;
        font-weight: 900;
        color: #667eea;
        letter-spacing: 0.05em;
    }

    .qris-body {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    /* QR Frame */
    .qr-frame {
        position: relative;
        width: 240px;
        height: 240px;
        margin: 0 auto 1.5rem;
    }
    .qr-frame .corner {
        position: absolute;
        width: 24px; height: 24px;
        border-color: #667eea;
        border-style: solid;
    }
    .qr-frame .corner.tl { top:0; left:0; border-width:3px 0 0 3px; border-radius:4px 0 0 0; }
    .qr-frame .corner.tr { top:0; right:0; border-width:3px 3px 0 0; border-radius:0 4px 0 0; }
    .qr-frame .corner.bl { bottom:0; left:0; border-width:0 0 3px 3px; border-radius:0 0 0 4px; }
    .qr-frame .corner.br { bottom:0; right:0; border-width:0 3px 3px 0; border-radius:0 0 4px 0; }
    .qr-inner {
        position: absolute;
        inset: 10px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }
    .qr-inner img { width: 200px; height: 200px; object-fit: contain; }
    .qr-inner canvas { width: 200px !important; height: 200px !important; }

    /* Amount */
    .amount-box {
        background: #f8f9fc;
        border-radius: 0.75rem;
        padding: 1rem 2rem;
        margin-bottom: 1.25rem;
        width: 100%;
        max-width: 320px;
    }
    .amount-label { font-size:0.78rem; color:#718096; font-weight:600; text-transform:uppercase; letter-spacing:.05em; }
    .amount-value { font-size:1.6rem; font-weight:800; color:#2d3748; margin-top:3px; }
    .amount-value span { font-size:1rem; color:#718096; font-weight:400; }

    /* Timer */
    .timer-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #fff8f0;
        border: 1px solid #f6ad5550;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        margin-bottom: 1.25rem;
        font-size: 0.875rem;
        color: #c05621;
        font-weight: 600;
    }
    #countdown { font-size:1rem; font-weight:800; font-variant-numeric:tabular-nums; min-width:40px; }

    /* Steps */
    .steps-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .steps-title { font-weight:700; color:#2d3748; margin-bottom:1rem; font-size:.95rem; }
    .step-item {
        display: flex;
        gap: 0.875rem;
        margin-bottom: 0.875rem;
        align-items: flex-start;
    }
    .step-item:last-child { margin-bottom:0; }
    .step-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(135deg,#667eea,#764ba2);
        color: white;
        font-size: 0.78rem;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .step-text { font-size: 0.875rem; color:#4a5568; line-height:1.5; padding-top:3px; }
    .step-text strong { color:#2d3748; }

    /* Order Summary */
    .summary-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .summary-head {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 0.9rem 1.25rem;
        font-weight: 700;
        font-size: 0.88rem;
        color: #4a5568;
    }
    .summary-head i { color:#667eea; }
    .summary-body { padding: 1.25rem; }
    .sum-row {
        display: flex; justify-content: space-between;
        font-size: 0.875rem; padding: 0.4rem 0;
        color:#4a5568; border-bottom:1px dashed #f0f0f0;
    }
    .sum-row:last-child { border:none; }
    .sum-row.total {
        border-top: 2px solid #e2e8f0;
        margin-top:.5rem; padding-top:.75rem;
        font-size:1rem; font-weight:700; color:#2d3748;
    }
    .sum-row.total span:last-child { color:#667eea; }

    /* Confirm Upload */
    .upload-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 1.5rem;
    }
    .upload-zone {
        border: 2px dashed #c3cfe2;
        border-radius: 0.75rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        background: #f8f9fc;
        position: relative;
    }
    .upload-zone:hover { border-color:#667eea; background:#f0f4ff; }
    .upload-zone input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; }
    .upload-zone i { font-size:2rem; color:#a0aec0; margin-bottom:.5rem; }
    .upload-zone p { margin:0; font-size:.875rem; color:#718096; }
    #preview-img { display:none; max-height:180px; border-radius:.5rem; margin-top:1rem; border:1px solid #e2e8f0; }

    .btn-confirm {
        background: linear-gradient(135deg,#667eea,#764ba2);
        color: white; border:none;
        border-radius: 0.6rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 700;
        width: 100%;
        margin-top: 1rem;
        transition: opacity .2s, transform .2s;
        cursor: pointer;
    }
    .btn-confirm:hover { opacity:.88; transform:translateY(-1px); }
    .btn-confirm:disabled { opacity:.5; cursor:not-allowed; transform:none; }

    /* Status Confirmed */
    .confirmed-box {
        background: #f0fff4;
        border: 1.5px solid #68d39180;
        border-radius: .75rem;
        padding: 1.25rem;
        text-align: center;
        display: none;
    }
    .confirmed-box i { font-size:2rem; color:#38a169; }
    .confirmed-box p { margin:.5rem 0 0; color:#22543d; font-weight:600; }
</style>

{{-- Page Header --}}
<div class="payment-header mt-2">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
        <div>
            <h4><i class="fas fa-qrcode me-2"></i>Pembayaran QRIS</h4>
            <p>Order #{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }} &bull; {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <a href="{{ route('orders.show', $order->id) }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>Detail Order
        </a>
    </div>
</div>

<div class="row g-4">

    {{-- LEFT: QR Code --}}
    <div class="col-lg-7">

        {{-- QRIS Card --}}
        <div class="qris-card">
            <div class="qris-header">
                <span><i class="fas fa-qrcode me-2"></i>Scan untuk Membayar</span>
                <div class="qris-logo">QRIS</div>
            </div>
            <div class="qris-body">

                {{-- Timer --}}
                <div class="timer-box">
                    <i class="fas fa-clock"></i>
                    Bayar sebelum: <span id="countdown">14:59</span>
                </div>

                {{-- QR Code --}}
                <div class="qr-frame">
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                    <div class="corner bl"></div>
                    <div class="corner br"></div>
                    <div class="qr-inner">
                        <canvas id="qr-canvas"></canvas>
                    </div>
                </div>

                {{-- Merchant Name --}}
                <div style="font-size:.82rem;color:#718096;margin-bottom:.5rem;">
                    <i class="fas fa-store me-1"></i>Nanap Shop
                </div>

                {{-- Amount --}}
                <div class="amount-box">
                    <div class="amount-label">Total Pembayaran</div>
                    <div class="amount-value">
                        <span>Rp</span> {{ number_format($order->total, 0, ',', '.') }}
                    </div>
                </div>

                <p style="font-size:.8rem;color:#a0aec0;max-width:260px;">
                    Scan QR code menggunakan aplikasi mobile banking atau e-wallet apapun yang mendukung QRIS.
                </p>
            </div>
        </div>

        {{-- Cara Bayar --}}
        <div class="steps-card">
            <div class="steps-title"><i class="fas fa-list-ol me-2" style="color:#667eea"></i>Cara Pembayaran QRIS</div>

            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">Buka aplikasi <strong>mobile banking</strong> atau <strong>e-wallet</strong> kamu (GoPay, OVO, DANA, ShopeePay, BCA, Mandiri, dll.)</div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">Pilih menu <strong>Scan QR</strong> atau <strong>Bayar via QRIS</strong></div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">Arahkan kamera ke QR Code di atas, pastikan nominal sesuai: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></div>
            </div>
            <div class="step-item">
                <div class="step-num">4</div>
                <div class="step-text">Konfirmasi pembayaran dan <strong>upload bukti transfer</strong> di bawah agar pesanan segera diproses</div>
            </div>
        </div>

        {{-- App logos --}}
        <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
            <span style="font-size:.78rem;color:#a0aec0;font-weight:600;">Didukung oleh:</span>
            @foreach(['GoPay','OVO','DANA','ShopeePay','LinkAja','BCA','Mandiri','BRI','BNI'] as $app)
            <span style="font-size:.75rem;background:#f0f4ff;color:#667eea;padding:3px 10px;border-radius:99px;font-weight:600;">{{ $app }}</span>
            @endforeach
        </div>

    </div>

    {{-- RIGHT: Summary + Upload --}}
    <div class="col-lg-5">

        {{-- Order Summary --}}
        <div class="summary-card">
            <div class="summary-head"><i class="fas fa-receipt me-1"></i>Ringkasan Pesanan</div>
            <div class="summary-body">
                
                {{-- PERBAIKAN: Berhasil Menggunakan Relasi 'items' bawaan Model --}}
                @foreach($order->items as $item)
                <div class="sum-row">
                    <span>{{ $item->product->name ?? 'Produk dihapus' }} <span style="color:#a0aec0">x{{ $item->quantity }}</span></span>
                    <span>Rp {{ number_format(($item->product->harga ?? 0) * $item->quantity, 0, ',', '.') }}</span>
                </div>
                @endforeach
                
                <div class="sum-row">
                    <span>Ongkos Kirim</span>
                    <span>{{ ($order->shipping_cost ?? 0) > 0 ? 'Rp '.number_format($order->shipping_cost,0,',','.') : 'Gratis' }}</span>
                </div>
                
                @if(($order->discount ?? 0) > 0)
                <div class="sum-row" style="color:#38a169">
                    <span>Diskon</span>
                    <span>-Rp {{ number_format($order->discount,0,',','.') }}</span>
                </div>
                @endif
                
                <div class="sum-row total">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Upload Bukti --}}
        <div class="upload-card">
            <div class="steps-title" style="margin-bottom:.75rem;">
                <i class="fas fa-upload me-2" style="color:#667eea"></i>Upload Bukti Pembayaran
            </div>
            <p style="font-size:.82rem;color:#718096;margin-bottom:1rem;">
                Upload screenshot/foto bukti pembayaran agar pesanan segera dikonfirmasi.
            </p>

            <form method="POST" action="{{ route('orders.payment.upload', $order->id) }}" enctype="multipart/form-data" id="upload-form">
                @csrf
                <div class="upload-zone" id="upload-zone">
                    <input type="file" name="payment_proof" id="proof-input" accept="image/*" required>
                    <i class="fas fa-image" id="upload-icon"></i>
                    <p id="upload-text">Klik atau drag foto bukti bayar ke sini</p>
                    <p style="font-size:.75rem;color:#a0aec0;margin-top:4px;">JPG, PNG, maks 2MB</p>
                    <img id="preview-img" src="" alt="preview">
                </div>

                @error('payment_proof')
                    <div class="alert alert-danger mt-2 py-2" style="font-size:.82rem;">{{ $message }}</div>
                @enderror

                <div class="confirmed-box" id="confirmed-box">
                    <i class="fas fa-check-circle"></i>
                    <p>Bukti berhasil diupload! Menunggu konfirmasi admin.</p>
                </div>

                <button type="submit" class="btn-confirm" id="btn-confirm" disabled>
                    <i class="fas fa-paper-plane me-2"></i>Kirim Bukti Pembayaran
                </button>
            </form>

            <p style="font-size:.75rem;color:#a0aec0;text-align:center;margin-top:.75rem;">
                <i class="fas fa-shield-alt me-1"></i>Data Anda aman dan terenkripsi
            </p>
        </div>

        {{-- Already paid? --}}
        @if($order->payment_status === 'paid')
        <div class="alert alert-success d-flex align-items-center gap-2 mt-3">
            <i class="fas fa-check-circle fa-lg"></i>
            <div>
                <strong>Pembayaran Dikonfirmasi!</strong><br>
                <span style="font-size:.85rem;">Pesanan Anda sedang diproses oleh admin.</span>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection

@section('scripts')
{{-- QR Code generator --}}
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
// Generate QR Code
const qrisString = "000201010211{{ config('app.qris_merchant_id','NANAP0001') }}5204999953033605405{{ $order->total }}5802ID5909NanapShop6007Jakarta6105121206304{{ str_pad($order->id,4,'0') }}";

new QRCode(document.getElementById("qr-canvas"), {
    text: qrisString,
    width: 200,
    height: 200,
    colorDark: "#2d3748",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.M
});

// Countdown Timer (15 menit)
let seconds = 15 * 60 - 1;
const el = document.getElementById('countdown');
const timer = setInterval(() => {
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    el.textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    if (seconds <= 0) {
        clearInterval(timer);
        el.textContent = '00:00';
        el.closest('.timer-box').style.background = '#fff5f5';
        el.closest('.timer-box').style.color = '#c53030';
        el.closest('.timer-box').querySelector('i').className = 'fas fa-exclamation-circle';
    }
    seconds--;
}, 1000);

// Preview Upload
document.getElementById('proof-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        const img = document.getElementById('preview-img');
        img.src = ev.target.result;
        img.style.display = 'block';
        document.getElementById('upload-icon').style.display = 'none';
        document.getElementById('upload-text').textContent = file.name;
        document.getElementById('btn-confirm').disabled = false;
    };
    reader.readAsDataURL(file);
});
</script>
@endsection