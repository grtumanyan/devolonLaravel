<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StationTest extends TestCase
{
    public function testsStationsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'name' => 'station',
            'latitude' => '40.8844521',
            'longitude' => '41.668854',
            'company' => 1
        ];

        $this->json('POST', '/api/stations', $payload, $headers)
            ->assertStatus(200)
            ->assertJson(['id' => 1,
                'name' => 'station',
                'latitude' => '40.8844521',
                'longitude' => '41.668854',
                'company' => 1]);
    }

    public function testsStationsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $station = factory(Station::class)->create([
            'name' => 'station',
            'latitude' => '40.8844521',
            'longitude' => '41.668854',
            'company' => 1
        ]);

        $payload = [
            'name' => 'station',
            'latitude' => '40.8844521',
            'longitude' => '41.668854',
            'company' => 1
        ];

        $response = $this->json('PUT', '/api/stations/' . $station->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'name' => 'station',
                'latitude' => '40.8844521',
                'longitude' => '41.668854',
                'company' => 1
            ]);
    }

    public function testsStationsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $station = factory(Station::class)->create([
            'name' => 'station',
            'latitude' => '40.8844521',
            'longitude' => '41.668854',
            'company' => 1
        ]);

        $this->json('DELETE', '/api/stations/' . $station->id, [], $headers)
            ->assertStatus(204);
    }

    public function testStationsAreListedCorrectly()
    {
        factory(Station::class)->create([
            'name' => 'station1',
            'latitude' => '40.8844521',
            'longitude' => '41.668854',
            'company' => 1
        ]);

        factory(Station::class)->create([
            'name' => 'station2',
            'latitude' => '40.8844521',
            'longitude' => '41.668854',
            'company' => 1
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/stations', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                ['name' => 'station1',
                    'latitude' => '40.8844521',
                    'longitude' => '41.668854',
                    'company' => 1 ],
                [ 'name' => 'station2',
                    'latitude' => '40.8844521',
                    'longitude' => '41.668854',
                    'company' => 1 ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'latitude', 'longitude', 'company', 'created_at', 'updated_at'],
            ]);
    }

}
