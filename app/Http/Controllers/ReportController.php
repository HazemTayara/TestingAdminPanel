<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function update(Request $request, $id)
    {
        Log::info($request->status . ' id: ' . $id);

        // $report = Report::where('id', '=', $id)->where('status', '=', 'pending');
        // if ($report) {
        //     $report->update(
        //         ['status' => 'accept']
        //     );
        //     return back();
        // }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function details($uuid, $id)
    {
        $seen = Report::where('uuid', '=', $uuid)->first()->review_status;
        if (!$seen) {
            Report::where('uuid', '=', $uuid)->update([
                'user_id' => $id,
                'review_status' => 1
            ]);
        }
        $report = Report::where('uuid', '=', $uuid)->get()->first();
        if (view()->exists(view: 'report.details')) {
            return view('report.details', ['report' => $report]);
        } else {
            return view('404');
        }
    }
}
