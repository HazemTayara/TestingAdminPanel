<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\ReportResourseResearch;
use App\Models\Company;
use App\Models\Report;
use Auth;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    use GeneralTrait;
    public function ReportByResearcher(Request $request)
    {
        try {
            //code...
            // $id = $request->researcher;
            $idreseacher = auth('researcher')->user()->id;
            $reports = Report::where('researcher_id', $idreseacher)->get();
            if ($reports) {
                $data['reports'] = ReportResourseResearch::collection($reports);
                return $this->apiResponse($data, true, null, 200);
            } else {
                return $this->apiResponse(null, true, null, 200);
            }
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

    public function showAll()
    {
        $reports = Product::all();
        if ($reports) {
            $data['Product'] = ProductResource::collection($reports);
            return $this->apiResponse($data, true, null, 200);
        } else {
            return $this->apiResponse(null, true, null, 200);
        }
    }

    public function addreport(Request $request)
    {
        try {
            //code...

            $idreseacher = auth('researcher')->user()->id;
            $validator = Validator::make($request->all(), [
                'product_uuid' => 'required|exists:products,uuid',
                'title' => 'required|string',
                'report_file' => 'required|mimes:pdf,docx|max:2048'
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return $this->apiResponse(null, false, $error, 400);
            }
            // dd($request->file('report-file'));
            $d = $request->file('report_file')->store('files', 'public');

            $report = Report::create([
                'title' => $request->title,
                'status' => 'pending',
                'product_id' => Product::where('uuid', $request->product_uuid)->pluck('id')->first(),
                'researcher_id' => $idreseacher,
                'review_status' => 0,
                'file' =>$d,
            ]);

            if ($report) {
                $data['report'] = ReportResourseResearch::make($report);
                return $this->SuccessResponse($data);
            } else {
                return $this->apiResponse(null, false, 'حدث خطا حاول الاضافة مرة أخرى', 200);
            }
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
    //
    public function ReportByCompany(Request $request)
    {
        $company = auth('company')->user();
        // $company = Company::find($company_id);
        // $report = $company->reports()->get();
        $report = Report::whereNotIn('status' , ['pending','reject'])->whereIn('product_id' , Product::where('company_id' , $company->id)->pluck('id')->toArray())->get();
        if (!$report) {
            return $this->apiResponse(null, false, 'not found', 404);
        }
        $data['report'] = ReportResource::collection($report);
        return $this->SuccessResponse($data);
    }
}