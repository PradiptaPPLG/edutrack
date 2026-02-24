<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GamificationService;

class GameController extends Controller
{
    public function awardXp(Request $request)
    {
        $user = auth()->user();
        $gamification = new GamificationService($user);
        
        $gamification->addXP($request->xp_earned, 'game_' . $request->game);
        
        return response()->json([
            'xp_earned' => $request->xp_earned,
            'total_xp' => $user->xp,
            'level' => $user->level
        ]);
    }
}