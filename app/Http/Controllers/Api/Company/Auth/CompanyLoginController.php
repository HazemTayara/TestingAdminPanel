<?php

namespace App\Http\Controllers\Api\Company\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CompanyResource\CompanyResource as CompanyResourceCompanyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyLoginController extends Controller
{

    use GeneralTrait;



    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => [
                'required',
                'string',
                'email',
                'exists:companies,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
            ],
        ];



        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->apiResponse(null, false, 'الايميل او كلمة السر خاطئة', 400);
        }

        $company = Company::where('email', $request->email)->first();

        if (!$company || !Hash::check($request->password, $company->password)) {
            return $this->apiResponse(null, false, 'الايميل او كلمة السر خاطئة', 400);
        }



        // if ($company->tokens()->exists()) 
        // {
        //     return $this->unAuthorizeResponse();
        // }

        $token = $company->createToken('auth_token')->plainTextToken;

        return (new CompanyResourceCompanyResource($company))->successResponseWithToken($token);
    }

    public function logout()
    {
        $company = auth()->guard('company')->user();

        if ($company && $company->currentAccessToken()) {
            $company->currentAccessToken()->delete();
            return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
        }
    }
}