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
            background: var(--nature-gradient, #f8fafc);
            color: var(--text-main);
            min-height: 100vh;
        }

        .ticket-code {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-secondary);
            background: rgba(100, 116, 139, 0.08);
            padding: 4px 10px;
            border-radius: 8px;
            display: inline-block;
        }

        .page-title {
            color: var(--text-main);
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.3px;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            letter-spacing: 0.3px;
        }

        .status-open { background: var(--glow-1); color: var(--primary); }
        .status-in_progress { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
        .status-resolved { background: rgba(16, 185, 129, 0.12); color: #10b981; }
        .status-closed { background: rgba(100, 116, 139, 0.12); color: #64748b; }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.75rem;
            color: var(--text-main);
        }

        /* Chat bubbles */
        .chat-bubble-user {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-right: 4px solid var(--primary);
            border-radius: 16px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            margin-left: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            color: var(--text-main);
        }

        .chat-bubble-admin {
            background: var(--glow-3);
            border: 1px solid var(--glass-border);
            border-left: 4px solid var(--primary);
            border-radius: 16px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            margin-right: 20px;
            box-shadow: 0 4px 15px var(--glow-1);
            color: var(--text-main);
        }

        .reply-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid var(--glass-border);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            margin-top: 1.5rem;
            color: var(--text-main);
        }

        .form-control {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 0.92rem;
            transition: all 0.25s ease;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: var(--primary);
            color: var(--text-main);
            box-shadow: 0 0 0 3px var(--glow-1);
        }

        .btn-gradient {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            padding: 0.75rem 1.6rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--glow-1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
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
            padding: 0.45rem 1.1rem;
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
            <div class="col-lg-9">
                <!-- Header Bar -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="ticket-code">#TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <span class="status-badge status-{{ $ticket->status }}">
                            {{ strtoupper(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                        <h4 class="page-title mb-0">{{ $ticket->subject }}</h4>
                    </div>
                    <a href="{{ route('tickets.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="background: rgba(16, 185, 129, 0.15); color: #15803d; border-radius: 14px;" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Kartu Laporan Awal -->
                <div class="glass-card">
                    <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom flex-wrap gap-2" style="border-color: var(--glass-border) !important;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle fs-3 text-secondary"></i>
                            <div>
                                <span class="fw-bold d-block" style="color: var(--text-main);">Laporan Anda</span>
                                <small class="text-secondary"><i class="bi bi-tag me-1"></i>Kategori: {{ $ticket->category }}</small>
                            </div>
                        </div>
                        <span class="text-secondary small">
                            <i class="bi bi-clock me-1"></i>{{ $ticket->created_at->format('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    <div style="white-space: pre-wrap; font-size: 0.95rem; line-height: 1.6; color: var(--text-main);" class="mb-3">
                        {{ $ticket->description }}
                    </div>

                    @if($ticket->attachment_path)
                        <div class="pt-3 border-top" style="border-color: var(--glass-border) !important;">
                            <span class="text-secondary small fw-bold d-block mb-2"><i class="bi bi-paperclip me-1"></i>Lampiran Foto:</span>
                            <a href="{{ Storage::url($ticket->attachment_path) }}" target="_blank" class="d-inline-block text-decoration-none">
                                <img src="{{ Storage::url($ticket->attachment_path) }}" alt="Lampiran" class="img-thumbnail" style="max-height: 200px; border-radius: 12px;">
                                <div class="small text-secondary mt-1"><i class="bi bi-box-arrow-up-right me-1"></i>Klik untuk melihat ukuran penuh</div>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Histori Balasan & Diskusi -->
                @if($ticket->replies->count() > 0)
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3" style="color: var(--text-main);">
                            <i class="bi bi-chat-dots me-2 text-primary"></i>Histori Percakapan ({{ $ticket->replies->count() }})
                        </h5>

                        @foreach($ticket->replies as $reply)
                            @if($reply->user_id === $ticket->user_id)
                                {{-- Bubble User --}}
                                <div class="chat-bubble-user">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-person-circle fs-5 text-secondary"></i>
                                            <span class="fw-bold" style="color: var(--text-main);">Anda</span>
                                        </div>
                                        <small class="text-secondary">{{ $reply->created_at->format('d M Y, H:i') }} WIB</small>
                                    </div>
                                    <div style="white-space: pre-wrap; font-size: 0.92rem; color: var(--text-main);">{{ $reply->message }}</div>
                                    @if($reply->attachment_path)
                                        <div class="mt-2 pt-2 border-top" style="border-color: var(--glass-border) !important;">
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
                                            <i class="bi bi-headset fs-5 text-primary"></i>
                                            <span class="fw-bold" style="color: var(--text-main);">Tim Dukungan Tanikaya</span>
                                        </div>
                                        <small class="text-secondary">{{ $reply->created_at->format('d M Y, H:i') }} WIB</small>
                                    </div>
                                    <div style="white-space: pre-wrap; font-size: 0.92rem; line-height: 1.5; color: var(--text-main);">{{ $reply->message }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Status Waiting atau Closed -->
                @if(!$hasAdminReplied && $ticket->status === 'open')
                    <div class="p-3 text-center mb-4 glass-card" style="border-radius: 16px;">
                        <div class="spinner-grow spinner-grow-sm text-primary mb-2" role="status"></div>
                        <p class="small text-secondary mb-0 fw-semibold">Tiket Anda telah tercatat. Tim dukungan Tanikaya sedang meninjau dan akan segera membalas.</p>
                    </div>
                @elseif($ticket->status === 'closed' || $ticket->status === 'resolved')
                    <div class="alert alert-secondary text-center p-3 mb-4" style="border-radius: 16px; background: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-main);">
                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                        Tiket ini telah ditandai sebagai <strong>{{ strtoupper($ticket->status) }}</strong>. Laporan telah diselesaikan.
                    </div>
                @else
                    {{-- Form Balasan Pengguna --}}
                    <div class="reply-card">
                        <h5 class="fw-bold mb-3" style="color: var(--text-main);">
                            <i class="bi bi-reply-fill text-primary me-2"></i>Kirim Balasan
                        </h5>
                        <form action="{{ route('tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <textarea name="message" class="form-control" rows="4" placeholder="Tuliskan pesan balasan atau informasi tambahan Anda di sini..." required></textarea>
                            </div>
                            <div class="row align-items-center g-3">
                                <div class="col-md-7">
                                    <label class="form-label mb-1 small text-secondary"><i class="bi bi-paperclip me-1"></i>Lampiran Foto (Opsional, JPG/PNG maks 2MB)</label>
                                    <input type="file" name="attachment" class="form-control form-control-sm" accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="col-md-5 text-md-end">
                                    <button type="submit" class="btn btn-gradient w-100 w-md-auto justify-content-center">
                                        <i class="bi bi-send me-1"></i> Kirim Pesan
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
