<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * using solid principle.
     */
    public $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository=$productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = $this->productRepository->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Product List',
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|max:300',
            'price' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $product = $this->productRepository->create($request);
        if($product){
            return response()->json([
                'status' => true,
                'message' => 'Product Successfully Created',
                'product'=> $product
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'product'=> null
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $success=true;
        $message='Product By Id';
        $products = $this->productRepository->findById($id);
        if(is_null($products)){
            $success=false;
            $message="Product not found!";
            $products=null;
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $productFound=$this->productRepository->findById($id);
        if(is_null($productFound)){
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found!',
                'product'=> null
            ]);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|max:300',
            'price' => 'required|integer'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $product = $this->productRepository->edit($request, $id);
        if($product){
            return response()->json([
                'status' => true,
                'message' => 'Product Successfully Updated',
                'product'=> $product
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'product'=> null
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $productFound=$this->productRepository->findById($id);
        if(is_null($productFound)){
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found!',
                'product'=> null
            ]);
        }
        $product = $this->productRepository->delete($id);
        return response()->json([
            'status' => true,
            'message' => 'Product Successfully Deleted',
            'product'=> $product
        ]);
    }
}
