<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return Plan::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|string',
            'period' => 'required|string',
            'description' => 'required|string',
            'highlighted' => 'required|boolean',
            'features' => 'required|array',
            'button_text' => 'required|string'
        ]);

        return Plan::create($validated);
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|string',
            'period' => 'required|string',
            'description' => 'required|string',
            'highlighted' => 'required|boolean',
            'features' => 'required|array',
            'button_text' => 'required|string'
        ]);

        $plan->update($validated);
        return $plan;
    }
}
