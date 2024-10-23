<?php

namespace App\Http\Controllers\Api\Researcher\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Company;
use App\Models\Researcher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ResearcherResource;
use App\Http\Traits\Uuid;
use Illuminate\Http\Request;

class ResearcherRegisterController extends Controller
{
    use GeneralTrait;
    use Uuid;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'regex:/^[\p{Arabic}a-zA-Z\s]+$/u',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
            ],
            'phone' => [
                'required',
                'regex:/^09\d{8}$/',
                'size:10',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
            ],
        ];
        $messages = [
            'email.required' => 'اسم الايميل مطلوب. يرجى إدخال اسم الايميل',
            'email.string' => 'اسم الايميل يجب أن يكون نصاً صحيحاً',
            'email.email' => 'اسم الايميل يجب أن يكون نمطه ايميل',
            'email.unique' => 'اسم الايميل يجب أن يكون فريد',

            'name.required' => 'اسم الباحث مطلوب. يرجى إدخال اسم الشخص',
            'name.string' => 'اسم الباحث يجب أن يكون نصاً صحيحاً',
            'name.regex' => 'اسم الباحث يمكن أن يحتوي فقط على حروف عربية، حروف إنجليزية، مسافات، فاصلة عليا (\')، ونقاط (.)',
            'name.min' => 'اسم الباحث يجب أن يحتوي على حرفين على الأقل',
            'name.max' => 'اسم الباحث يجب ألا يزيد عن 255 حرفاً',

            'phone.required' => 'رقم الموبايل مطلوب. يرجى إدخال رقم الموبايل',
            'phone.regex' => 'رقم الموبايل يجب أن يحتوي على 10 أرقام و يبدأ بالرقمين 09',
            'phone.size' => 'رقم الموبايل يجب ألا يزيد عن 10 أرقام',
            'phone.unique' => 'رقم الموبايل يجب أن يكون فريد',

            'password.required' => 'كلمة السر مطلوب. يرجى إدخال كلمة السر',
            'password.string' => 'كلمة السر يجب أن يكون نصاً صحيحاً',
            'password.min' => 'كلمة السر يجب أن يحتوي على 8 على الأقل',
            'password.max' => 'كلمة السر يجب ألا يزيد عن 255 حرفاً',
        ];

        $existingResearcher = Researcher::where('name', $request->name)
            ->where('email', $request->email)
            ->where('phone', $request->phone)
            ->whereNull('code')
            ->first();

        if ($existingResearcher) {
            if (Hash::check($request->password, $existingResearcher->password)) {
                return $this->apiResponse(
                    null,
                    false,
                    'بيانات الباحث موجودة مسبقاً. اذهب للقيام بإدخال الرمز لتفعيل حسابك.',
                    409
                );
            }
            return $this->apiResponse(
                null,
                false,
                'هناك خطأ في بيانات الباحث لا يمكن إتمام العملية.',
                400
            );
            // return response()->json([
            //     'message' => 'هناك خطأ في بيانات الباحث لا يمكن إتمام العملية.'
            // ], 400);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();

            if (strpos($firstError, 'مطلوب') !== false) {
                return $this->requiredField($firstError);
            }
            return $this->apiResponse(null, false, $firstError, 400);
        }

        if (!Researcher::where('email', $request->email)
            ->orWhere('phone', $request->phone)->first()) {
            $researcher = Researcher::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'points' => 0,
            ]);
            return (new ResearcherResource($researcher))->successResponse();
        }
        return $this->apiResponse(null,false,'الايميل أو رقم الموبايل موجود مسبقاً',400);
    }

    public function registerCode(Request $request, $uuid)
    {
        $researcherexists = Researcher::where('uuid', $uuid)->first();

        if (!$researcherexists) {
            return $this->notFoundResponse('لا يمكن طلب رمز لا يوجد باحث لإتمام ذلك');
        }
        $researcher = Researcher::find($researcherexists->id);

        $rules = [
            'code' => [
                'required',
                'string',
                'max:8',
            ],
        ];
        $messages = [
            'code.required' => 'رمز التحقق مطلوب.',
            'code.integer' => 'رمز التحقق يجب أن يكون رقماً صحيحاً.',
            'code.size' => 'رمز التحقق يجب أن يكون 8 خانات  ',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();

            if (strpos($firstError, 'مطلوب') !== false) {
                return $this->requiredField($firstError);
            }
            return $this->apiResponse(null, false, $firstError, 400);
        }
        
        if ($researcher) {
            $researcher->update([
                'code' => $request->code,
            ]);
            return (new ResearcherResource($researcher))->successResponse();
        }
        return $this->notFoundResponse('لا يمكن طلب رمز لا يوجد باحث لإتمام ذلك');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}