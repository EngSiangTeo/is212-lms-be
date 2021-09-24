<?php

namespace Tests\Feature\App\Http\Controllers\Api\v1\Web\Account\Auction\Login\LoginApiController;

use Artisan;
use Tests\TestCase;
use App\Modules\Account\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginByEmailTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test that existing LMS tokens will be revoked
     *
     * @return void
     */
    public function test_existing_lms_tokens_will_be_revoked()
    {
        // NOTE: need to run passport install to generate token
        Artisan::call('passport:install');

        $user = User::Create([
            'email' => 'engsiang@onestop.com',
            'name' => 'eng siang',
            'password' => 'testing1234',
            'role' => 'Learner'
        ]);

        $payload = [
            'email' => 'engsiang@onestop.com',
            'name' => 'eng siang',
            'password' => 'testing1234',
            'role' => 'Learner'
        ];

        $appName = 'LMS';
        $token1 = $user->createToken($appName);
        $token2 = $user->createToken($appName);

        $otherAppName = 'other-app-name';
        $token3 = $user->createToken($otherAppName);

        $this
            ->json('POST', '/api/loginByEmail', $payload)
            ->assertOk();

        $this
            ->assertDatabaseHas('oauth_access_tokens', [
                'user_id' => $user->id,
                'id' => $token1->token->id,
                'name' => $appName,
                'revoked' => true
            ])
            ->assertDatabaseHas('oauth_access_tokens', [
                'user_id' => $user->id,
                'id' => $token2->token->id,
                'name' => $appName,
                'revoked' => true
            ])
            ->assertDatabaseHas('oauth_access_tokens', [
                'user_id' => $user->id,
                'id' => $token3->token->id,
                'name' => $otherAppName,
                'revoked' => false
            ]);
    }
}