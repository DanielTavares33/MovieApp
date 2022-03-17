<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ViewMoviesTest extends TestCase
{
    /**
     * @test
     * A basic test example.
     *
     * @return void
     */
    public function the_main_page_shows_correct_info()
    {
        Http::fake();
        
        $response = $this->get(route('movies.index'));

        $response->assertSuccessful();
    }
}
