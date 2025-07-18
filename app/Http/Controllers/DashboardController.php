<?php

namespace App\Http\Controllers;

use App\Models\{Company, Division, Level, Gender, EmployeePeriod};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('index', [
            'companies' => Company::all(),
            'divisions' => Division::all(),
            'levels'    => Level::all(),
            'genders'   => Gender::all(),
        ]);
    }

    public function getData(Request $request)
    {
        $query = EmployeePeriod::query();

        if ($request->company_id) {
            $query->where('company_id', $request->company_id);
        }
        if ($request->division_id) {
            $query->where('division_id', $request->division_id);
        }
        if ($request->level_id) {
            $query->where('level_id', $request->level_id);
        }
        if ($request->gender_id) {
            $query->where('gender_id', $request->gender_id);
        }

        $data = $query->selectRaw('period, COUNT(*) as total')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get()
                    ->map(function ($item) {
                        $item->period = substr($item->period, 0, 4) . '-' . substr($item->period, 4, 2);
                        return $item;
                    });

        return response()->json($data);
    }
}

