<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rate;

class RateController extends Controller
{
    public function index()
    {
        $rate = Rate::latest('id')->first();
        return view('dashboard.rate', compact('rate'));
    }

    public function update(Request $request)
    {
        $rate = Rate::latest('id')->first();
        
        $validated = $request->validate([
            'us_rate' => 'required|numeric',
            'euro_rate' => 'required|numeric',
            'svat' => 'required|numeric',
            'vat1' => 'required|numeric',
            'service_charge' => 'required|numeric'
        ]);

        if ($rate) {
            $rate->update($validated);
        } else {
            Rate::create($validated);
        }

        return redirect()->route('rate.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Rate updated successfully!'
        ]);
    }
}
