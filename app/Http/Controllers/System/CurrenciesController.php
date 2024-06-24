<?php

namespace App\Http\Controllers\System;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrenciesController extends Controller
{
    public function __invoke(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'iqd' => 'required|numeric|min:-999999999999|max:999999999999',
            'irr' => 'required|numeric|min:-999999999999|max:999999999999',
            'try' => 'required|numeric|min:-999999999999|max:999999999999',
        ]);

        $currency->update($validated);

        return back();
    }
}
