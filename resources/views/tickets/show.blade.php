<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiket #TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }} - {{ config('app.name', 'Tanikaya') }}</title>
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

        .ticket-code {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-weight: 700;
            font-size: 0.95rem;
            color: #0f172a;
            background: #f1f5f9;
            padding: 4px 10px;
            border-radius: 8px;
            display: inline-block;
        }

        .page-title {
            color: #0f172a;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.3px;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .badge-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-open { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .status-open::before { background: #f59e0b; }

        .status-in_progress { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .status-in_progress::before { background: #0284c7; }

        .status-resolved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .status-resolved::before { background: #16a34a; }

        .status-closed { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .status-closed::before { background: #94a3b8; }

        .ticket-main-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.75rem;
        }

        /* Chat bubbles */
        .chat-bubble-user {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #0f172a;
            border-radius: 16px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .chat-bubble-admin {
            background: #fefce8;
            border: 1px solid #fef08a;
            border-left: 4px solid #eab308;
            border-radius: 16px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 15px rgba(234, 179, 8, 0.08);
        }

        .reply-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 25px rgba(15, 23, 42, 0.04);
            margin-top: 1.5rem;
        }

        .form-control {
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            color: #0f172a;
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            transition: all 0.25s ease;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: #eab308;
            color: #0f172a;
            box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.2);
        }

        .btn-reply-submit {
            background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
            border: 1px solid #eab308;
            color: #000000 !important;
            padding: 0.75rem 1.6rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(234, 179, 8, 0.35);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-reply-submit:hover {
            background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(234, 179, 8, 0.45);
            color: #000000 !important;
        }

        .btn-back-clean {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 0.45rem 1.1rem;
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

        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0b0f19 0%, #1e293b 100%);
            color: #facc15;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>

    @include('partials.navbar')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <!-- Header Bar -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="ticket-code">#TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <span class="badge-status status-{{ $ticket->status }}">
                            {{ strtoupper(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                        <h4 class="page-title mb-0">{{ $ticket->subject }}</h4>
                    </div>
                    <a href="{{ route('tickets.index') }}" class="btn-back-clean">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="background: #dcfce7; color: #15803d; border-radius: 14px;" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Kartu Laporan Awal -->
                <div class="ticket-main-card">
                    <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar-sm">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <span class="fw-bold text-dark d-block">Laporan Anda</span>
                                <small class="text-muted"><i class="bi bi-tag me-1"></i>Kategori: {{ $ticket->category }}</small>
                            </div>
                        </div>
                        <span class="text-muted small">
                            <i class="bi bi-clock me-1"></i>{{ $ticket->created_at->format('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    <div style="white-space: pre-wrap; font-size: 0.95rem; line-height: 1.6; color: #1e293b;" class="mb-3">
                        {{ $ticket->description }}
                    </div>

                    @if($ticket->attachment_path)
                        <div class="pt-3 border-top">
                            <span class="text-muted small fw-bold d-block mb-2"><i class="bi bi-paperclip me-1"></i>Lampiran Foto:</span>
                            <a href="{{ Storage::url($ticket->attachment_path) }}" target="_blank" class="d-inline-block text-decoration-none">
                                <img src="{{ Storage::url($ticket->attachment_path) }}" alt="Lampiran" class="img-thumbnail" style="max-height: 200px; border-radius: 12px;">
                                <div class="small text-muted mt-1"><i class="bi bi-box-arrow-up-right me-1"></i>Klik untuk melihat ukuran penuh</div>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Histori Balasan & Diskusi -->
                @if($ticket->replies->count() > 0)
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="bi bi-chat-dots-fill text-warning me-2"></i>Histori Percakapan ({{ $ticket->replies->count() }})
                        </h5>

                        @foreach($ticket->replies as $reply)
                            @if($reply->user_id === $ticket->user_id)
                                {{-- Bubble User --}}
                                <div class="chat-bubble-user">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar-sm" style="width: 26px; height: 26px; font-size: 0.72rem;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <span class="fw-bold text-dark">Anda</span>
                                        </div>
                                        <small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }} WIB</small>
                                    </div>
                                    <div class="text-dark" style="white-space: pre-wrap; font-size: 0.92rem;">{{ $reply->message }}</div>
                                    @if($reply->attachment_path)
                                        <div class="mt-2 pt-2 border-top">
                                            <a href="{{ Storage::url($reply->attachment_path) }}" target="_blank">
                                                <img src="{{ Storage::url($reply->attachment_path) }}" alt="Lampiran" class="img-thumbnail" style="max-height: 150px; border-radius: 8px;">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                {{-- Bubble Admin --}}
                                <div class="chat-bubble-admin">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="badge bg-dark text-warning p-1 rounded-circle" style="width: 26px; height: 26px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-headset" style="font-size: 0.85rem;"></i>
                                            </div>
                                            <span class="fw-bold text-dark">Tim Support Tanikaya</span>
                                            <span class="badge bg-warning text-dark fw-bold" style="font-size: 0.65rem;">Resmi</span>
                                        </div>
                                        <small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }} WIB</small>
                                    </div>
                                    <div class="text-dark" style="white-space: pre-wrap; font-size: 0.92rem; line-height: 1.5;">{{ $reply->message }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Status Waiting atau Closed -->
                @if(!$hasAdminReplied && $ticket->status === 'open')
                    <div class="p-3 bg-white border rounded-3 text-center mb-4 shadow-sm" style="border-radius: 16px;">
                        <div class="spinner-grow spinner-grow-sm text-warning mb-2" role="status"></div>
                        <p class="small text-muted mb-0 fw-semibold">Tiket Anda telah tercatat. Tim teknis Tanikaya sedang meninjau dan akan segera membalas.</p>
                    </div>
                @elseif($ticket->status === 'closed' || $ticket->status === 'resolved')
                    <div class="alert alert-secondary text-center p-3 mb-4 shadow-sm" style="border-radius: 16px; background: #f8fafc; border: 1px solid #e2e8f0;">
                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                        Tiket ini telah ditandai sebagai <strong>{{ strtoupper($ticket->status) }}</strong>. Laporan telah diselesaikan.
                    </div>
                @else
                    {{-- Form Balasan Pengguna --}}
                    <div class="reply-card">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="bi bi-reply-fill text-warning me-2"></i>Kirim Balasan Tambahan
                        </h5>
                        <form action="{{ route('tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="4" placeholder="Tuliskan pesan balasan atau informasi tambahan Anda di sini..." required></textarea>
                            </div>
                            <div class="row align-items-center g-3">
                                <div class="col-md-7">
                                    <label class="form-label mb-1 small text-muted"><i class="bi bi-paperclip me-1"></i>Lampiran Foto (Opsional, JPG/PNG maks 2MB)</label>
                                    <input type="file" name="attachment" class="form-control form-control-sm" accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="col-md-5 text-md-end">
                                    <button type="submit" class="btn-reply-submit w-100 w-md-auto justify-content-center">
                                        <i class="bi bi-send-fill"></i> Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('partials.pwa-scripts')
</body>
</html>
