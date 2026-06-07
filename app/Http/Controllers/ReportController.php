<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Listing;
use App\Models\Report;

class ReportController extends Controller
{
    /**
     * Report a listing.
     */
    public function store(StoreReportRequest $request, Listing $listing)
    {
        // Check if already reported
        $exists = Report::where('user_id', auth()->id())
            ->where('listing_id', $listing->id)
            ->exists();

        if ($exists) {
            return back()->with('warning', 'Anda sudah pernah melaporkan iklan ini.');
        }

        Report::create([
            'user_id'     => auth()->id(),
            'listing_id'  => $listing->id,
            'reason'      => $request->reason,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Laporan berhasil dikirim. Terima kasih atas kontribusi Anda.');
    }
}
