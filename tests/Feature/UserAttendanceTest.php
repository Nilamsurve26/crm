<?php

namespace Tests\Feature;

use App\UserAttendance;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAttendanceTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->company = factory(\App\Company::class)->create([
            'name' => 'test'
        ]);
        $this->user->assignCompany($this->company->id);
        $this->headers['company-id'] = $this->company->id;

        factory(\App\UserAttendance::class)->create([
            'company_id'  =>  $this->company->id
        ]);

        $this->payload = [
            'user_id' => 1,
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'date' => 'date',
            'ticket_id' => 1,
        ];
    }


    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/user_attendances', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "ticket_id" =>  ["The ticket id field is required."],
                    "user_id" =>  ["The user id field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_user_attendance()
    {
        $this->disableEH();
        $this->json('post', '/api/user_attendances', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'user_id' => 1,
                    'latitude' => 'latitude',
                    'longitude' => 'longitude',
                    'date' => 'date',
                    'ticket_id' => 1,

                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'user_id',
                    'latitude',
                    'longitude',
                    'date',
                    'ticket_id',
                    'company_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_user_attendances()
    {
        $this->json('GET', '/api/user_attendances', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 => [
                        'user_id',
                        'latitude',
                        'longitude',
                        'date',
                        'ticket_id',
                    ]
                ]
            ]);
        $this->assertCount(1, UserAttendance::all());
    }

    /** @test */
    function show_single_user_attendance()
    {
        $this->disableEH();
        $this->json('get', "/api/user_attendances/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'user_id' => 1,
                    'latitude' => 'latitude',
                    'longitude' => 'longitude',
                    'date' => 'date',
                    'ticket_id' => 1,
                ]
            ]);
    }

    /** @test */
    function update_single_user_attendance()
    {
        $payload = [
            'user_id' => 1,
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'date' => 'date',
            'ticket_id' => 1,

        ];

        $this->json('patch', '/api/user_attendances/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'user_id' => 1,
                    'latitude' => 'latitude',
                    'longitude' => 'longitude',
                    'date' => 'date',
                    'ticket_id' => 1,
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'company_id',
                    'latitude',
                    'longitude',
                    'user_id',
                    'ticket_id',
                    'date',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
}
