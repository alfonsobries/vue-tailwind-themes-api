<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CssAutocompleteControllerTest extends TestCase
{
    /** @test  */
    public function it_find_uncommon_css_classes()
    {
        $classses = collect([
            '-mt-12',
            'w-1/12',
            'placeholder-blue-200',
            'sm:-m-12',
            'md:-translate-y-8',
            'lg:hover:-translate-x-40',
            'lg:placeholder-yellow-500',
            'lg:w-2/12',
            '-translate-x-1/2',
            'xl:placeholder-purple-200',
        ]);

        // @TODO: Mock css file
        
        $classses->each(function ($className) {
            $data = [
                'q' => $className
            ];
            
            $response = $this
                ->getJson(route('cssautocomplete', $data))
                ->assertSuccessful();
            
            $this->assertContains($className, $response->json());
        });
    }
}
