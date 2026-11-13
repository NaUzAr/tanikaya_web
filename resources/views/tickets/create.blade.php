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
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
        }

        .form-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 2.25rem;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.04);
        }

        .page-title {
            color: #0f172a;
            font-weight: 800;
            font-size: 1.6rem;
            letter-spacing: -0.4px;
        }

        .page-title-icon {
            color: #eab308;
            margin-right: 0.5rem;
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

        .form-control, .form-select {
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            color: #0f172a;
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            transition: all 0.25s ease;
        }

        .form-control:focus, .form-select:focus {
            background: #ffffff;
            border-color: #eab308;
            color: #0f172a;
            box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.2);
        }

        .btn-submit-ticket {
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

        .btn-submit-ticket:hover {
            background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(234, 179, 8, 0.45);
            color: #000000 !important;
        }

        .btn-back-clean {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.88rem;
        }

        .btn-back-clean:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
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
                            <i class="bi bi-pencil-square page-title-icon"></i>Buat Tiket Laporan Baru
                        </h2>
                        <p class="text-muted small mb-0">Sampaikan kendala teknis atau pertanyaan Anda kepada Tim Tanikaya.</p>
                    </div>
                    <a href="{{ route('tickets.index') }}" class="btn-back-clean">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
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

                <div class="form-card">
                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Subjek -->
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-chat-text-fill me-1"></i>Subjek Laporan</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required placeholder="Contoh: Sensor Suhu Tidak Mengirim Data, Pompa Irigasi Offline">
                            <div class="form-text small text-muted">Ringkasan singkat kendala yang dialami.</div>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-grid-fill me-1"></i>Kategori Kendala</label>
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
                            <div class="form-text small text-muted">Maksimal 2MB. Format file: JPG, JPEG, PNG.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-submit-ticket">
                                <i class="bi bi-send-fill me-2"></i>Kirim Laporan Tiket
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
