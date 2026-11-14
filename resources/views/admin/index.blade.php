<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Devices - {{ config('app.name', 'Tanikaya') }}</title>
    @include('partials.pwa-head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @include('partials.theme')

    <style>
        /* Page Title */
        .page-title {
            color: #0f172a;
            font-weight: 800;
        }

        .page-title i {
            color: #0e5f8a;
        }

        /* Table Styles */
        .table-dark-custom {
            background: #f1f5f9 !important;
        }

        .table-dark-custom th {
            color: #334155 !important;
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 2px solid #e2e8f0 !important;
            padding: 0.9rem 1rem;
        }

        .table tbody tr {
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .table tbody td {
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
            padding: 0.9rem 1rem;
            vertical-align: middle;
        }

        /* Badges */
        .badge-type {
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
            color: #fff;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
        }

        .badge-output {
            background: #fbbf24;
            color: #1f2937;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            margin: 2px;
            font-size: 0.75rem;
            display: inline-block;
        }

        .badge-sensor {
            background: rgba(14, 165, 233, 0.12);
            color: #0284c7;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            margin: 2px;
            font-size: 0.75rem;
            display: inline-block;
        }

        .badge-token {
            background: rgba(100, 116, 139, 0.15);
            color: #475569;
            font-family: monospace;
            padding: 0.35rem 0.6rem;
            border-radius: 8px;
        }

        /* Action Buttons */
        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-action-edit {
            background: rgba(250, 204, 21, 0.2);
            color: #facc15;
        }

        .btn-action-edit:hover {
            background: rgba(250, 204, 21, 0.4);
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-action-qr {
            background: rgba(14, 165, 233, 0.2);
            color: #0ea5e9;
        }

        .btn-action-qr:hover {
            background: rgba(14, 165, 233, 0.4);
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-action-copy {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .btn-action-copy:hover {
            background: rgba(16, 185, 129, 0.4);
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-action-delete {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .btn-action-delete:hover {
            background: rgba(239, 68, 68, 0.4);
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-action-clear {
            background: rgba(249, 115, 22, 0.2);
            color: #ea580c;
        }

        .btn-action-clear:hover {
            background: rgba(249, 115, 22, 0.4);
            color: #fff;
            transform: translateY(-2px);
        }

        /* QR Modal & QRIS Card */
        .qr-modal .modal-content {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        }

        .qris-card {
            background: #ffffff;
            width: 100%;
            max-width: 340px;
            margin: 0 auto;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .qris-header {
            background: linear-gradient(135deg, #0b0f19 0%, #1e293b 100%);
            padding: 1.15rem 1.25rem 1rem;
            position: relative;
            border-bottom: 3.5px solid #facc15;
            text-align: left;
        }

        .qris-logo-row {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
        }

        .qris-header-logo {
            width: 44px;
            height: 44px;
            object-fit: contain;
            background: #000000;
            border-radius: 12px;
            padding: 2px;
            border: 2px solid #facc15;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            flex-shrink: 0;
        }

        .qris-header-text {
            text-align: left;
            flex-grow: 1;
            overflow: hidden;
        }

        .qris-brand-title {
            font-size: 1.25rem;
            font-weight: 900;
            letter-spacing: 1.5px;
            line-height: 1.1;
            color: #facc15;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .qris-sub {
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.2px;
            color: #cbd5e1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .qris-sub-badge {
            background: rgba(250, 204, 21, 0.2);
            color: #facc15;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 4px;
            border: 1px solid rgba(250, 204, 21, 0.4);
            letter-spacing: 0.5px;
            flex-shrink: 0;
            line-height: 1.2;
        }

        .qris-sub-highlight {
            color: #facc15;
            font-weight: 700;
        }

        .qris-device-section {
            padding: 1.15rem 1rem 0.4rem;
            text-align: center;
        }

        .qris-device-name {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.3px;
            line-height: 1.2;
            word-break: break-word;
        }

        .qris-qr-wrapper {
            padding: 0.5rem 1.25rem 0.85rem;
            display: flex;
            justify-content: center;
        }

        .qris-qr-border {
            background: #ffffff;
            padding: 10px;
            border-radius: 22px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            position: relative;
            display: inline-block;
        }

        /* Modern viewfinder corners */
        .qris-qr-border .corner {
            position: absolute;
            width: 14px;
            height: 14px;
            border-color: #facc15;
            pointer-events: none;
        }
        .qris-qr-border .corner-tl {
            top: 4px; left: 4px;
            border-top: 3px solid #facc15;
            border-left: 3px solid #facc15;
            border-top-left-radius: 6px;
        }
        .qris-qr-border .corner-tr {
            top: 4px; right: 4px;
            border-top: 3px solid #facc15;
            border-right: 3px solid #facc15;
            border-top-right-radius: 6px;
        }
        .qris-qr-border .corner-bl {
            bottom: 4px; left: 4px;
            border-bottom: 3px solid #facc15;
            border-left: 3px solid #facc15;
            border-bottom-left-radius: 6px;
        }
        .qris-qr-border .corner-br {
            bottom: 4px; right: 4px;
            border-bottom: 3px solid #facc15;
            border-right: 3px solid #facc15;
            border-bottom-right-radius: 6px;
        }

        .qris-token-box {
            margin: 0.25rem 1.25rem 0.85rem;
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 12px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .qris-token-box:hover {
            background: #fefce8;
            border-color: #facc15;
        }

        .qris-token-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .qris-token-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .qris-token {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 1.05rem;
            letter-spacing: 1.5px;
            color: #0f172a;
            font-weight: 700;
        }

        .qris-token-copy-icon {
            font-size: 0.9rem;
            color: #94a3b8;
            transition: color 0.2s ease;
        }

        .qris-token-box:hover .qris-token-copy-icon {
            color: #ca8a04;
        }

        .qris-footer {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            text-align: center;
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 500;
            border-top: 1px solid #f1f5f9;
        }

        .qr-modal .modal-body {
            padding: 2rem;
            text-align: center;
        }

        .qr-display {
            display: inline-block;
            padding: 1rem;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }

        .qr-token-text {
            font-family: monospace;
            font-size: 1.1rem;
            letter-spacing: 2px;
            color: #475569;
            background: rgba(100, 116, 139, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: inline-block;
            margin-top: 1rem;
        }

        .btn-download-qr {
            background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
            border: 1px solid #eab308;
            color: #000000;
            padding: 0.7rem 1.75rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(234, 179, 8, 0.35);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-download-qr:hover {
            background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(234, 179, 8, 0.45);
            color: #000000;
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.3);
        }

        .empty-state p {
            color: rgba(255, 255, 255, 0.6);
            margin-top: 1rem;
        }

        .empty-state a {
            color: var(--primary-light);
        }

        /* ========= Mobile Responsive Optimizations (HP) ========= */
        @media (max-width: 768px) {
            .container {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
                padding-bottom: 3.5rem !important;
                max-width: 100vw;
                overflow-x: hidden;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                gap: 0.75rem;
                align-items: stretch !important;
            }

            .glass-card {
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                border-radius: 0 !important;
                overflow: hidden !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .table-responsive {
                overflow: hidden !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .table {
                display: block;
                width: 100% !important;
                max-width: 100% !important;
            }

            .table tbody {
                display: block;
                width: 100% !important;
            }

            /* Table → Card Layout */
            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 1rem;
                margin-bottom: 1rem;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.55rem 0;
                border: none;
                border-bottom: 1px dashed #f1f5f9;
                font-size: 0.85rem;
                overflow: hidden;
                word-break: break-word;
            }

            .table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                font-size: 0.8rem;
                color: #64748b;
                margin-right: 0.75rem;
                flex-shrink: 0;
            }

            .table tbody td[data-label="#"] {
                display: none !important;
            }

            .table tbody td[data-label="Device"] {
                display: block !important;
                padding-top: 0 !important;
                padding-bottom: 0.75rem !important;
                border-bottom: 1px solid #e2e8f0 !important;
            }

            .table tbody td[data-label="Device"] a {
                display: block;
                width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
                word-break: break-all;
            }

            .table tbody td[data-label="Device"]::before {
                display: none !important;
            }

            .table tbody td:last-child {
                justify-content: flex-end;
                padding-top: 0.75rem !important;
                padding-bottom: 0 !important;
                border-bottom: none !important;
                margin-top: 0.25rem;
                gap: 8px;
            }

            .table tbody td:last-child::before {
                display: none !important;
            }

            /* Hide less important on small screens */
            .table tbody td.d-mobile-none {
                display: none !important;
            }

            .btn-action {
                width: 38px;
                height: 38px;
            }

            .admin-search-wrap {
                width: 100% !important;
                flex-direction: column !important;
            }
            .admin-search-wrap form,
            .admin-search-wrap .input-group {
                max-width: 100% !important;
                width: 100% !important;
            }
            .admin-search-wrap .btn-gradient {
                width: 100% !important;
                justify-content: center;
            }
        }

        @media (max-width: 400px) {
            .container.py-5 {
                padding: 1rem 0.5rem !important;
            }
        }
    </style>
</head>

<body>
    <div class="bg-animation"></div>

    <!-- Navbar -->
    @include('partials.navbar')

    <div class="container py-4">
        {{-- Admin Navigation Tabs (6 Fitur Lengkap) --}}
        @include('admin.partials.nav')

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="page-title mb-1">
                    <i class="bi bi-cpu-fill me-2 text-primary"></i>Manajemen Perangkat IoT
                </h2>
                <p class="text-muted mb-0 small">Kelola seluruh perangkat IoT, tipe mesin, sensor, dan kredensial MQTT.</p>
            </div>
            <div class="d-flex flex-wrap gap-2 align-items-center admin-search-wrap">
                <!-- Search Form -->
                <form action="{{ route('admin.devices.index') }}" method="GET" class="d-flex mb-0">
                    <div class="input-group shadow-sm" style="max-width: 260px; background: #ffffff; border-radius: 10px; overflow: hidden; border: 1px solid #cbd5e1;">
                        <input type="text" name="search" class="form-control border-0 shadow-none text-dark" placeholder="Cari nama device..." value="{{ request('search') }}" style="background: transparent; font-size: 0.88rem;">
                        <button type="submit" class="btn btn-light border-0 shadow-none" style="color: #0ea5e9;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <a href="{{ route('admin.device.create') }}" class="btn btn-gradient d-inline-flex align-items-center" style="border-radius: 10px; padding: 0.55rem 1.1rem; font-weight: 600;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Device
                </a>
            </div>
        </div>



        @if(session('success'))
            <div class="alert alert-success-custom mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="glass-card">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-dark-custom">
                        <tr>
                            <th>#</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('sort') == 'name' && request('order') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none" style="color: var(--primary-light);">
                                    Nama Device
                                    @if(request('sort') == 'name')
                                        <i class="bi bi-sort-alpha-{{ request('order') == 'asc' ? 'down' : 'up-alt' }}"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up opacity-50" style="font-size: 0.8em;"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Tipe</th>
                            <th>Sensors</th>
                            <th>Outputs</th>
                            <th>MQTT Topic</th>

                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => request('sort', 'created_at') == 'created_at' && request('order', 'desc') == 'desc' ? 'asc' : 'desc']) }}" class="text-decoration-none" style="color: var(--primary-light);">
                                    Dibuat
                                    @if(request('sort', 'created_at') == 'created_at')
                                        <i class="bi bi-sort-numeric-{{ request('order', 'desc') == 'asc' ? 'up-alt' : 'down' }}"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up opacity-50" style="font-size: 0.8em;"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $device)
                            <tr>
                                <td data-label="#" class="fw-semibold">{{ $loop->iteration }}</td>
                                <td data-label="Device">
                                    <a href="{{ route('admin.device.monitoring', $device->id) }}"
                                        class="text-decoration-none">
                                        <div class="fw-bold d-flex align-items-center" style="color: #1f2937;">
                                            {{ $device->name }}
                                            @if($device->isOnline())
                                                <span class="d-inline-block rounded-circle bg-success ms-2" style="width: 8px; height: 8px; box-shadow: 0 0 6px rgba(25, 135, 84, 0.5);" title="Online"></span>
                                            @else
                                                <span class="d-inline-block rounded-circle bg-secondary ms-2" style="width: 8px; height: 8px;" title="Offline"></span>
                                            @endif
                                        </div>
                                        <small style="color: #64748b;">{{ $device->table_name }}</small>
                                    </a>
                                </td>
                                <td data-label="Tipe">
                                    <span style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center;">
                                        <i class="bi {{ $device->type === 'aws' ? 'bi-cloud-sun' : 'bi-flower1' }} me-1"></i>
                                        {{ strtoupper($device->type ?? 'N/A') }}
                                    </span>
                                </td>
                                <td data-label="Sensors">
                                    <div class="d-flex flex-wrap gap-1 justify-content-end align-items-center" style="max-width: 70%;">
                                        @if($device->sensors->count() > 0)
                                            @foreach($device->sensors->take(4) as $sensor)
                                                <span class="badge-sensor" title="{{ $sensor->sensor_label }}">
                                                    {{ $sensor->sensor_name }}
                                                </span>
                                            @endforeach
                                            @if($device->sensors->count() > 4)
                                                <span class="badge-sensor">+{{ $device->sensors->count() - 4 }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="Outputs">
                                    <div class="d-flex flex-wrap gap-1 justify-content-end align-items-center" style="max-width: 70%;">
                                        @if($device->outputs->count() > 0)
                                            @foreach($device->outputs->take(3) as $output)
                                                <span class="badge-output" title="{{ $output->output_label }}">
                                                    <i class="bi bi-toggle-on me-1"></i>{{ $output->output_name }}
                                                </span>
                                            @endforeach
                                            @if($device->outputs->count() > 3)
                                                <span class="badge-output">+{{ $device->outputs->count() - 3 }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="MQTT" class="d-mobile-none">
                                    <code class="text-info">{{ $device->mqtt_topic }}</code>
                                </td>

                                <td data-label="Dibuat" class="d-mobile-none">
                                    <small style="color: #64748b;">{{ $device->created_at ? $device->created_at->format('d M Y, H:i') : '-' }}</small>
                                </td>
                                <td data-label="Aksi" class="text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <button type="button" class="btn-action btn-action-qr" title="QR Code"
                                            onclick="showQrModal('{{ $device->token }}', '{{ $device->name }}')">
                                            <i class="bi bi-qr-code"></i>
                                        </button>
                                        <div class="dropdown d-inline">
                                            <button class="btn-action btn-action-copy" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Copy Data">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 12px; font-size: 0.9rem;">
                                                <li>
                                                    <a class="dropdown-item py-2 d-flex align-items-center" href="#" onclick="copyToClipboard(event, '{{ $device->token }}', this)">
                                                        <i class="bi bi-key me-2 text-secondary"></i> Copy Token
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item py-2 d-flex align-items-center" href="#" onclick="copyToClipboard(event, '{{ $device->mqtt_topic }}', this)">
                                                        <i class="bi bi-broadcast me-2 text-secondary"></i> Copy MQTT Topic
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="dropdown d-inline">
                                            <button class="btn-action btn-action-edit" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Edit & Kelola Device">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 12px; font-size: 0.9rem; min-width: 200px;">
                                                <li>
                                                    <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('admin.device.edit', $device->id) }}">
                                                        <i class="bi bi-pencil me-2 text-secondary"></i> Edit Device
                                                    </a>
                                                </li>
                                                @if($device->type === 'smart_gh' || $device->table_name)
                                                    <li>
                                                        <a class="dropdown-item py-2 d-flex align-items-center" href="#"
                                                            onclick="openClearDataModal({{ $device->id }}, '{{ addslashes($device->name) }}', '{{ $device->table_name }}')">
                                                            <i class="bi bi-database-dash me-2 text-warning"></i> Hapus Data Sensor
                                                        </a>
                                                    </li>
                                                @endif
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li>
                                                    <form action="{{ route('admin.device.destroy', $device->id) }}" method="POST"
                                                        onsubmit="return confirm('⚠️ BAHAYA: Menghapus device akan MENGHAPUS TABEL {{ $device->table_name }} secara permanen!\n\nLanjutkan?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item py-2 d-flex align-items-center text-danger border-0 bg-transparent w-100 text-start">
                                                            <i class="bi bi-trash me-2"></i> Hapus Device
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Belum ada device. <a href="{{ route('admin.device.create') }}">Tambah device
                                                pertama!</a></p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    <!-- QR Code Modal - Modern IoT Pass Style -->
    <div class="modal fade qr-modal" id="qrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: min(380px, calc(100vw - 24px)); margin: 12px auto;">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- Close button -->
                    <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal"
                        style="top: 14px; right: 14px; z-index: 10; filter: invert(1); opacity: 0.8;"></button>

                    <!-- QRIS-style Card -->
                    <div class="qris-card" id="qrisCard">
                        <!-- Header gradient band -->
                        <div class="qris-header">
                            <div class="qris-logo-row">
                                <img src="{{ asset(config('app.logo', 'images/logo.png')) }}?v=7" alt="Tanikaya" class="qris-header-logo">
                                <div class="qris-header-text">
                                    <div class="qris-brand-title">{{ strtoupper(config('app.name', 'Tanikaya')) }}</div>
                                    <div class="qris-sub">
                                        <span>Best Solution for <span class="qris-sub-highlight">Agriculture Machinery</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Device section -->
                        <div class="qris-device-section">
                            <div class="qris-device-name" id="qrisDeviceName">Device Name</div>
                        </div>

                        <!-- QR Code area with viewfinder corners -->
                        <div class="qris-qr-wrapper">
                            <div class="qris-qr-border">
                                <span class="corner corner-tl"></span>
                                <span class="corner corner-tr"></span>
                                <span class="corner corner-bl"></span>
                                <span class="corner corner-br"></span>
                                <div id="qrCanvas" style="width: 260px; min-height: 260px; margin: 0 auto;"></div>
                            </div>
                        </div>
                        <div id="qrError" class="text-danger text-center mt-1 mb-2 px-3" style="display: none; font-size: 0.85rem;"></div>

                        <!-- Token Box with Copy -->
                        <div class="qris-token-box" onclick="copyCardToken(this)" title="Klik untuk menyalin token">
                            <div class="qris-token-label">KODE TOKEN PERANGKAT</div>
                            <div class="qris-token-inner">
                                <span class="qris-token" id="qrisToken">XXXXXXXXXXXXXXXX</span>
                                <i class="bi bi-clipboard qris-token-copy-icon" id="qrisCopyIcon"></i>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="qris-footer">
                            <span><i class="bi bi-shield-check text-warning me-1"></i>Scan via kamera aplikasi Tanikaya</span>
                        </div>
                    </div>

                    <!-- Download button (outside card for clean export) -->
                    <div class="text-center p-3">
                        <button class="btn btn-download-qr" onclick="downloadQr()">
                            <i class="bi bi-download me-2"></i>Download QR Card
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clear Data Modal -->
    <div class="modal fade" id="clearDataModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: min(460px, calc(100vw - 24px)); margin: 12px auto;">
            <div class="modal-content" style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
                <form id="clearDataForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(234, 88, 12, 0.1); color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                                <i class="bi bi-database-dash"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold text-dark mb-0">Hapus Data Sensor</h5>
                                <small class="text-muted" id="clearDataDeviceName">Device</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4 px-4">
                        <div class="alert alert-warning d-flex align-items-start gap-2 py-2 px-3 mb-3" style="border-radius: 12px; font-size: 0.85rem; background: #fffbeb; border: 1px solid #fef3c7; color: #b45309;">
                            <i class="bi bi-info-circle-fill fs-6 mt-1 flex-shrink-0"></i>
                            <div>
                                Device, token, sensor, dan setting <strong>TIDAK AKAN</strong> terhapus. Hanya riwayat log telemetry yang dibersihkan.
                            </div>
                        </div>

                        <label class="form-label fw-semibold text-secondary mb-2" style="font-size: 0.85rem;">PILIH METODE PENGHAPUSAN:</label>
                        
                        <div class="p-3 mb-2 rounded border" style="cursor: pointer;" onclick="document.getElementById('modeAll').checked = true; toggleDateInputs();">
                            <div class="form-check m-0">
                                <input class="form-check-input" type="radio" name="mode" id="modeAll" value="all" checked onchange="toggleDateInputs()">
                                <label class="form-check-label fw-bold text-dark ms-2" for="modeAll" style="cursor: pointer;">
                                    Kosongkan Semua Data
                                    <small class="d-block text-muted fw-normal">Menghapus seluruh rekaman log sensor di tabel.</small>
                                </label>
                            </div>
                        </div>

                        <div class="p-3 rounded border" style="cursor: pointer;" onclick="document.getElementById('modeRange').checked = true; toggleDateInputs();">
                            <div class="form-check m-0">
                                <input class="form-check-input" type="radio" name="mode" id="modeRange" value="range" onchange="toggleDateInputs()">
                                <label class="form-check-label fw-bold text-dark ms-2" for="modeRange" style="cursor: pointer;">
                                    Hapus Berdasarkan Rentang Tanggal
                                    <small class="d-block text-muted fw-normal">Hanya menghapus data pada periode tertentu.</small>
                                </label>
                            </div>
                        </div>

                        <div id="dateRangeFields" class="mt-3 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; display: none;">
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-semibold small mb-1">Dari Tanggal & Waktu</label>
                                <input type="datetime-local" class="form-control form-control-sm" name="start_date" id="clearStartDate">
                            </div>
                            <div>
                                <label class="form-label text-secondary fw-semibold small mb-1">Sampai Tanggal & Waktu</label>
                                <input type="datetime-local" class="form-control form-control-sm" name="end_date" id="clearEndDate">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 500;">Batal</button>
                        <button type="submit" class="btn btn-danger px-4" style="border-radius: 10px; font-weight: 600;">
                            <i class="bi bi-trash3 me-1"></i> Hapus Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- QRCode.js Local -->
    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <!-- html2canvas for card download -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script>
        let currentDeviceName = '';
        const logoImg = new Image();
        logoImg.crossOrigin = 'anonymous';
        logoImg.src = '{{ asset(config('app.logo', 'images/logo.png')) }}?v=7';

        function showQrModal(token, deviceName) {
            currentDeviceName = deviceName;
            document.getElementById('qrisDeviceName').textContent = deviceName;
            document.getElementById('qrisToken').textContent = token;

            // Reset copy button status
            const copyIcon = document.getElementById('qrisCopyIcon');
            if (copyIcon) {
                copyIcon.className = 'bi bi-clipboard qris-token-copy-icon';
            }

            // Wait a tiny bit for modal to be visible then generate
            setTimeout(() => generateQrisQr(token), 100);

            const modal = new bootstrap.Modal(document.getElementById('qrModal'));
            modal.show();
        }

        function copyCardToken(boxEl) {
            const tokenEl = document.getElementById('qrisToken');
            if (!tokenEl) return;
            const token = tokenEl.textContent.trim();
            if (!token) return;

            navigator.clipboard.writeText(token).then(() => {
                const icon = document.getElementById('qrisCopyIcon');
                if (icon) {
                    icon.className = 'bi bi-check2-circle text-success fw-bold';
                    setTimeout(() => {
                        icon.className = 'bi bi-clipboard qris-token-copy-icon';
                    }, 2000);
                }
            }).catch(err => {
                console.warn('Clipboard write failed:', err);
            });
        }

        function generateQrisQr(text) {
            const qrContainer = document.getElementById('qrCanvas');
            const qrError = document.getElementById('qrError');

            // Reset previous QR and error message
            qrContainer.innerHTML = '';
            qrError.style.display = 'none';
            qrError.textContent = '';

            if (typeof QRCode === 'undefined') {
                qrError.textContent = 'QR library tidak dimuat (QRCode.js tidak ditemukan). Silakan refresh halaman.';
                qrError.style.display = 'block';
                return;
            }

            try {
                // Generate QR code directly into container using QRCode.js
                new QRCode(qrContainer, {
                    text: text,
                    width: 260,
                    height: 260,
                    colorDark: '#0f172a',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H,
                });
            } catch (err) {
                console.error('QR generation error:', err);
                qrError.textContent = 'Gagal membuat QR code. Cek konsol untuk detail.';
                qrError.style.display = 'block';
                return;
            }

            // After QR is rendered, overlay the logo in center
            setTimeout(function() {
                const qrImg = qrContainer.querySelector('img');
                const qrCanvasEl = qrContainer.querySelector('canvas');

                if (!qrImg && !qrCanvasEl) {
                    qrError.textContent = 'QR tidak muncul: Elemen QR tidak dibuat.';
                    qrError.style.display = 'block';
                    return;
                }

                if (qrCanvasEl) {
                    // Style the canvas
                    qrCanvasEl.style.borderRadius = '14px';
                    qrCanvasEl.style.display = 'block';

                    // Draw logo overlay on top of the canvas
                    const ctx = qrCanvasEl.getContext('2d');
                    const size = qrCanvasEl.width;

                    if (logoImg.complete && logoImg.naturalWidth > 0) {
                        drawLogoOnCanvas(ctx, size);
                    } else {
                        logoImg.onload = function() {
                            drawLogoOnCanvas(ctx, size);
                        };
                    }
                }

                // Hide the img fallback if canvas exists
                if (qrImg && qrCanvasEl) {
                    qrImg.style.display = 'none';
                }
            }, 300);
        }

        function drawLogoOnCanvas(ctx, size) {
            const containerSize = 70; // 26.9% of 260px QR, safely within 30% H-level error correction
            const cx = size / 2;
            const cy = size / 2;
            const x = cx - containerSize / 2;
            const y = cy - containerSize / 2;
            const radius = 16;

            ctx.save();

            // Draw clean rounded rectangle (squircle) container
            ctx.beginPath();
            if (ctx.roundRect) {
                ctx.roundRect(x, y, containerSize, containerSize, radius);
            } else {
                ctx.moveTo(x + radius, y);
                ctx.lineTo(x + containerSize - radius, y);
                ctx.quadraticCurveTo(x + containerSize, y, x + containerSize, y + radius);
                ctx.lineTo(x + containerSize, y + containerSize - radius);
                ctx.quadraticCurveTo(x + containerSize, y + containerSize, x + containerSize - radius, y + containerSize);
                ctx.lineTo(x + radius, y + containerSize);
                ctx.quadraticCurveTo(x, y + containerSize, x, y + containerSize - radius);
                ctx.lineTo(x, y + radius);
                ctx.quadraticCurveTo(x, y, x + radius, y);
                ctx.closePath();
            }

            // Subtle drop shadow for depth and separation from modules
            ctx.shadowColor = 'rgba(0, 0, 0, 0.2)';
            ctx.shadowBlur = 8;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 2;

            // Pure white background
            ctx.fillStyle = '#ffffff';
            ctx.fill();

            // Thin gold accent stroke
            ctx.shadowColor = 'transparent';
            ctx.strokeStyle = '#facc15';
            ctx.lineWidth = 2.5;
            ctx.stroke();

            ctx.restore();

            // Draw centered logo inside with 6px margin
            const badgeSize = 58;
            const bx = cx - badgeSize / 2;
            const by = cy - badgeSize / 2;

            if (logoImg.complete && logoImg.naturalWidth > 0) {
                ctx.drawImage(logoImg, bx, by, badgeSize, badgeSize);
            }
        }

        function downloadQr() {
            const card = document.getElementById('qrisCard');
            html2canvas(card, {
                scale: 3,
                backgroundColor: '#ffffff',
                useCORS: true,
                logging: false,
            }).then(function(canvas) {
                const link = document.createElement('a');
                const safeName = currentDeviceName.replace(/[^a-zA-Z0-9]/g, '_');
                link.download = 'QR_{{ preg_replace('/[^a-zA-Z0-9]/', '_', config('app.name', 'Tanikaya')) }}_' + safeName + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }

        function copyToClipboard(e, text, el) {
            e.preventDefault();
            navigator.clipboard.writeText(text).then(() => {
                const icon = el.querySelector('i');
                const originalClass = icon.className;
                const originalText = el.innerHTML;
                
                // Ubah icon jadi centang hijau
                icon.className = 'bi bi-check2 text-success me-2';
                const textNode = el.lastChild;
                if(textNode && textNode.nodeType === 3) textNode.nodeValue = ' Copied!';
                
                // Kembalikan ke asal setelah 2 detik
                setTimeout(() => {
                    el.innerHTML = originalText;
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy data: ', err);
                alert('Gagal menyalin data.');
            });
        }

        function openClearDataModal(deviceId, deviceName, tableName) {
            document.getElementById('clearDataDeviceName').textContent = deviceName + ' (' + tableName + ')';
            document.getElementById('clearDataForm').action = '/admin/device/' + deviceId + '/clear-data';
            document.getElementById('modeAll').checked = true;
            toggleDateInputs();
            const modal = new bootstrap.Modal(document.getElementById('clearDataModal'));
            modal.show();
        }

        function toggleDateInputs() {
            const isRange = document.getElementById('modeRange').checked;
            const container = document.getElementById('dateRangeFields');
            const startInput = document.getElementById('clearStartDate');
            const endInput = document.getElementById('clearEndDate');
            if (isRange) {
                container.style.display = 'block';
                startInput.required = true;
                endInput.required = true;
            } else {
                container.style.display = 'none';
                startInput.required = false;
                endInput.required = false;
            }
        }
    </script>

</body>

</html>