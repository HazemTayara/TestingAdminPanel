<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResearcherResource;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Traits\GeneralTrait;
use App\Http\Resources\CompanyResource\CompanyResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Researcher;
use App\Models\Report;
use App\Models\Product;
use Exception;

class CompanyController extends Controller
{
    use GeneralTrait;

    public function index()
    {

        $resercher = Researcher::all();
        $company_id = auth('company')->user()->id;
        //  $products=product::where('company_id',$company_id)->get();
        $p_id = Product::where('company_id', $company_id)->pluck('id')->toArray();


        $pending = Report::where('status', 'pending')->whereIn('product_id', $p_id)->get();
        // dd($pending);
        $accept = Report::whereIn('product_id', $p_id)->where('status', 'accept')->get();
        if (empty($pending)) {
            $countpend = 0;
        }
        if (empty($accept)) {
            $countaccept = 0;
        }
        $countpend = count($pending);
        $countaccept = count($accept);
        $x = $countaccept + $countpend;
        $x = $x == 0 ? 1 : $x;
        $percentpending = $countpend / $x * 100;
        $percentaccept = $countaccept / $x * 100;

        $data['researcher'] = ResearcherResource::collection($resercher);
        $data['count_pending'] = $countpend;
        $data['count_accept'] = $countaccept;
        $data['count_pending_percent'] = $percentpending;
        $data['count_accept_percent'] = $percentaccept;

        return $this->apiResponse($data, true, null, 200);
    }

    public function show(Request $request)
    {
        try {
            $companies = auth('company')->user();
            $data['company'] = new CompanyResource($companies);
            return $this->apiResponse($data, true, null, 200);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }



    public function update(Request $request)
    {
        # ***************
        // $companies = company::find($id);
        // $companies = company::where('uuid', $request->uuid)->first();
        $companies = auth('company')->user();
        if (!$companies) {
            return $this->notFoundResponse('هذه الشركة غير موجودة ',);
        }
        # ***************

        $validateData = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('companies')->ignore($companies->id),
                ],
                'type' => 'required|string|max:255|in:خاصة,حكومية,مشتركة',
                'description' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'domain' => 'required|string|max:255',
                'employess_count' => 'required|integer|min:1',
            ]
        );

        if ($validateData->fails()) {
            return $this->ValidationError(null, $validateData);
        }


        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public'); //هون عم خزن الصور بالمجلد 
            $logo = $path; //هون عم اكتب مسار الصورة كامل مشان الفرونت يقدرو يشوفوها
        }
        //التحديث
        $companies->update([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'description' => $request->description ?? $companies->description,
            'logo' => $logo ?? $companies->logo,
            'domain' => $request->domain ?? $companies->domain,
            'employess_count' => $request->employess_count,

        ]);
        return $this->SuccessResponse(new CompanyResource($companies));
    }
}