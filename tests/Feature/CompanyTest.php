<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    public function testsCompaniesAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'name' => 'Lorem',
            'parent' => null,
        ];

        $this->json('POST', '/api/companies', $payload, $headers)
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'name' => 'Lorem', 'parent' => null]);
    }

    public function testsCompaniesAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $company = factory(Company::class)->create([
            'name' => 'First Company',
            'parent' => null,
        ]);

        $payload = [
            'name' => 'First Company',
            'parent' => null,
        ];

        $response = $this->json('PUT', '/api/companies/' . $company->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'name' => 'First Company',
                'parent' => null,
            ]);
    }

    public function testsCompaniesAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $company = factory(Company::class)->create([
            'name' => 'First Company',
            'parent' => null,
        ]);

        $this->json('DELETE', '/api/companies/' . $company->id, [], $headers)
            ->assertStatus(204);
    }

    public function testCompaniesAreListedCorrectly()
    {
        factory(Company::class)->create([
            'name' => 'First Company',
            'parent' => null,
        ]);

        factory(Company::class)->create([
            'name' => 'Second Company',
            'parent' => null,
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/companies', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'title' => 'First Company', 'parent' => null ],
                [ 'title' => 'Second Company', 'parent' => null ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'parent', 'created_at', 'updated_at'],
            ]);
    }

}
