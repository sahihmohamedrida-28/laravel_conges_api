<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{

    public function solde()
    {
        $user = Auth::user();
        return response()->json([
            'solde_conges' => $user->solde_conges,
        ]);
    }


    public function request(Request $request)
    {
        $request->validate([
            'jours' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $jours = $request->jours;

        if ($user->solde_conges < $jours) {
            return response()->json([
                'message' => 'Solde de congés insuffisant',
            ], 422);
        }

        $user->solde_conges -= $jours;
        $user->save();

        return response()->json([
            'message'      => 'Demande de congé acceptée',
            'solde_conges' => $user->solde_conges,
        ]);
    }
}
