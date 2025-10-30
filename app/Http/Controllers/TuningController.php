<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuning;
use Illuminate\Support\Facades\Auth;

class TuningController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'material' => 'required|string|max:50',
            'notes' => 'required|string',
            'gauges' => 'required|string',
            'tensions' => 'required|string',
            'total_tension' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Tuning::create($validated);

        return back()->with('success', 'Afinación guardada correctamente.');
    }
}
