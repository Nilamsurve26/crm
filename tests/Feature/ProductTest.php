<?php

namespace Tests\Feature;

use App\Product;
use App\ProductIssue;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
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

        factory(\App\Product::class)->create([
            'company_id'  =>  $this->company->id,
            'created_by_id' => 1,
            'imagepath_1' => 'imagepath_1',
            'imagepath_2' => 'imagepath_2',
            'imagepath_3' => 'imagepath_3',
            'imagepath_4' =>  'imagepath_4',
            'name' => 'name',
            'short_description' => 'short_description',
            'description' => 'description',
            'brand_id' => 1,
            'barcode' => 'barcode',
        ]);

        $this->payload = [
            'created_by_id' => 1,
            'imagepath_1' => 'imagepath_1',
            'imagepath_2' => 'imagepath_2',
            'imagepath_3' => 'imagepath_3',
            'imagepath_4' =>  'imagepath_4',
            'name' => 'name',
            'short_description' => 'short_description',
            'description' => 'description',
            'brand_id' => 1,
            'barcode' => 'barcode',
            'product_issues' => [
                0 => [
                    'product_id' => 1,
                    'description' => 'description',
                    'name' => 'name'
                ]
            ]
        ];
    }


    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/products', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    'imagepath_1'        =>  ["The imagepath 1 field is required."],
                    'name' =>  ["The name field is required."],
                    'short_description' =>  ["The short description field is required."],
                    'barcode' =>  ["The barcode field is required."],

                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_product()
    {
        $this->disableEH();
        $this->json('post', '/api/products', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'created_by_id' => 1,
                    'imagepath_1' => 'imagepath_1',
                    'imagepath_2' => 'imagepath_2',
                    'imagepath_3' => 'imagepath_3',
                    'imagepath_4' =>  'imagepath_4',
                    'name' => 'name',
                    'short_description' => 'short_description',
                    'description' => 'description',
                    'brand_id' => 1,
                    'barcode' => 'barcode',
                    'product_issues' => [
                        0 => [
                            'product_id' => '2',
                            'description' => 'description',
                            'name' => 'name'
                        ]
                    ]

                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'created_by_id',
                    'imagepath_1',
                    'imagepath_2',
                    'imagepath_3',
                    'imagepath_4',
                    'name',
                    'short_description',
                    'description',
                    'brand_id',
                    'barcode',


                    'company_id',
                    'updated_at',
                    'created_at',
                    'id',
                    'product_issues',
                ]
            ]);
    }

    /** @test */
    function list_of_products()
    {

        $this->json('GET', '/api/products', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 => [
                        'created_by_id',
                        'imagepath_1',
                        'imagepath_2',
                        'imagepath_3',
                        'imagepath_4',
                        'name',
                        'short_description',
                        'description',
                        'brand_id',
                        'barcode',
                    ]
                ]
            ]);
        $this->assertCount(2, Product::all());
    }

    /** @test */
    function show_single_product()
    {
        $this->disableEH();
        $this->json('get', "/api/products/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'created_by_id' => 1,
                    'imagepath_1' => 'imagepath_1',
                    'imagepath_2' => 'imagepath_2',
                    'imagepath_3' => 'imagepath_3',
                    'imagepath_4' =>  'imagepath_4',
                    'name' => 'name',
                    'short_description' => 'short_description',
                    'description' => 'description',
                    'brand_id' => 1,
                    'barcode' => 'barcode',

                ]
            ]);
    }

    /** @test */
    function update_single_product()
    {
        $payload = [
            'created_by_id' => 1,
            'imagepath_1' => 'imagepath_1',
            'imagepath_2' => 'imagepath_2',
            'imagepath_3' => 'imagepath_3',
            'imagepath_4' =>  'imagepath_4',
            'name' => 'name',
            'short_description' => 'short_description',
            'description' => 'description',
            'brand_id' => 1,
            'barcode' => 'barcode',

        ];

        $this->json('patch', '/api/products/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'created_by_id' => 1,
                    'imagepath_1' => 'imagepath_1',
                    'imagepath_2' => 'imagepath_2',
                    'imagepath_3' => 'imagepath_3',
                    'imagepath_4' =>  'imagepath_4',
                    'name' => 'name',
                    'short_description' => 'short_description',
                    'description' => 'description',
                    'brand_id' => 1,
                    'barcode' => 'barcode',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'company_id',
                    'created_by_id',
                    'imagepath_1',
                    'imagepath_2',
                    'imagepath_3',
                    'imagepath_4',
                    'name',
                    'short_description',
                    'description',
                    'brand_id',
                    'barcode',
                    'is_active',
                    'is_deleted',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
    /** @test */
    function update_single_product_nested()
    {
        $product = factory(Product::class)->create([
            'company_id' =>  $this->company->id,
            'created_by_id' => 1,
            'imagepath_1' => 'imagepath_1',
            'imagepath_2' => 'imagepath_2',
            'imagepath_3' => 'imagepath_3',
            'imagepath_4' =>  'imagepath_4',
            'name' => 'name',
            'short_description' => 'short_description',
            'description' => 'description',
            'brand_id' => 1,
            'barcode' => 'barcode',
        ]);
        $productIssue = factory(ProductIssue::class)->create([
            'product_id' =>  $product->id
        ]);
        // Old Edit + No Delete + 1 New
        $payload = [
            'id'          =>  $product->id,
            'created_by_id' => 1,
            'imagepath_1' => 'imagepath_1',
            'imagepath_2' => 'imagepath_2',
            'imagepath_3' => 'imagepath_3',
            'imagepath_4' =>  'imagepath_4',
            'name' => 'name',
            'short_description' => 'short_description',
            'description' => 'description',
            'brand_id' => 1,
            'barcode' => 'barcode',
            'product_issues' =>  [
                0 =>  [
                    'id'        =>  $productIssue->id,
                    'product_id' => 1,
                    'description' => 'description',
                    'name' => 'name'
                ],
                1 =>  [
                    'product_id' => 1,
                    'description' => 'description',
                    'name' => 'name'
                ]
            ],
        ];
        $this->json('patch', '/api/products/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'id'          =>  $product->id,
                    'created_by_id' => 1,
                    'imagepath_1' => 'imagepath_1',
                    'imagepath_2' => 'imagepath_2',
                    'imagepath_3' => 'imagepath_3',
                    'imagepath_4' =>  'imagepath_4',
                    'name' => 'name',
                    'short_description' => 'short_description',
                    'description' => 'description',
                    'brand_id' => 1,
                    'barcode' => 'barcode',
                    'product_issues' =>  [
                        0 =>  [
                            'id'        =>  $productIssue->id,
                            'product_id' => 1,
                            'description' => 'description',
                            'name' => 'name'
                        ],
                        1 =>  [
                            'product_id' => 1,
                            'description' => 'description',
                            'name' => 'name'
                        ]
                    ],
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'created_by_id',
                    'imagepath_1',
                    'imagepath_2',
                    'imagepath_3',
                    'imagepath_4',
                    'name',
                    'short_description',
                    'description',
                    'brand_id',
                    'barcode',
                    'company_id',
                    'created_at',
                    'updated_at',
                    'product_issues',
                    
                ]
            ]);

        // 1 Delete + 1 New
        $payload = [
            'id'          =>  $product->id,
            'created_by_id' => 1,
            'imagepath_1' => 'imagepath_1',
            'imagepath_2' => 'imagepath_2',
            'imagepath_3' => 'imagepath_3',
            'imagepath_4' =>  'imagepath_4',
            'name' => 'name',
            'short_description' => 'short_description',
            'description' => 'description',
            'brand_id' => 1,
            'barcode' => 'barcode',
            'product_issues' =>  [
                0 =>  [
                    'id'        =>  $productIssue->id,
                    'product_id' => 1,
                    'description' => 'description',
                    'name' => 'name'
                ]
            ],
        ];
        $this->json('post', '/api/products', $payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'    =>  [
                    'id'          =>  $product->id,
                    'created_by_id' => 1,
                    'imagepath_1' => 'imagepath_1',
                    'imagepath_2' => 'imagepath_2',
                    'imagepath_3' => 'imagepath_3',
                    'imagepath_4' =>  'imagepath_4',
                    'name' => 'name',
                    'short_description' => 'short_description',
                    'description' => 'description',
                    'brand_id' => 1,
                    'barcode' => 'barcode',
                    'product_issues' =>  [
                        0 =>  [
                            'id'        =>  $productIssue->id,
                            'product_id' => 1,
                            'description' => 'description',
                            'name' => 'name'
                        ]
                    ],
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'created_by_id',
                    'imagepath_1',
                    'imagepath_2',
                    'imagepath_3',
                    'imagepath_4',
                    'name',
                    'short_description',
                    'description',
                    'brand_id',
                    'barcode',
                    'company_id',
                    'created_at',
                    'updated_at',
                    'product_issues',

                ]
            ]);
    }

    /** @test */
    function delete_product()
    {
        $this->json('delete', '/api/products/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(1, Product::all());
    }
}
