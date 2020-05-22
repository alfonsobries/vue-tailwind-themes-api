<?php

namespace Tests\Feature;

use App\Models\CssClass;
use Illuminate\Contracts\Console\Kernel;
use Mockery;
use Tests\TestCase;

class FetchCssClassesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $command = Mockery::mock('\App\Console\Commands\FetchCssClasses[fetchCssFileContents]');

        $command->shouldReceive('fetchCssFileContents')->once()->andReturn($this->testCssFileContents());

        $this->app[Kernel::class]->registerCommand($command);
    }

    /** @test  */
    public function it_find_uncommon_css_classes()
    {
        $this->artisan('css:fetch');

        $classes = [
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
            'lg:hover:shadow-sm',
        ];

        collect($classes)->each(function ($className) {
            $this->assertTrue(CssClass::where('name', $className)->exists(), "$className not found!");
        });
    }

    private function testCssFileContents()
    {
        $file = base_path('tests/fixtures/example.css');

        return file_get_contents($file);
    }
}
