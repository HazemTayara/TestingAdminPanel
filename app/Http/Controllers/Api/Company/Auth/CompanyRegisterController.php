<?php

namespace App\Http\Controllers\Api\Company\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CompanyResource\CompanyResource as CompanyResourceCompanyResource;
use App\Http\Traits\Uuid;
use Illuminate\Http\Request;


class CompanyRegisterController extends Controller
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
                'regex:/^[\p{Arabic}a-zA-Z0-9\s]+$/u',
                'max:255',
            ],
            'domain' => [
                'required', 
                'string',    
                'url',       
                'max:255',
            ],
            'type' => [
                'required',
                'string',
                'in:حكومية,مشتركة,خاصة',
            ],
            'employess_count' => [
                'required',
                'integer',
                'min:5',
            ],
            'email' => [
                'required',
                'string',
                'email', 
                'unique:companies,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
            ],
        ];
    
        $messages = [
            'name.required' => 'اسم الشركة مطلوب. يرجى إدخال اسم الشخص.',
            'name.string' => 'اسم الشركة يجب أن يكون نصاً صحيحاً.',
            'name.regex' => 'اسم الشركة يجب أن يحتوي فقط على حروف عربية أو انكليزية و مسافات و يمكن أن تحتوي على أرقام .',
            'name.max' => 'اسم الشركة يجب ألا يزيد عن 255 حرفاً.',
            
            'domain.required' => 'الدومين مطلوب. يرجى إدخال دومين صحيح.',
            'domain.string' => 'الدومين يجب أن يكون نصاً صحيحاً.',
            'domain.url' => 'الدومين يجب أن يكون رابط URL صالح مثل: https://example.com.',
            'domain.max' => 'الدومين يجب ألا يزيد عن 255 حرفاً.',
            
            'type.required' => 'نوع الشركة مطلوب. يرجى اختيار نوع صحيح.',
            'type.string' => 'النوع يجب أن يكون نصاً صحيحاً.',
            'type.in' => 'القيمة المختارة لنوع الشركة غير صحيحة. القيم المتاحة هي : حكومية أو مشتركة أو خاصة.',

            'employess_count.required' => 'عدد الموظفين مطلوب.',
            'employess_count.integer' => 'عدد الموظفين يجب أن يكون رقماً صحيحاً.',
            'employess_count.min' => 'عدد الموظفين يجب ألا يقل عن 5.',

            'email.required' => 'البريد الإلكتروني مطلوب. يرجى إدخال البريد الإلكتروني.',
            'email.string' => 'البريد الإلكتروني يجب أن يكون نصاً صحيحاً.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون بصيغة صحيحة.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل. يجب أن يكون فريداً.',
        
            'password.required' => 'كلمة المرور مطلوبة. يرجى إدخال كلمة المرور.',
            'password.string' => 'كلمة المرور يجب أن تكون نصاً صحيحاً.',
            'password.min' => 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل.',
            'password.max' => 'كلمة المرور يجب ألا تزيد عن 255 حرفاً.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) 
        {
            $firstError = $validator->errors()->first();

            if (strpos($firstError, 'مطلوب') !== false) 
            {
                return $this->requiredField($firstError);  
            }
            return $this->apiResponse(null, false, $firstError, 400);
        }
    
        $company = Company::create([
            'name' => $request->name,
            'domain' => $request->domain,
            'type' => $request->type,
            'employess_count' => $request->employess_count,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => null ,
        ]);
        return (new CompanyResourceCompanyResource($company))->successResponse();
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