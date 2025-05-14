<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePrizesRequest;
use App\Http\Requests\UpdatePrizesRequest;
use App\Models\Prize;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PrizeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Prize::all();
    }

    public function random()
    {
        // 1) Decide rareza con tus porcentajes
        $roll = rand(1, 100);

        if ($roll <= 60) {
            $rarity = 'comun';
        } elseif ($roll <= 85) {
            $rarity = 'rara';
        } elseif ($roll <= 95) {
            $rarity = 'especial';
        } elseif ($roll <= 99) {
            $rarity = 'epica';
        } else {
            $rarity = 'legendaria';
        }

        // 2) Saca un único registro de esa rareza
        $prize = Prize::where('rarity', $rarity)
            ->inRandomOrder()
            ->first();

        if (! $prize) {
            return response()->json([
                'message' => "No hay premios de rareza $rarity",
                'data'    => null
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Premio aleatorio obtenido',
            'data'    => $prize
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrizesRequest $request)
    {
        $prize = new Prize();
        $prize->name=$request->name;
        $prize->rarity=$request->rarity;
        $prize->reward=$request->reward;
        $prize->image=$request->image;

        if($prize->save()){
            return response()->json([
               'message' => 'Premio creado correctamente',
               'data' => $prize
            ], Response::HTTP_CREATED);
        }
        else{
            return response()->json([
                'message' => 'Error al crear premio',
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Prize $prize)
    {
        if($prize){
            return response()->json([
               'message' => 'Los datos del premio ' . $prize->id,
               'data' => $prize
            ], Response::HTTP_OK);
        }

        else{
            return response()->json([
                'message' => 'No se encontró el premio ' . $prize->id,
                'data' => null
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrizesRequest $request, Prize $prize)
    {
        $prize->update($request->all());

        if($prize){
            return response()->json([
                'message' => 'Premio actualizado correctamente',
                'data' => $prize
            ], Response::HTTP_OK);
        }

        else{
            return response()->json([
                'message' => 'Error al actualizar premio',
                'data' => null
            ],Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prize $prize)
    {
        $user = Auth::user();

        if($user->hasRole('Admin')){
            if($prize->delete()){
                return response()->json([
                    'message' => 'Premio eliminado correctamente',
                    'data' => null
                ], Response::HTTP_OK);
            }
            else{
                return response()->json([
                    'message' => 'Error al eliminar premio',
                    'data' => null
                ],Response::HTTP_NOT_FOUND);
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
