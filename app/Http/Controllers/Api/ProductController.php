<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        if(count($product) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $product,
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null,
        ], 400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_barang' => 'required|max:60|unique:products',
            'kode' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $product = Product::create($storeData);
        return response([
            'message' => 'Add Product Success',
            'data' =>$product
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if(!is_null($product)){
            return response([
                'messagse' => 'Retreive Product Success',
                'data' => $product
            ], 200);
        }

        return response([
            'messagse' => 'Product Not Found',
            'data' => null
        ], 404);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Prpduct::find($id);
        if(is_null($product)){
            return response([
                'messagse' => 'Product Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_barang' => ['required', 'max:60', Rule::unique('products')->ignore($product)],
            'kode' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $product->nama_barang = $updateData['nama_barang'];
        $product->kode = $updateData['kode'];
        $product->harga = $updateData['harga'];
        $product->jumlah = $updateData['jumlah'];

        if($product->save()){
            return response([
                'messagse' => 'Update Product Success',
                'data' => $product
            ], 200);
        }

        return response([
            'messagse' => 'Update Product Failed',
            'data' => null
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Prpduct::find($id);
        if(is_null($product)){
            return response([
                'messagse' => 'Product Not Found',
                'data' => null
            ], 404);
        }

        if($product->delete()){
            return response([
                'messagse' => 'Delete Product Success',
                'data' => $product
            ], 200);
        }

        return response([
            'messagse' => 'Delete Product Failed',
            'data' => null
        ], 400);
    }
}
