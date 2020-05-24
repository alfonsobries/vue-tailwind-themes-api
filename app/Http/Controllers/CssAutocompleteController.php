<?php

namespace App\Http\Controllers;

use App\Models\CssClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CssAutocompleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, ['q' => 'string|required', 'limit' => 'nullable|number']);

        $q = $request->input('q');
        $limit = $request->input('limit', 15);

        return CssClass::where('name', 'like', $q . '%')
            ->select('name')
            ->limit($limit)
            ->get()
            ->pluck('name');
    }
}
