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
            background: var(--nature-gradient, #f8fafc);
            color: var(--text-main);
            min-height: 100vh;
        }

        .page-title {
            color: var(--text-main);
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 0.25rem;
        }

        .btn-gradient {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--glow-1);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
        }

        .btn-gradient:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--glow-2);
        }

        /* Ticket Cards */
        .ticket-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .ticket-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            color: inherit;
            box-shadow: 0 10px 25px var(--glow-1);
        }

        .ticket-code {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--text-secondary);
            background: rgba(100, 116, 139, 0.08);
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-block;
        }

        .ticket-subject {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--text-main);
            line-height: 1.35;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.7rem;
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

        .ticket-meta {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 2px dashed var(--glass-border);
            border-radius: 24px;
            margin-top: 2rem;
        }

        .empty-state > i {
            font-size: 3.5rem;
            color: var(--primary);
            opacity: 0.8;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .empty-state h5 {
            color: var(--text-main);
            margin-top: 1.5rem;
            font-weight: 700;
        }

        .empty-state p {
            color: var(--text-secondary);
            max-width: 420px;
            margin: 0.5rem auto 1.5rem auto;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>

    @include('partials.navbar')

    <div class="container py-4">
        <!-- Header Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="page-title mb-0">
                    <i class="bi bi-headset me-2 text-primary"></i>Tiket Bantuan
                </h2>
                <p class="text-secondary mb-0 small">Sampaikan pertanyaan atau kendala perangkat Anda kepada tim dukungan.</p>
            </div>
            <a href="{{ route('tickets.create') }}" class="btn btn-gradient">
                <i class="bi bi-plus-lg me-1"></i> Buat Tiket
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="background: rgba(16, 185, 129, 0.15); color: #15803d; border-radius: 14px;" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($tickets->count() > 0)
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    @foreach($tickets as $ticket)
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="ticket-card">
                            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="ticket-code">#TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <span class="status-badge status-{{ $ticket->status }}">
                                        {{ strtoupper(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </div>
                                <span class="ticket-meta">
                                    <i class="bi bi-clock me-1"></i>{{ $ticket->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>

                            <div class="ticket-subject mb-1">{{ $ticket->subject }}</div>
                            <p class="text-secondary small mb-2 text-truncate" style="max-width: 90%;">{{ $ticket->description }}</p>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: var(--glass-border) !important;">
                                <span class="ticket-meta"><i class="bi bi-tag me-1"></i>{{ $ticket->category }}</span>
                                <span class="small fw-semibold text-primary d-inline-flex align-items-center gap-1">
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
                <div class="empty-state">
                    <i class="bi bi-shield-check"></i>
                    <h5>Aman Terkendali</h5>
                    <p>Anda belum memiliki laporan kendala atau tiket bantuan yang aktif.</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-gradient">
                        <i class="bi bi-plus-lg me-1"></i> Buat Tiket
                    </a>
                </div>
            </div>
        @endif
    </div>

    @include('partials.pwa-scripts')
</body>
</html>
