<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use GeneralTrait;
    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = auth('company')->user()->id;
        $product = Product::where('company_id', $id)->get();
        if (!$product) {
            return $this->apiResponse(null, false, 'not found', 400);
        }
        $data['products'] = ProductResource::collection($product);
        return $this->apiResponse($data, true, null, 200);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string',
                'description' => 'required|string',
                // 'company_uuid' => 'required|integer|exists:companies,uuid',
                'url' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return $this->ValidationError($request->all(), $validator);
        }
        $id = auth('company')->user()->id;
        try {
            $product = Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'company_id' => $id,
                'terms' => '',
                'url' => $request->url,
            ]);
            $data['product'] = ProductResource::make($product);
            return $this->apiResponse($data, true, null, 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }



    public function deletepackage(Request $request)
    {

        $Product = Product::where('uuid', $request->uuid);
        $Product->delete();
        return $this->apiResponse('تم الحذف بنجاح', true, null, 200);
    }
}