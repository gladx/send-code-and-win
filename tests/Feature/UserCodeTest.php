<?php

namespace Tests\Feature;

use App\Models\Code;
use App\Models\UserCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guest_user_can_submit_code_with_phone()
    {
        $userCode = UserCode::factory()->make();
        $response = $this->post('/api/user/code', ['code' => $userCode->getCode(), 'phone' => $userCode->phone]);

        $response->assertStatus(200);

        // Select winner
        $this->artisan('update-wins')->assertExitCode(0);

        $this->assertDatabaseHas('user_codes', ['phone' => $userCode->phone]);
    }

    /**
     * @test
     */
    public function guest_user_checks_win_status()
    {
        // create code
        $registerCode = Code::factory()->raw();
        $this->post('/api/code', $registerCode)->assertStatus(200);

        // User send code 
        $phone1 = '1234';
        $this->post('/api/user/code', ['code' => $registerCode["code"], 'phone' => $phone1])->assertStatus(200);

        // Select winner
        $this->artisan('update-wins')->assertExitCode(0);

        // check user win
        $code = $registerCode["code"];
        $this->get("/api/user/code/{$code}/{$phone1}")->assertStatus(200);
        
        $code = "WorngCode";
        $this->get("/api/user/code/{$code}/{$phone1}")->assertStatus(404);
    }

    /**
     * @test
     */
    public function just_first_k_users_win()
    {
        // create code
        $registerCode = Code::factory()->raw(['quantity' => 2]);
        $this->post('/api/code', $registerCode)->assertStatus(200);

        // User send code 
        $phone1 = '1234';
        $this->post('/api/user/code', ['code' => $registerCode["code"], 'phone' => $phone1])->assertStatus(200);
        $phone2 = '1235';
        $this->post('/api/user/code', ['code' => $registerCode["code"], 'phone' => $phone2])->assertStatus(200);
        $phone3 = '1236';
        $this->post('/api/user/code', ['code' => $registerCode["code"], 'phone' => $phone3])->assertStatus(200);

        // Select winner
        $this->artisan('update-wins')->assertExitCode(0);
        
        // check user win
        $code = $registerCode["code"];
        $this->get("/api/user/code/{$code}/{$phone1}")->assertStatus(200);
        $this->get("/api/user/code/{$code}/{$phone2}")->assertStatus(200);

        // check not win
        $this->get("/api/user/code/{$code}/{$phone3}")->assertStatus(404);
    }
}
