<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResourseResearch extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'title' => $this->title,
            'company_name' => $this->product->company->name,
            'created_at' => $this->created_at,
            'file' => env('PATH_IMG') .$this->file,
            'status' => $this->status
        ];
    }
}