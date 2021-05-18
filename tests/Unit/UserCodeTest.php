<?php

namespace Tests\Unit;

use App\Models\Code;
use App\Models\UserCode;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCodeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_code()
    {
        $userCode = UserCode::factory()->create();

        $this->assertInstanceOf(Code::class, $userCode->code);
    }

    /** @test */
    public function it_define_get_code_method()
    {
        $code = Code::factory()->create();
        $userCode = UserCode::factory()->create(['code_id' => $code->id]);

        $this->assertEquals($code->code, $userCode->getCode());
    }
}
