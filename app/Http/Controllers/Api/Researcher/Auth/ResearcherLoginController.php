<?php

namespace App\Http\Controllers\Api\Researcher\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use  App\Models\Researcher;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ResearcherResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResearcherLoginController extends Controller
{
    use GeneralTrait;

    public function login(Request $request)
    {
        $rules = [
            'email' => [
                'required',
                'string',
                'email',
                'exists:researchers,email',
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
            $firstError = $validator->errors()->first();

            if (strpos($firstError, 'مطلوب') !== false) {
                return $this->apiResponse(null, false, 'الايميل او كلمة السر خاطئة', 400);
            }
            return $this->apiResponse(null, false, 'الايميل او كلمة السر خاطئة', 400);
        }

        $researcher = Researcher::where('email', $request->email)->first();

        if (!$researcher || !Hash::check($request->password, $researcher->password)) {
            return $this->apiResponse(null, false, 'الايميل او كلمة السر خاطئة', 400);
        }

        if (is_null($researcher->code)) {
            $data['researcher'] = [
                'code' => false,
                'uuid' => $researcher->uuid,
            ];
            return $this->SuccessResponse($data);
        }

        // if ($researcher->tokens()->exists()) {
        //     return $this->unAuthorizeResponse();
        // }

        $token = $researcher->createToken('auth_token')->plainTextToken;

        $data['researcher'] =
            [
                'code' => true,
                ResearcherResource::make($researcher)
            ];

        // return ()->successResponseWithToken($token);
    }

    public function logout()
    {
        $researcher = auth()->guard('researcher')->user();

        if ($researcher && $researcher->currentAccessToken()) {
            $researcher->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
    }
}