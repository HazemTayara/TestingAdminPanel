<?php

namespace App\Http\Controllers\Api\Researcher\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Mail\ForgetPasswordEmail;
use App\Models\Researcher;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgetPasswordController extends Controller
{

    use GeneralTrait;

    

    public function GenerateOTP(Request $request)
    {
        $validate = Validator::make(
            ['email' => $request->email],
            [
                'email' => 'required|email|exists:researchers,email'
            ]
        );
        if ($validate->fails()) {
            /**
             * data = $request->all()
             * message = $validate->errors()->first()
             * status = false
             * statusCode = 400
             */
            return $this->ValidationError($request->all(), $validate);
        }
        try {

            /**
             * Generate otp 
             * length = 4 
             * expired after 6 minutes
             */
            $otp = (new Otp())->generate($request->email, 'numeric');

            if ($otp->status == true) {

                $subjectTitle =  "Reset your password";
                $description = "Use this code to reset your password , ⚠ don't giv this code to anyone";
                $otp = $otp->token;

                Mail::to($request->email)->send(new ForgetPasswordEmail($subjectTitle, $otp, $description));


                return $this->SuccessResponse();
            } else {
                # 400 
                return $this->requiredField('something went wrong , please try again');
            }
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function ValidateOtp(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'otp' => 'required|numeric',
                'email' => 'required|email|exists:researchers,email',
            ]
        );
        if ($validate->fails()) {
            /**
             * data = $request->all()
             * message = $validate->errors()->first()
             * status = false
             * statusCode = 400
             */
            return $this->ValidationError($request->all(), $validate);
        }
        try {
            $otp = (new Otp())->validate($request->email, $request->otp);
            if ($otp->status == true) {
                $user = Researcher::where('email', $request->email)->pluck("uuid")->first();
                $data['uuid'] = $user;
                return $this->SuccessResponse($data);
            } else {
                return $this->requiredField('Invalid otp');
            }
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function ResetPassword(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:8|confirmed',
                'uuid' => 'required|exists:researchers,uuid',
            ]
        );
        if ($validate->fails()) {
            /**
             * data = $request->all()
             * message = $validate->errors()->first()
             * status = false
             * statusCode = 400
             */
            return $this->ValidationError($request->all(), $validate);
        }
        try {
            $researcher = Researcher::where('uuid', $request->uuid)->first();
            if ($researcher) {
                $researcher->update([
                    'password' => Hash::make($request->password)
                ]);
                return $this->SuccessResponse();
            } else {
                return $this->requiredField('Invalid Request');
            }
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }
}