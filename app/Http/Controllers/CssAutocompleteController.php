<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CssAutocompleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, ['q' => 'string|required']);

        $query = $request->input('q');

        $str = Http::get('https://unpkg.com/tailwindcss@^1.0/dist/tailwind.css')->body();

        $re = '/\.(-?[_a-zA-Z]+([_a-zA-Z0-9-\\\\\/s]|(\\\\:))*)[~\>\s:a-zA-Z\(\)]*\{/m';

        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
        
        $allCssClasses = collect($matches)->pluck(1)
            ->map(function ($className) {
                $className = trim($className);
                $className = str_replace('\:', ':', trim($className));
                $className = str_replace('\/', '/', trim($className));
                return $className;
            })->unique();


        // @TODO: Implement real searching
        $results = [$allCssClasses->first(function ($value) use ($query) {
            return $value === $query;
        })];
            

        return $results;
    }
}
