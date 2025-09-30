<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    // В tests/TestCase.php


    protected function actingAsApiUser($user = null)
    {
        $user = $user ?: User::factory()->create();

        $token = JWTAuth::fromUser($user);

        return $this->withHeaders([
            'Authorization' => "Bearer $token",
        ]);
    }
}
