<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowRequestController extends Controller
{
    // Student & Admin - View all borrow requests
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $requests = BorrowRequest::with('user', 'laptop')->latest()->get();
        } else {
            $requests = BorrowRequest::with('laptop')
                ->where('user_id', Auth::id())
                ->latest()->get();
        }

        return view('borrow_requests.index', compact('requests'));
    }

    // Student - Show laptop borrow request form
    public function create()
    {
        $laptops = Laptop::where('status', 'available')->get();
        return view('borrow_requests.create', compact('laptops'));
    }

    // Student - Submit a borrow request
    public function store(Request $request)
    {
        $request->validate([
            'laptop_id' => 'required|exists:laptops,id',
        ]);

        BorrowRequest::create([
            'user_id' => Auth::id(),
            'laptop_id' => $request->laptop_id,
            'request_date' => now(),
            'status' => 'pending',
        ]);

        return redirect()->route('borrow_requests.index')->with('success', 'Request submitted successfully.');
    }

    // Admin - Approve request
    public function approve($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);
        $borrowRequest->status = 'approved';
        $borrowRequest->save();

        // Mark the laptop as assigned
        $borrowRequest->laptop->update(['status' => 'assigned']);

        return back()->with('success', 'Request approved.');
    }

    // Admin - Deny request
    public function deny($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);
        $borrowRequest->status = 'denied';
        $borrowRequest->save();

        return back()->with('info', 'Request denied.');
    }

    // Admin - Mark as returned
    public function markReturned($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);
        $borrowRequest->status = 'returned';
        $borrowRequest->return_date = now();
        $borrowRequest->save();

        // Mark the laptop as available again
        $borrowRequest->laptop->update(['status' => 'available']);

        return back()->with('success', 'Laptop marked as returned.');
    }
}
// LaptopController.php