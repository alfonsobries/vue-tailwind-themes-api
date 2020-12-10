<?php

namespace App\Console\Commands;

use App\Models\CssClass;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class FetchCssClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'css:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the list of CSS Classes';

    protected function fetchCssFileContents()
    {
        return Http::get('https://unpkg.com/tailwindcss@^2.0/dist/tailwind.css')->body();
    }

    protected function extractCssClasses()
    {
        $css = $this->fetchCssFileContents();

        $re = '/\.(-?[_a-zA-Z]+([_a-zA-Z0-9-\s]|(\\\\:)|(\\\\\/))*)[~\>\s:a-zA-Z\(\)]*\{/m';

        preg_match_all($re, $css, $matches, PREG_SET_ORDER, 0);

        return collect($matches)->pluck(1)
            ->map(function ($className) {
                $className = trim($className);
                $className = str_replace('\:', ':', trim($className));
                $className = str_replace('\/', '/', trim($className));

                return $className;
            })->unique();
    }

    protected function storeClasses(Collection $cssClasses)
    {
        $ids = $cssClasses->map(function ($className) {
            $existingClass = CssClass::where('name', $className)->select('id')->first();
            if (! empty($existingClass->id)) {
                return $existingClass->id;
            }

            return CssClass::create(['name' =>$className])->id;
        });

        CssClass::whereNotIn('id', $ids)->delete();

        return $ids->count();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allCssClasses = $this->extractCssClasses();

        if ($allCssClasses->count()) {
            $count = $this->storeClasses($allCssClasses);
        }

        $this->line($count.' classes fetched');
    }
}
