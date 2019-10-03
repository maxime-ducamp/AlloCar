<?php

namespace App\Http\Controllers\Admin;

use App\Journey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminJourneysController extends Controller
{
    public function index()
    {
        $journeys = Journey::paginate(10);

        return view('admin.journeys.index', compact('journeys'));
    }

    public function edit(Journey $journey)
    {
        return view('admin.journeys.edit', compact('journey'));
    }

    public function update(Request $request, Journey $journey)
    {
        $data = $request->all();

        if ($journey->update($data)) {
            return redirect()->route('admin.journeys.index')
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Trajet modifié'
                ]);
        } else {
            return redirect()->back()->with('flash', [
                'status' => 'error',
                'message' => 'Une erreur est survenue'
            ]);
        }
    }

    public function destroy(Journey $journey)
    {
        if ($journey->delete()) {
            return redirect()->route('admin.journeys.index')
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Trajet supprimé'
                ]);
        } else {
            return redirect()->back()->with('flash', [
                'status' => 'error',
                'message' => 'Une erreur est survenue'
            ]);
        }
    }
}
