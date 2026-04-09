<?php

namespace Tests\Unit\Api\V1;

use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    public function test_user_resource_returns_the_expected_api_shape(): void
    {
        $createdAt = CarbonImmutable::parse('2026-01-15T10:00:00+00:00');
        $updatedAt = CarbonImmutable::parse('2026-01-16T12:30:00+00:00');
        $verifiedAt = CarbonImmutable::parse('2026-01-15T11:00:00+00:00');

        $user = new User();
        $user->forceFill([
            'id' => 42,
            'name' => 'Taylor Otwell',
            'email' => 'taylor@example.com',
            'email_verified_at' => $verifiedAt,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ]);

        $payload = (new UserResource($user))->toArray(new Request());

        $this->assertSame([
            'id' => 42,
            'name' => 'Taylor Otwell',
            'email' => 'taylor@example.com',
            'email_verified_at' => $verifiedAt->toAtomString(),
            'created_at' => $createdAt->toAtomString(),
            'updated_at' => $updatedAt->toAtomString(),
        ], $payload);
    }
}