<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuning;
use Illuminate\Support\Facades\Auth;

class TuningController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()
                ->with('error', 'Debes iniciar sesión para guardar una afinación.');
        }
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

    public function edit(Tuning $tuning)
    {
        if ($tuning->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tunings.edit', compact('tuning'));
    }

    public function update(Request $request, Tuning $tuning)
    {
        if ($tuning->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'notes' => 'required|string',
            'total_tension' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $tuning->update($data);

        return redirect()
            ->route('profile.edit')
            ->with('status', 'tuning-updated');
    }

    public function destroy(Tuning $tuning)
    {
        if ($tuning->user_id !== Auth::id()) {
            abort(403);
        }

        $tuning->delete();

        return back()->with('status', 'tuning-deleted');
    }
}
