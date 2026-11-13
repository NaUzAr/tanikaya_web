<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Perangkat - {{ config('app.name', 'Tanikaya') }}</title>
    @include('partials.pwa-head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @include('partials.theme')

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: #f8fafc;
            color: #0f172a;
        }

        .add-card {
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.06);
            transition: all 0.3s ease;
        }

        .card-icon {
            width: 76px;
            height: 76px;
            background: linear-gradient(135deg, #0b0f19 0%, #1e293b 100%);
            border: 2.5px solid #facc15;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.25rem;
            color: #facc15;
        }

        .card-title {
            color: #0f172a;
            font-weight: 800;
            text-align: center;
            margin-bottom: 0.5rem;
            font-size: 1.45rem;
            letter-spacing: -0.3px;
        }

        .card-subtitle {
            color: #64748b;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.88rem;
            line-height: 1.5;
        }

        .form-label {
            color: #0f172a;
            font-weight: 700;
            font-size: 0.88rem;
            margin-bottom: 0.4rem;
        }

        .form-label i {
            color: #ca8a04;
        }

        .form-control-token {
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            color: #0f172a;
            border-radius: 14px;
            padding: 0.9rem 1rem;
            transition: all 0.25s ease;
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-align: center;
            text-transform: uppercase;
        }

        .form-control-token:focus {
            background: #ffffff;
            border-color: #eab308;
            color: #0f172a;
            box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.2);
        }

        .form-control-name {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: #0f172a;
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            transition: all 0.25s ease;
        }

        .form-control-name:focus {
            background: #ffffff;
            border-color: #eab308;
            color: #0f172a;
            box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.2);
        }

        .alert-danger-custom {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 14px;
            padding: 1rem 1.25rem;
        }

        .alert-info-custom {
            background: #fefce8;
            border: 1px solid #fef08a;
            color: #854d0e;
            border-radius: 12px;
            padding: 0.85rem 1rem;
        }

        .btn-gradient-submit {
            background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
            border: 1px solid #eab308;
            color: #000000 !important;
            padding: 0.85rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(234, 179, 8, 0.35);
        }

        .btn-gradient-submit:hover {
            background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
            color: #000000 !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(234, 179, 8, 0.45);
        }

        .btn-back-clean {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            text-align: center;
        }

        .btn-back-clean:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        /* ========= QR Scanner Buttons ========= */
        .btn-outline-scan {
            background: #fefce8;
            border: 2px dashed #ca8a04;
            color: #854d0e;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.25s ease;
        }

        .btn-outline-scan:hover {
            background: #fef08a;
            border-color: #eab308;
            color: #713f12;
            transform: translateY(-1px);
        }

        .btn-outline-scan.scanning {
            background: #fef2f2;
            border-color: #ef4444;
            border-style: solid;
            color: #dc2626;
        }

        .btn-outline-scan-img {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            color: #475569;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.25s ease;
        }

        .btn-outline-scan-img:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #0f172a;
            transform: translateY(-1px);
        }

        #qrReader {
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid #eab308;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        #qrReader video {
            border-radius: 14px;
        }

        /* ========= Mobile Responsive ========= */
        @media (max-width: 576px) {
            .add-card {
                padding: 1.75rem 1.25rem;
                border-radius: 20px;
            }

            .card-icon {
                width: 64px;
                height: 64px;
                font-size: 1.85rem;
                border-radius: 16px;
                margin-bottom: 1rem;
            }

            .card-title {
                font-size: 1.25rem;
            }

            .form-control-token {
                font-size: 1.05rem;
                letter-spacing: 2px;
            }
        }
    </style>
</head>

<body>
    <div class="bg-animation"></div>

    @include('partials.navbar')

    <div class="container py-4 my-2 d-flex justify-content-center">
        <div class="add-card">
            <!-- Icon -->
            <div class="card-icon">
                <i class="bi bi-qr-code-scan"></i>
            </div>
            <h4 class="card-title">Tambah Perangkat IoT</h4>
            <p class="card-subtitle">Scan kartu QR perangkat atau masukkan 16 karakter token Tanikaya Anda.</p>

            @if ($errors->any())
                <div class="alert alert-danger-custom mb-4">
                    <ul class="mb-0 small ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('monitoring.store') }}" method="POST">
                @csrf

                <!-- Token Input -->
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-key-fill me-1"></i>Kode Token Perangkat</label>
                    <input type="text" class="form-control form-control-token" name="token" id="tokenInput" value="{{ old('token') }}"
                        placeholder="XXXXXXXXXXXXXXXX" maxlength="16" required autofocus autocomplete="off">
                    <div class="form-text small text-muted mt-1 text-center">
                        <i class="bi bi-info-circle me-1"></i>Token 16 karakter tercetak di kartu QR perangkat Tanikaya Anda.
                    </div>
                </div>

                <!-- QR Scanner Section -->
                <div class="mb-4">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-scan flex-grow-1" id="btnScanQR" onclick="toggleScanner()">
                            <i class="bi bi-camera me-1"></i>Scan Kamera
                        </button>
                        <button type="button" class="btn btn-outline-scan-img flex-grow-1" onclick="document.getElementById('qrImageInput').click()">
                            <i class="bi bi-image me-1"></i>Pilih Foto QR
                        </button>
                        <input type="file" id="qrImageInput" accept="image/*" style="display:none" onchange="scanFromImage(this)">
                    </div>
                    <div id="qrScannerContainer" style="display: none;">
                        <div id="qrReader" style="width: 100%; margin-top: 0.85rem;"></div>
                    </div>
                    <div id="qrScanStatus" class="text-center mt-2" style="display: none;">
                        <span class="badge bg-success bg-opacity-15 text-success py-2 px-3 rounded-pill fw-bold">
                            <i class="bi bi-check-circle-fill me-1"></i>Token berhasil terdeteksi!
                        </span>
                    </div>
                    <div id="qrScanError" class="text-center mt-2" style="display: none;">
                        <span class="badge bg-danger bg-opacity-15 text-danger py-2 px-3 rounded-pill fw-bold">
                            <i class="bi bi-x-circle-fill me-1"></i>QR Code tidak ditemukan di gambar.
                        </span>
                    </div>
                </div>

                <!-- Custom Name -->
                <div class="mb-4">
                    <label class="form-label"><i class="bi bi-tag-fill me-1"></i>Nama Label Perangkat (Opsional)</label>
                    <input type="text" class="form-control form-control-name" name="custom_name"
                        value="{{ old('custom_name') }}" placeholder="Contoh: Mesin Dryer Blok 1, Greenhouse B">
                    <div class="form-text small text-muted mt-1">
                        Beri nama alias agar mudah dikenali di dasbor monitoring Anda.
                    </div>
                </div>

                <div class="alert alert-info-custom mb-4">
                    <small><i class="bi bi-shield-check me-1"></i>
                        Perangkat yang ditambahkan akan otomatis tersinkronisasi ke akun Anda dan dapat dipantau secara realtime.
                    </small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-gradient-submit">
                        <i class="bi bi-plus-circle-fill me-2"></i>Hubungkan Perangkat
                    </button>
                    <a href="{{ route('monitoring.index') }}" class="btn btn-back-clean">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dasbor
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- html5-qrcode CDN -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let html5QrCode = null;
        let scannerRunning = false;

        function toggleScanner() {
            if (scannerRunning) {
                stopScanner();
            } else {
                startScanner();
            }
        }

        function startScanner() {
            const container = document.getElementById('qrScannerContainer');
            const btn = document.getElementById('btnScanQR');
            const statusEl = document.getElementById('qrScanStatus');
            container.style.display = 'block';
            statusEl.style.display = 'none';
            btn.innerHTML = '<i class="bi bi-x-circle me-1"></i>Tutup Kamera';
            btn.classList.add('scanning');

            html5QrCode = new Html5Qrcode("qrReader");

            const config = {
                fps: 10,
                qrbox: function(viewfinderWidth, viewfinderHeight) {
                    let minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                    let qrboxSize = Math.floor(minEdge * 0.75);
                    return { width: qrboxSize, height: qrboxSize };
                },
                aspectRatio: 1.0,
            };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanFailure
            ).catch(err => {
                html5QrCode.start(
                    {},
                    config,
                    onScanSuccess,
                    onScanFailure
                ).catch(err2 => {
                    console.error('Camera start error:', err2);
                    alert('Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.');
                    stopScanner();
                });
            });

            scannerRunning = true;
        }

        function stopScanner() {
            if (html5QrCode && scannerRunning) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    document.getElementById('qrScannerContainer').style.display = 'none';
                    const btn = document.getElementById('btnScanQR');
                    btn.innerHTML = '<i class="bi bi-camera me-1"></i>Scan Kamera';
                    btn.classList.remove('scanning');
                    scannerRunning = false;
                }).catch(err => {
                    console.error('Stop error:', err);
                    document.getElementById('qrScannerContainer').style.display = 'none';
                    scannerRunning = false;
                });
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            let token = decodedText.trim();
            // Handle URL with token query param or raw token
            if (token.includes('token=')) {
                try {
                    const url = new URL(token);
                    token = url.searchParams.get('token') || token;
                } catch(e) {}
            }
            // Strip non-alphanumeric
            token = token.replace(/[^a-zA-Z0-9]/g, '');
            if (token.length > 16) token = token.substring(0, 16);

            document.getElementById('tokenInput').value = token;
            document.getElementById('qrScanStatus').style.display = 'block';
            document.getElementById('qrScanError').style.display = 'none';

            stopScanner();
        }

        function onScanFailure(error) {
            // silent scan frame failures
        }

        function scanFromImage(input) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];
            const statusEl = document.getElementById('qrScanStatus');
            const errorEl = document.getElementById('qrScanError');
            statusEl.style.display = 'none';
            errorEl.style.display = 'none';

            const scanner = new Html5Qrcode("qrReader");
            scanner.scanFile(file, true)
                .then(decodedText => {
                    let token = decodedText.trim();
                    if (token.includes('token=')) {
                        try {
                            const url = new URL(token);
                            token = url.searchParams.get('token') || token;
                        } catch(e) {}
                    }
                    token = token.replace(/[^a-zA-Z0-9]/g, '');
                    if (token.length > 16) token = token.substring(0, 16);

                    document.getElementById('tokenInput').value = token;
                    statusEl.style.display = 'block';
                    errorEl.style.display = 'none';
                    scanner.clear();
                })
                .catch(err => {
                    console.error('Scan file error:', err);
                    errorEl.style.display = 'block';
                    scanner.clear();
                });
            input.value = '';
        }
    </script>
</body>

</html>
