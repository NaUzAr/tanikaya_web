<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Ticket::with('user');

        if ($status && in_array($status, ['open', 'in_progress', 'resolved', 'closed'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query
            ->orderByRaw("CASE status 
                WHEN 'open' THEN 1 
                WHEN 'in_progress' THEN 2 
                WHEN 'resolved' THEN 3 
                WHEN 'closed' THEN 4 
                ELSE 5 END")
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'all' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
        ];
            
        return view('admin.tickets.index', compact('tickets', 'counts', 'status', 'search'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'replies.user']);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'admin_reply' => 'nullable|string',
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        if ($request->filled('admin_reply')) {
            $ticket->replies()->create([
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'message' => $request->admin_reply,
            ]);
        }

        return redirect()->route('admin.tickets.show', $ticket->id)
            ->with('success', 'Tiket berhasil diupdate.');
    }
}
