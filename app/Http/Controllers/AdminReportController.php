<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminReportController extends Controller
{
    public function index()
    {
        // Restrict to admins
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Fetch reports with relationships
        $reports = Report::with(['buyer', 'farmer', 'orderItem.produce'])
            ->latest()
            ->paginate(10)
            ->through(function ($report) {
                return [
                    'id' => $report->id,
                    'order_item_id' => $report->order_item_id,
                    'produce_name' => $report->orderItem->produce->name ?? 'N/A',
                    'buyer_name' => $report->buyer->name ?? 'N/A',
                    'buyer_email' => $report->buyer->email ?? 'N/A',
                    'farmer_name' => $report->farmer->name ?? 'N/A',
                    'farmer_email' => $report->farmer->email ?? 'N/A',
                    'reason' => $report->reason,
                    'status' => $report->status,
                    'created_at' => $report->created_at->toDateTimeString(),
                ];
            });

        return Inertia::render('Admin/Reports/Index', [
            'reports' => $reports,
        ]);
    }

    public function updateStatus(Request $request, Report $report)
    {
        // Restrict to admins
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Validate
        $request->validate([
            'status' => 'required|in:pending,reviewed,resolved',
        ]);

        // Update status
        $report->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report status updated successfully.');
    }
}