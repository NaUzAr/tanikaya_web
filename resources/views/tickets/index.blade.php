<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiket Bantuan - {{ config('app.name', 'Tanikaya') }}</title>
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

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            color: #0f172a;
            font-weight: 800;
            font-size: 1.75rem;
            letter-spacing: -0.5px;
        }

        .page-title-icon {
            color: #eab308;
            margin-right: 0.5rem;
        }

        .btn-create-ticket {
            background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
            border: 1px solid #eab308;
            color: #000000 !important;
            padding: 0.65rem 1.4rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(234, 179, 8, 0.35);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-create-ticket:hover {
            background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(234, 179, 8, 0.45);
            color: #000000 !important;
        }

        /* Stat cards */
        .stat-mini-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
        }

        .stat-mini-card:hover {
            transform: translateY(-2px);
            border-color: #cbd5e1;
        }

        .stat-mini-val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        .stat-mini-lbl {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 0.2rem;
        }

        /* Ticket Cards */
        .ticket-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: all 0.25s ease;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
            position: relative;
        }

        .ticket-card:hover {
            border-color: #facc15;
            transform: translateY(-2px);
            color: inherit;
            box-shadow: 0 8px 24px rgba(234, 179, 8, 0.15);
            background: #ffffff;
        }

        .ticket-code {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-weight: 700;
            font-size: 0.8rem;
            color: #0f172a;
            background: #f1f5f9;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-block;
        }

        .ticket-subject {
            font-weight: 800;
            font-size: 1.1rem;
            color: #0f172a;
            line-height: 1.3;
            letter-spacing: -0.2px;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 700;
            font-size: 0.72rem;
            letter-spacing: 0.3px;
            padding: 0.3rem 0.7rem;
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

        .badge-category {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .empty-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 3.5rem 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        }

        .empty-card-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: #fef9c3;
            color: #ca8a04;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 1.25rem;
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>

    @include('partials.navbar')

    <div class="container py-4">
        <!-- Header Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 page-header">
            <div>
                <h2 class="page-title mb-1">
                    <i class="bi bi-headset page-title-icon"></i>Tiket Bantuan & Dukungan
                </h2>
                <p class="text-muted mb-0 small">Sampaikan keluhan, pertanyaan, atau kendala perangkat dan aplikasi Anda kepada Tim Tanikaya.</p>
            </div>
            <a href="{{ route('tickets.create') }}" class="btn-create-ticket">
                <i class="bi bi-plus-lg"></i> Buat Tiket Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="background: #dcfce7; color: #15803d; border-radius: 14px;" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- 3 Quick Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-4">
                <div class="stat-mini-card">
                    <div>
                        <div class="stat-mini-lbl">Total Tiket</div>
                        <div class="stat-mini-val">{{ $counts['all'] ?? $tickets->total() }}</div>
                    </div>
                    <i class="bi bi-inboxes text-muted fs-3"></i>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-mini-card" style="border-left: 4px solid #f59e0b;">
                    <div>
                        <div class="stat-mini-lbl" style="color: #b45309;">Sedang Aktif</div>
                        <div class="stat-mini-val" style="color: #b45309;">{{ $counts['open'] ?? 0 }}</div>
                    </div>
                    <i class="bi bi-clock-history text-warning fs-3"></i>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-mini-card" style="border-left: 4px solid #16a34a;">
                    <div>
                        <div class="stat-mini-lbl" style="color: #15803d;">Telah Selesai</div>
                        <div class="stat-mini-val" style="color: #15803d;">{{ $counts['resolved'] ?? 0 }}</div>
                    </div>
                    <i class="bi bi-check-circle text-success fs-3"></i>
                </div>
            </div>
        </div>

        @if($tickets->count() > 0)
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    @foreach($tickets as $ticket)
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="ticket-card">
                            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="ticket-code">#TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <span class="badge-status status-{{ $ticket->status }}">
                                        {{ strtoupper(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </div>
                                <span class="text-muted small">
                                    <i class="bi bi-clock me-1"></i>{{ $ticket->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>

                            <div class="ticket-subject mb-2">{{ $ticket->subject }}</div>
                            <p class="text-muted small mb-3 text-truncate" style="max-width: 90%;">{{ $ticket->description }}</p>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <span class="badge-category"><i class="bi bi-tag me-1"></i>{{ $ticket->category }}</span>
                                <span class="text-primary small fw-semibold d-inline-flex align-items-center gap-1" style="color: #ca8a04 !important;">
                                    Lihat Diskusi <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach

                    @if($tickets->hasPages())
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $tickets->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="col-lg-8 mx-auto">
                <div class="empty-card">
                    <div class="empty-card-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Semua Aman Terkendali</h4>
                    <p class="text-muted small mb-4">Anda belum memiliki laporan kendala atau tiket bantuan yang aktif.</p>
                    <a href="{{ route('tickets.create') }}" class="btn-create-ticket">
                        <i class="bi bi-pencil-square me-1"></i> Buat Laporan Tiket Baru
                    </a>
                </div>
            </div>
        @endif
    </div>

    @include('partials.pwa-scripts')
</body>
</html>
