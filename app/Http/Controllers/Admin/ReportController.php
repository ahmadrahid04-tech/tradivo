<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['user', 'listing.images']);

        if ($request->status) {
            $query->where('status', $request->status);
        } else {
            $query->pending();
        }

        $reports = $query->latest()->paginate(15)->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load(['user', 'listing.images', 'listing.user']);
        return view('admin.reports.show', compact('report'));
    }

    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,resolved',
        ]);

        $report->update(['status' => $request->status]);

        return back()->with('success', "Status laporan diubah menjadi {$request->status}.");
    }
}
