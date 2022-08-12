<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ZipCodeTest extends TestCase
{
    /**
     * @test
     */
    public function can_return_data_from_a_given_zip_code()
    {
        $zipCode = '48496';

        $response = $this->getJson("/api/zip-codes/$zipCode");

        $response->assertStatus(200)
            ->assertJson(['zip_code' => $zipCode])
            ->assertJsonStructure([
                'zip_code',
                'locality',
                'federal_entity' => [
                    'key',
                    'name',
                    'code'
                ],
                'settlements' => [],
                'municipality' => [
                    'key',
                    'name',
                ],
            ]);
    }

    /**
     * @test
     */
    public function cannot_return_data_from_a_given_zip_code()
    {
        $zipCode = '3';

        $response = $this->getJson("/api/zip-codes/$zipCode");

        $response->assertStatus(404)
            ->assertJson(['message' => "No hay resultados para el código {$zipCode}"]);
    }
}
