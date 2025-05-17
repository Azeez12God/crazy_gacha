<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ShopApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Shop::all();
    }

    public function buy(Shop $shop)
    {
        $user = Auth::user();

        // Verificar si el usuario tiene suficiente dinero
        if ($user->money < $shop->price) {
            return response()->json([
                'message' => 'No tienes suficiente dinero para comprar este producto.'
            ], Response::HTTP_BAD_REQUEST);
        }

        // Verificar si el usuario ya tiene ese producto
        $existing = $user->shops()->where('shop_id', $shop->id)->exists();

        if ($existing) {
            // Ya tiene ese producto, aumentar el contador
            $user->shops()->updateExistingPivot($shop->id, [
                'count' => \DB::raw('count + 1')
            ]);
        } else {
            // No tiene ese producto, añadir con count = 1
            $user->shops()->attach($shop->id, ['count' => 1]);
        }

        // Restar el dinero al usuario
        $user->money -= $shop->price;
        $user->save();

        return response()->json([
            'message' => 'Producto comprado correctamente',
            'data' => $shop
        ], Response::HTTP_OK);
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
        $shop->linkImage=$request->linkImage;

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
        $user = Auth::user();
        if($user->hasRole('Admin')){
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
        else{
            return response()->json([
                'message' => 'Acceso denegado',
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
