<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShopApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Shop::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopRequest $request)
    {
        $shop = new Shop();
        $shop->name=$request->name;
        $shop->price=$request->price;
        $shop->type=$request->type;
        $shop->quantity=$request->quantity;

        if($shop->save()){
            return response()->json([
               'message' => 'Producto creado correctamente',
               'data' => $shop
            ], Response::HTTP_CREATED);
        }
        else{
            return response()->json([
               'message' => 'Error al crear el producto',
               'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        if($shop){
            return response()->json([
               'message' => 'Los datos del producto ' . $shop->id,
               'data' => $shop
            ], Response::HTTP_OK);
        }
        else{
            return response()->json([
               'message' => 'No se encontró el producto' . $shop->id,
               'data' => null
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        $shop->update($request->all());

        if($shop){
            return response()->json([
               'message' => 'Producto actualizado correctamente',
               'data' => $shop
            ], Response::HTTP_OK);
        }
        else{
            return response()->json([
               'message' => 'Error al actualizar el producto',
               'data' => null
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        if($shop->delete()){
            return response()->json([
               'message' => 'El producto ' . $shop->id . ' se ha eliminado correctamente',
               'data' => null
            ], Response::HTTP_OK);
        }
        else{
            return response()->json([
               'message' => 'Error al eliminar el producto',
               'data' => null
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
