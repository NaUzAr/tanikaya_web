<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiket #TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }} - {{ config('app.name', 'Tanikaya') }} Admin</title>
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
        }

        .ticket-detail-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
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

        /* Status Badges */
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
            width: 7px;
            height: 7px;
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

        .desc-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.25rem;
            font-size: 0.95rem;
            line-height: 1.6;
            color: #1e293b;
            white-space: pre-wrap;
        }

        /* Chat bubbles */
        .chat-bubble-user {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #0f172a;
            border-radius: 14px;
            padding: 1.15rem 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .chat-bubble-admin {
            background: #fefce8;
            border: 1px solid #fef08a;
            border-right: 4px solid #eab308;
            border-radius: 14px;
            padding: 1.15rem 1.25rem;
            margin-bottom: 1rem;
            margin-left: 2rem;
            box-shadow: 0 2px 10px rgba(234, 179, 8, 0.08);
        }

        .btn-update-ticket {
            background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
            border: 1px solid #eab308;
            color: #000000;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(234, 179, 8, 0.3);
        }

        .btn-update-ticket:hover {
            background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
            color: #000000;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(234, 179, 8, 0.4);
        }

        .btn-back-ticket {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            font-weight: 600;
            padding: 0.45rem 1.1rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back-ticket:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .user-avatar-md {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0b0f19 0%, #1e293b 100%);
            color: #facc15;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>

    @include('partials.navbar')

    <div class="container py-4">
        @include('admin.partials.nav')

        <!-- Header Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <span class="ticket-code">#TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
                <span class="badge-status status-{{ $ticket->status }}">
                    {{ strtoupper(str_replace('_', ' ', $ticket->status)) }}
                </span>
                <h4 class="fw-bold text-dark mb-0">{{ $ticket->subject }}</h4>
            </div>
            <a href="{{ route('admin.tickets.index') }}" class="btn-back-ticket">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Tiket
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="background: #dcfce7; color: #15803d; border-radius: 14px;" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Column: Laporan Utama & Histori Diskusi -->
            <div class="col-lg-7">
                <!-- Detail Laporan Pengguna -->
                <div class="ticket-detail-card">
                    <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar-md">
                                {{ strtoupper(substr($ticket->user->name ?? 'G', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $ticket->user->name ?? 'Guest User' }}</div>
                                <small class="text-muted">{{ $ticket->user->email ?? 'Tidak ada email' }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="text-muted small d-block">Waktu Lapor:</span>
                            <span class="fw-semibold text-dark small">
                                <i class="bi bi-clock me-1"></i>{{ $ticket->created_at ? $ticket->created_at->format('d M Y, H:i') : '-' }} WIB
                            </span>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-sm-6">
                            <div class="p-2 rounded bg-light border">
                                <small class="text-muted d-block" style="font-size: 0.72rem;">KATEGORI MASALAH</small>
                                <span class="fw-bold text-dark">{{ ucfirst($ticket->category) }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-2 rounded bg-light border">
                                <small class="text-muted d-block" style="font-size: 0.72rem;">STATUS TIKET</small>
                                <span class="fw-bold text-dark">{{ strtoupper(str_replace('_', ' ', $ticket->status)) }}</span>
                            </div>
                        </div>
                    </div>

                    <label class="form-label fw-bold small text-muted text-uppercase mb-2">Deskripsi Keluhan / Pertanyaan:</label>
                    <div class="desc-box mb-3">
                        {!! nl2br(e($ticket->description)) !!}
                    </div>

                    @if($ticket->attachment_path)
                        <div class="mt-3 pt-3 border-top">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-2"><i class="bi bi-paperclip me-1"></i>Lampiran Foto / File:</label>
                            <div>
                                <a href="{{ Storage::url($ticket->attachment_path) }}" target="_blank" class="d-inline-block text-decoration-none">
                                    <img src="{{ Storage::url($ticket->attachment_path) }}" alt="Lampiran" class="img-thumbnail" style="max-height: 220px; border-radius: 12px;">
                                    <div class="small text-muted mt-1"><i class="bi bi-box-arrow-up-right me-1"></i>Klik untuk melihat ukuran penuh</div>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Histori Diskusi -->
                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="bi bi-chat-dots-fill text-warning me-2"></i>Histori Diskusi ({{ $ticket->replies->count() }})
                    </h5>

                    @forelse($ticket->replies as $reply)
                        @if($reply->user_id === $ticket->user_id)
                            {{-- Bubble User --}}
                            <div class="chat-bubble-user">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar-md" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                            {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span class="fw-bold text-dark">{{ $reply->user->name }}</span>
                                        <span class="badge bg-secondary" style="font-size: 0.65rem;">Pelapor</span>
                                    </div>
                                    <small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }} WIB</small>
                                </div>
                                <div class="text-dark" style="white-space: pre-wrap; font-size: 0.92rem;">{{ $reply->message }}</div>
                            </div>
                        @else
                            {{-- Bubble Admin --}}
                            <div class="chat-bubble-admin">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="badge bg-dark text-warning p-2 rounded-circle" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-headset"></i>
                                        </div>
                                        <span class="fw-bold text-dark">Tim Support Tanikaya</span>
                                        <span class="badge bg-warning text-dark fw-bold" style="font-size: 0.65rem;">Admin</span>
                                    </div>
                                    <small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }} WIB</small>
                                </div>
                                <div class="text-dark" style="white-space: pre-wrap; font-size: 0.92rem;">{{ $reply->message }}</div>
                            </div>
                        @endif
                    @empty
                        <div class="p-3 bg-white border rounded text-muted small text-center">
                            Belum ada tanggapan atau pesan balasan pada tiket ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Column: Form Balasan & Update Status -->
            <div class="col-lg-5">
                <div class="ticket-detail-card position-sticky" style="top: 2rem;">
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="bi bi-reply-fill text-warning me-2"></i>Tanggapi & Update Tiket
                    </h5>
                    <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Ubah Status Tiket</label>
                            <select name="status" class="form-select" style="border-radius: 12px; font-weight: 600;">
                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>🟡 Open (Menunggu Respon)</option>
                                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>🔵 In Progress (Sedang Ditangani)</option>
                                <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>🟢 Resolved (Masalah Terselesaikan)</option>
                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>⚪ Closed (Ditutup)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Pesan Balasan ke Pengguna (Opsional)</label>
                            <textarea name="admin_reply" class="form-control" rows="5" placeholder="Tuliskan solusi, instruksi perbaikan, atau jawaban untuk pengguna..." style="border-radius: 12px;"></textarea>
                            <div class="form-text small mt-1">Pesan balasan ini akan langsung tampil di panel tiket pengguna.</div>
                        </div>

                        <button type="submit" class="btn btn-update-ticket w-100">
                            <i class="bi bi-send-fill me-2"></i>Kirim Balasan & Simpan Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
