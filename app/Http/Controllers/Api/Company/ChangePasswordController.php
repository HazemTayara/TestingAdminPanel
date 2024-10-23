<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    use GeneralTrait;

    
    public function ChangePassword(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|max:20|min:8|confirmed',
        ]);

        if ($validation->fails()) {
            # status code 400 - BAD REQUEST  
            return $this->ValidationError($request->all(), $validation);
        }

        $user = auth('company')->user();
        if (!$user) {
            # status code 401-UnAuthorize  
            return $this->unAuthorizeResponse();
        }

        if (!Hash::check($request->old_password, $user->password)) {
            # status code 400 - BAD REQUEST  
            return $this->requiredField('كلمة السر القديمة غير صحيحة');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        # status code 200 
        return $this->SuccessResponse();
    }
}
