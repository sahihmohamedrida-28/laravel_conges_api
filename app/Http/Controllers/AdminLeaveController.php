<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminLeaveController extends Controller
{


    public function credit(Request $request, User $user)
    {
        $request->validate([
            'jours' => 'required|integer|min:1',
        ]);

        $user->solde_conges += $request->jours;
        $user->save();

        return response()->json([
            'message'      => 'Solde crédité avec succès',
            'user_id'      => $user->id,
            'solde_conges' => $user->solde_conges,
        ]);
    }


    public function debit(Request $request, User $user)
    {
        $request->validate([
            'jours' => 'required|integer|min:1',
        ]);

        if ($user->solde_conges < $request->jours) {
            return response()->json([
                'message' => 'Solde insuffisant pour ce débit',
            ], 422);
        }

        $user->solde_conges -= $request->jours;
        $user->save();

        return response()->json([
            'message'      => 'Solde débité avec succès',
            'user_id'      => $user->id,
            'solde_conges' => $user->solde_conges,
        ]);
    }
}
