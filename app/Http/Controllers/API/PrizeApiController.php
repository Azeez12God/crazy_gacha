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
        $user = Auth::user();

        // 1. Obtener huevo activo
        $activeEgg = $user->shops()
            ->where('type', 'Egg')
            ->orderBy('pivot_created_at', 'desc')
            ->first();

        // 2. Determinar probabilidades
        $probabilities = $activeEgg
            ? json_decode($activeEgg->rarity_probabilities, true)
            : [
                'comun' => 60,
                'rara' => 25,
                'especial' => 10,
                'epica' => 4,
                'legendaria' => 1
            ];

        if ($activeEgg) {
            $user->shops()->detach($activeEgg->id);
        }

        // 3. Calcular rareza
        $roll = rand(1, 100);
        $cumulative = 0;
        $selectedRarity = 'comun';

        foreach ($probabilities as $rarity => $chance) {
            $cumulative += $chance;
            if ($roll <= $cumulative) {
                $selectedRarity = $rarity;
                break;
            }
        }

        // 4. Obtener premio
        $prize = Prize::where('rarity', $selectedRarity)->inRandomOrder()->first();

        if (!$prize) {
            return response()->json([
                'message' => "No hay premios de rareza $selectedRarity",
                'data' => null
            ]);
        }

        // 5. Guardar en la tabla pivote prize_user
        $existing = $user->prizes()->where('prize_id', $prize->id)->exists();

        if ($existing) {
            // Ya tiene ese premio, aumentar el contador
            $user->prizes()->updateExistingPivot($prize->id, [
                'count' => \DB::raw('count + 1')
            ]);
        } else {
            // No tiene ese premio, añadir con count = 1
            $user->prizes()->attach($prize->id, ['count' => 1]);
        }

        return response()->json([
            'message' => 'Premio obtenido',
            'data' => [
                "prize" => $prize,
                "probabilities" => $probabilities,
            ]
        ], 200);
    }

    public function sell(Prize $prize)
    {
        $user = Auth::user();
        $totalEarned = 0;

        // Obtener la relación en la tabla pivote
        $pivot = $user->prizes()->where('prize_id', $prize->id)->first();

        // Validar que tenga más de 1 para vender
        if (!$pivot || $pivot->pivot->count < 2) {
            return response()->json([
                'message' => 'No tienes suficientes copias para vender este premio.',
                'data' => null
            ]);
        }

        // Bajar la cantidad en la tabla pivote
        $user->prizes()->updateExistingPivot($prize->id, [
            'count' => 1
        ]);

        // Sumar la recompensa al dinero del usuario
        $repetidas = $pivot->pivot->count-1;
        $totalEarned += $prize->reward * $repetidas;
        $user->money += $totalEarned;
        $user->save();

        return response()->json([
            'message' => 'Premio vendido correctamente.'
        ], Response::HTTP_OK);
    }

    public function sellAllDuplicates()
    {
        $user = Auth::user();
        $totalEarned = 0;

        // Obtener todos los premios del usuario con su pivote
        $prizes = $user->prizes()->withPivot('count')->get();

        // Filtrar solo los premios con más de una copia
        $duplicates = $prizes->filter(function ($prize) {
            return $prize->pivot->count > 1;
        });

        // Si no hay ninguno repetido, enviar respuesta
        if ($duplicates->isEmpty()) {
            return response()->json([
                'message' => 'No tienes premios repetidos para vender.',
                'data' => null
            ]);
        }

        // Procesar los premios duplicados
        foreach ($duplicates as $prize) {
            $repetidas = $prize->pivot->count - 1;

            // Restar las repetidas
            $user->prizes()->updateExistingPivot($prize->id, [
                'count' => 1
            ]);

            // Sumar el dinero
            $totalEarned += $prize->reward * $repetidas;

            $vendidos[] = [
                'name' => $prize->name,
                'cantidadVendida' => $repetidas,
                'totalGanado' => $prize->reward * $repetidas,
            ];
        }

        // Aumentar el dinero total ganado al usuario
        $user->money += $totalEarned;
        $user->save();

        return response()->json([
            'message' => 'Premios repetidos vendidos correctamente.',
            'vendidos' => $vendidos
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
