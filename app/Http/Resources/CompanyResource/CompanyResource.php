<?php

namespace App\Http\Resources\CompanyResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Traits\GeneralTrait;

class CompanyResource extends JsonResource
{
    use GeneralTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'description' => $this->discription,
            'logo' => $this->logo? env('PATH_IMG') . $this->logo : null ,
            'domain' => $this->domain,
            'employess_count' => $this->employess_count,
        ];
    }
    public function successResponse()
    {
        return $this->apiResponse(['company' => $this], true, null, 200);
    }
    public function successResponseWithToken($token)
    {
        return $this->apiResponse(['company' => $this, 'token' => $token], true, null, 200);
    }
}
