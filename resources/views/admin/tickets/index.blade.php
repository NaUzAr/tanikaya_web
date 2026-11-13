<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Tiket Bantuan - {{ config('app.name', 'Tanikaya') }} Admin</title>
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

        .page-header {
            margin-bottom: 1.75rem;
        }

        .page-title {
            color: #0f172a;
            font-weight: 800;
            font-size: 1.65rem;
            letter-spacing: -0.5px;
        }

        .page-title-icon {
            color: #eab308;
            margin-right: 0.5rem;
        }

        /* Stat Summary Cards */
        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.15rem 1.25rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .stat-card-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .stat-card-value {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1;
            color: #0f172a;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-icon-all {
            background: #f1f5f9;
            color: #334155;
        }

        .stat-icon-open {
            background: #fef3c7;
            color: #d97706;
        }

        .stat-icon-progress {
            background: #e0f2fe;
            color: #0284c7;
        }

        .stat-icon-resolved {
            background: #dcfce7;
            color: #16a34a;
        }

        /* Filter Tabs */
        .filter-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }

        .filter-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.95rem;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            background: #ffffff;
            color: #64748b;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .filter-pill:hover {
            color: #0f172a;
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .filter-pill.active {
            background: #0f172a;
            color: #facc15 !important;
            border-color: #0f172a;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
        }

        .filter-pill .pill-badge {
            font-size: 0.7rem;
            padding: 1px 6px;
            border-radius: 10px;
            background: #f1f5f9;
            color: #475569;
        }

        .filter-pill.active .pill-badge {
            background: rgba(250, 204, 21, 0.2);
            color: #facc15;
        }

        /* Search input */
        .search-box {
            position: relative;
            min-width: 260px;
        }

        .search-box input {
            padding-left: 2.25rem;
            border-radius: 50px;
            border: 1px solid #cbd5e1;
            font-size: 0.85rem;
            background: #ffffff;
        }

        .search-box input:focus {
            border-color: #eab308;
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.2);
        }

        .search-box i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* Ticket Table Card */
        .ticket-table-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .ticket-table {
            margin-bottom: 0;
            width: 100%;
        }

        .ticket-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 0.95rem 1.15rem;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .ticket-table tbody td {
            padding: 1rem 1.15rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 0.875rem;
            background: #ffffff;
        }

        .ticket-table tbody tr:hover td {
            background: #fefce8 !important;
        }

        /* Monospace Ticket ID */
        .ticket-code {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-weight: 700;
            font-size: 0.82rem;
            color: #0f172a;
            background: #f1f5f9;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-block;
        }

        /* Status Badges */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 700;
            font-size: 0.72rem;
            letter-spacing: 0.3px;
            padding: 0.3rem 0.65rem;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .badge-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-open {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .status-open::before { background: #f59e0b; }

        .status-in_progress {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }
        .status-in_progress::before { background: #0284c7; }

        .status-resolved {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .status-resolved::before { background: #16a34a; }

        .status-closed {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .status-closed::before { background: #94a3b8; }

        .badge-category {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
        }

        /* Action button */
        .btn-ticket-open {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 0.35rem 0.85rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-ticket-open:hover {
            background: #facc15;
            border-color: #eab308;
            color: #000000;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(234, 179, 8, 0.3);
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

        /* Empty state */
        .empty-tickets {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-tickets i {
            font-size: 3.5rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>

    @include('partials.navbar')

    <div class="container py-4">
        @include('admin.partials.nav')

        <!-- Header Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 page-header">
            <div>
                <h2 class="page-title mb-1">
                    <i class="bi bi-inboxes-fill page-title-icon"></i>Kelola Tiket Bantuan & Dukungan
                </h2>
                <p class="text-muted mb-0 small">Pusat penanganan kendala teknis, pertanyaan sensor, dan permohonan bantuan pengguna.</p>
            </div>
            <div>
                <form action="{{ route('admin.tickets.index') }}" method="GET" class="d-flex gap-2">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="form-control" placeholder="Cari subjek, pelapor, kategori..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-3 fw-bold">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.tickets.index', request('status') ? ['status' => request('status')] : []) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        <!-- 4 Stat Summary Cards -->
        <div class="row g-3 mb-4">
            {{-- Total Tiket --}}
            <div class="col-6 col-lg-3">
                <a href="{{ route('admin.tickets.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div>
                            <div class="stat-card-label">Total Tiket</div>
                            <div class="stat-card-value">{{ $counts['all'] ?? 0 }}</div>
                        </div>
                        <div class="stat-card-icon stat-icon-all">
                            <i class="bi bi-inbox-fill"></i>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Open / Menunggu Respon --}}
            <div class="col-6 col-lg-3">
                <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="text-decoration-none">
                    <div class="stat-card" style="border-left: 4px solid #f59e0b;">
                        <div>
                            <div class="stat-card-label" style="color: #b45309;">Menunggu Respon</div>
                            <div class="stat-card-value" style="color: #b45309;">{{ $counts['open'] ?? 0 }}</div>
                        </div>
                        <div class="stat-card-icon stat-icon-open">
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                    </div>
                </a>
            </div>

            {{-- In Progress --}}
            <div class="col-6 col-lg-3">
                <a href="{{ route('admin.tickets.index', ['status' => 'in_progress']) }}" class="text-decoration-none">
                    <div class="stat-card" style="border-left: 4px solid #0284c7;">
                        <div>
                            <div class="stat-card-label" style="color: #0369a1;">Sedang Diproses</div>
                            <div class="stat-card-value" style="color: #0369a1;">{{ $counts['in_progress'] ?? 0 }}</div>
                        </div>
                        <div class="stat-card-icon stat-icon-progress">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Resolved --}}
            <div class="col-6 col-lg-3">
                <a href="{{ route('admin.tickets.index', ['status' => 'resolved']) }}" class="text-decoration-none">
                    <div class="stat-card" style="border-left: 4px solid #16a34a;">
                        <div>
                            <div class="stat-card-label" style="color: #15803d;">Telah Selesai</div>
                            <div class="stat-card-value" style="color: #15803d;">{{ $counts['resolved'] ?? 0 }}</div>
                        </div>
                        <div class="stat-card-icon stat-icon-resolved">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-nav">
            <a href="{{ route('admin.tickets.index', request('search') ? ['search' => request('search')] : []) }}" 
               class="filter-pill {{ empty(request('status')) ? 'active' : '' }}">
                <span>Semua Tiket</span>
                <span class="pill-badge">{{ $counts['all'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.tickets.index', array_merge(request()->query(), ['status' => 'open'])) }}" 
               class="filter-pill {{ request('status') === 'open' ? 'active' : '' }}">
                <i class="bi bi-circle-fill text-warning" style="font-size: 0.5rem;"></i>
                <span>Menunggu (Open)</span>
                <span class="pill-badge">{{ $counts['open'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.tickets.index', array_merge(request()->query(), ['status' => 'in_progress'])) }}" 
               class="filter-pill {{ request('status') === 'in_progress' ? 'active' : '' }}">
                <i class="bi bi-circle-fill text-primary" style="font-size: 0.5rem;"></i>
                <span>Diproses</span>
                <span class="pill-badge">{{ $counts['in_progress'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.tickets.index', array_merge(request()->query(), ['status' => 'resolved'])) }}" 
               class="filter-pill {{ request('status') === 'resolved' ? 'active' : '' }}">
                <i class="bi bi-circle-fill text-success" style="font-size: 0.5rem;"></i>
                <span>Selesai (Resolved)</span>
                <span class="pill-badge">{{ $counts['resolved'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.tickets.index', array_merge(request()->query(), ['status' => 'closed'])) }}" 
               class="filter-pill {{ request('status') === 'closed' ? 'active' : '' }}">
                <i class="bi bi-circle-fill text-secondary" style="font-size: 0.5rem;"></i>
                <span>Ditutup</span>
                <span class="pill-badge">{{ $counts['closed'] ?? 0 }}</span>
            </a>
        </div>

        <!-- Table Card -->
        <div class="ticket-table-card">
            <div class="table-responsive">
                <table class="table ticket-table">
                    <thead>
                        <tr>
                            <th>No. Tiket</th>
                            <th>Tanggal Masuk</th>
                            <th>Pelapor</th>
                            <th>Subjek Masalah</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>
                                    <span class="ticket-code">#TKT-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $ticket->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $ticket->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar-sm">
                                            {{ strtoupper(substr($ticket->user->name ?? 'G', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $ticket->user->name ?? 'Guest User' }}</div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">{{ $ticket->user->email ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark mb-1">{{ $ticket->subject }}</div>
                                    <small class="text-muted d-block text-truncate" style="max-width: 280px;">
                                        {{ Str::limit($ticket->description, 60) }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge-category">{{ ucfirst($ticket->category) }}</span>
                                </td>
                                <td>
                                    <span class="badge-status status-{{ $ticket->status }}">
                                        {{ strtoupper(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn-ticket-open">
                                        <i class="bi bi-chat-left-dots-fill"></i>
                                        <span>Buka</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-tickets">
                                        <i class="bi bi-inbox"></i>
                                        <h5 class="fw-bold text-dark mb-1">Tidak Ada Tiket Ditemukan</h5>
                                        <p class="text-muted small mb-0">Belum ada laporan atau tiket bantuan yang sesuai dengan filter ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="d-flex justify-content-center p-3 border-top">
                    {{ $tickets->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
