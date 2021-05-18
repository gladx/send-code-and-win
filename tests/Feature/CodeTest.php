<?php

namespace Tests\Feature;

use App\Models\Code;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_define_new_code()
    {
        $this->withoutExceptionHandling();
        $code = Code::factory()->raw();
        $response = $this->post('/api/code', $code);

        $response->assertStatus(200);

        $this->assertDatabaseHas('codes', $code);
    }
}
