<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Tiket Bantuan - {{ config('app.name', 'Tanikaya') }}</title>
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
            background: var(--nature-gradient, #f8fafc);
            color: var(--text-main);
            min-height: 100vh;
        }

        .page-title {
            color: var(--text-main);
            font-weight: 800;
            font-size: 1.75rem;
            margin-bottom: 0.25rem;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            color: var(--text-main);
        }

        .form-label {
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        .form-control, .form-select {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.92rem;
            transition: all 0.25s ease;
        }

        .form-control:focus, .form-select:focus {
            background: #ffffff;
            border-color: var(--primary);
            color: var(--text-main);
            box-shadow: 0 0 0 3px var(--glow-1);
        }

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

        .btn-back {
            color: var(--text-secondary);
            border: 1px solid var(--glass-border);
            border-radius: 50px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            text-decoration: none;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.88rem;
        }

        .btn-back:hover {
            background: var(--glow-1);
            color: var(--primary-dark);
            border-color: var(--primary);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>

    @include('partials.navbar')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h2 class="page-title mb-1">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>Buat Tiket Laporan
                        </h2>
                        <p class="text-secondary small mb-0">Sampaikan kendala teknis atau pertanyaan Anda kepada tim dukungan.</p>
                    </div>
                    <a href="{{ route('tickets.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" style="background: #fef2f2; color: #b91c1c; border-radius: 14px;" role="alert">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Periksa inputan berikut:</div>
                        <ul class="mb-0 ps-3 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="glass-card">
                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Subjek -->
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-chat-text me-1"></i>Subjek Laporan</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required placeholder="Contoh: Sensor Suhu Tidak Mengirim Data, Pompa Irigasi Offline">
                            <div class="form-text small text-secondary">Ringkasan singkat kendala yang dialami.</div>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-grid me-1"></i>Kategori Kendala</label>
                            <select name="category" class="form-select" id="categorySelect" required onchange="checkCategory()">
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih Kategori Kendala</option>
                                <option value="Perangkat Hardware / IoT" {{ old('category') == 'Perangkat Hardware / IoT' ? 'selected' : '' }}>Perangkat Hardware / Sensor IoT</option>
                                <option value="Aplikasi Web" {{ old('category') == 'Aplikasi Web' ? 'selected' : '' }}>Aplikasi Web & Monitoring</option>
                                <option value="Aplikasi Mobile" {{ old('category') == 'Aplikasi Mobile' ? 'selected' : '' }}>Aplikasi Mobile Android / PWA</option>
                                <option value="Integrasi MQTT / Otomasi" {{ old('category') == 'Integrasi MQTT / Otomasi' ? 'selected' : '' }}>Integrasi MQTT & Aturan Otomasi</option>
                                <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya (Ketik Manual)</option>
                            </select>
                            <input type="text" name="category_manual" id="categoryManual" class="form-control mt-2" placeholder="Tuliskan kategori lainnya..." style="display: none;" disabled>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-card-text me-1"></i>Detail Masalah / Kronologi</label>
                            <textarea name="description" class="form-control" rows="5" required placeholder="Jelaskan secara detail masalah yang dihadapi, waktu kejadian, dan nomor/tipe perangkat jika ada...">{{ old('description') }}</textarea>
                        </div>

                        <!-- Lampiran -->
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-paperclip me-1"></i>Lampiran Foto / Screenshot (Opsional)</label>
                            <input type="file" name="attachment" class="form-control" accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text small text-secondary">Maksimal 2MB. Format file: JPG, JPEG, PNG.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient">
                                <i class="bi bi-send me-1"></i>Kirim Laporan Tiket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('partials.pwa-scripts')
    <script>
        function checkCategory() {
            var select = document.getElementById("categorySelect");
            var manualInput = document.getElementById("categoryManual");
            if (select.value === "Lainnya") {
                manualInput.style.display = "block";
                manualInput.disabled = false;
                select.name = "";
                manualInput.name = "category";
            } else {
                manualInput.style.display = "none";
                manualInput.disabled = true;
                manualInput.name = "category_manual";
                select.name = "category";
            }
        }
        // Run on page load if old value was Lainnya
        document.addEventListener('DOMContentLoaded', function() {
            checkCategory();
        });
    </script>
</body>
</html>
