<?php
namespace App\Repositories;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ProductRepository implements ProductInterface{

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return Product::all();
    }

    public function findById(int $id)
    {
        // TODO: Implement findById() method.
        return Product::find($id);
    }

    public function create(Request $request)
    {
        // TODO: Implement create() method.
        $product = new Product();
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->save();
        return $product;
    }

    public function edit(Request $request, int $id)
    {
        // TODO: Implement edit() method.
        $product = $this->findById($id);
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        if(isset($request->status)){
            $product->status=$request->status;
        }
        $product->save();
        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->findById($id);
        $product->delete();
        return $product;
        // TODO: Implement delete() method.
    }
}
