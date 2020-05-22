<?php

namespace Tests\Feature;

use App\Models\CssClass;
use Tests\TestCase;

class CssAutocompleteControllerTest extends TestCase
{
    /** @test */
    public function it_return_css_class_names_that_starts_with_the_query()
    {
        factory(CssClass::class)->createMany([
            ['name' => '-mt-12'],
            ['name' => 'lg:w-2/12'],
            ['name' => 'md:-translate-y-8'],
            ['name' => 'xl:placeholder-purple-200'],
            ['name' => 'lg:placeholder-yellow-500'],
        ]);

        $response = $this->getJson(route('cssautocomplete', ['q' => 'lg:']));
        $response->assertJson(['lg:w-2/12', 'lg:placeholder-yellow-500']);

        $response = $this->getJson(route('cssautocomplete', ['q' => '-']));
        $response->assertJson(['-mt-12']);

        $response = $this->getJson(route('cssautocomplete', ['q' => 'md:']));
        $response->assertJson(['md:-translate-y-8']);

        $response = $this->getJson(route('cssautocomplete', ['q' => 'w-2']));
        $response->assertJson([]);
    }
}
