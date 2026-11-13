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
            background: var(--nature-gradient, #f8fafc);
            color: var(--text-main);
        }

        .add-card {
            width: 100%;
            max-width: 480px;
            padding: 2.25rem;
            border-radius: 24px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-icon {
            width: 72px;
            height: 72px;
            background: var(--glow-3);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 2.2rem;
            color: var(--primary);
        }

        .card-title {
            color: var(--text-main);
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.35rem;
            font-size: 1.45rem;
        }

        .card-subtitle {
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .form-label {
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        .form-control-token {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 0.85rem 1rem;
            transition: all 0.25s ease;
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-align: center;
            text-transform: uppercase;
        }

        .form-control-token:focus {
            background: #ffffff;
            border-color: var(--primary);
            color: var(--text-main);
            box-shadow: 0 0 0 3px var(--glow-1);
        }

        .form-control-name {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.92rem;
            transition: all 0.25s ease;
        }

        .form-control-name:focus {
            background: #ffffff;
            border-color: var(--primary);
            color: var(--text-main);
            box-shadow: 0 0 0 3px var(--glow-1);
        }

        .alert-danger-custom {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 14px;
            padding: 1rem 1.25rem;
        }

        .alert-info-custom {
            background: var(--glow-3);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 0.85rem 1rem;
        }

        /* Buttons matching the rest of the application */
        .btn-gradient {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            padding: 0.85rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--glow-1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
        }

        .btn-gradient:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--glow-2);
        }

        .btn-action-custom {
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            border-radius: 50px;
            background: #fff;
            border: 1px solid var(--glass-border);
            color: var(--text-secondary);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            width: 100%;
        }

        .btn-action-custom:hover {
            background: var(--glow-1);
            color: var(--primary-dark);
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        /* QR Scanner Buttons */
        .btn-scan {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 0.88rem;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn-scan:hover {
            background: #ffffff;
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-1px);
        }

        .btn-scan.scanning {
            background: #fef2f2;
            border-color: #ef4444;
            color: #dc2626;
        }

        #qrReader {
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid var(--primary);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        #qrReader video {
            border-radius: 14px;
        }

        @media (max-width: 576px) {
            .add-card {
                padding: 1.75rem 1.25rem;
                border-radius: 20px;
            }

            .card-icon {
                width: 60px;
                height: 60px;
                font-size: 1.8rem;
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
            <h4 class="card-title">Tambah Perangkat</h4>
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
                    <label class="form-label"><i class="bi bi-key me-1"></i>Kode Token Perangkat</label>
                    <input type="text" class="form-control form-control-token" name="token" id="tokenInput" value="{{ old('token') }}"
                        placeholder="XXXXXXXXXXXXXXXX" maxlength="16" required autofocus autocomplete="off">
                    <div class="form-text small mt-1 text-center">
                        <i class="bi bi-info-circle me-1"></i>Token 16 karakter tercetak di kartu QR perangkat Tanikaya Anda.
                    </div>
                </div>

                <!-- QR Scanner Section -->
                <div class="mb-4">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-scan flex-grow-1" id="btnScanQR" onclick="toggleScanner()">
                            <i class="bi bi-camera me-1"></i>Scan Kamera
                        </button>
                        <button type="button" class="btn btn-scan flex-grow-1" onclick="document.getElementById('qrImageInput').click()">
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
                    <label class="form-label"><i class="bi bi-tag me-1"></i>Nama Label Perangkat (Opsional)</label>
                    <input type="text" class="form-control form-control-name" name="custom_name"
                        value="{{ old('custom_name') }}" placeholder="Contoh: Mesin Dryer Blok 1, Greenhouse B">
                    <div class="form-text small mt-1">
                        Beri nama alias agar mudah dikenali di dasbor monitoring Anda.
                    </div>
                </div>

                <div class="alert alert-info-custom mb-4">
                    <small><i class="bi bi-shield-check me-1"></i>
                        Perangkat yang ditambahkan akan otomatis tersinkronisasi ke akun Anda dan dapat dipantau secara realtime.
                    </small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-gradient">
                        <i class="bi bi-plus-circle me-1"></i>Hubungkan Perangkat
                    </button>
                    <a href="{{ route('monitoring.index') }}" class="btn btn-action-custom">
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
