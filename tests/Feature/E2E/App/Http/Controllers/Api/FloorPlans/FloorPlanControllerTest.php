<?php

namespace Tests\Feature\E2E\App\Http\Controllers\Api\FloorPlans;

use Tests\TestCase;

class FloorPlanControllerTest extends TestCase
{
    CONST URL = '/api/floor_plan';

    #region dataProviders
    public function createDataProvider() : array
    {
        return [
            'ok_without_en_suite_without_garage' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => false,
                        'has_garage' => false,
                        'price' => 950,
                    ]
                ]
            ],
            'ok_with_en_suite_with_garage' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'en_suite' => true,
                    'has_garage' => true,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => true,
                        'has_garage' => true,
                        'price' => 950,
                    ]
                ]
            ],
            'ok_without_en_suite_without_garage' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'en_suite' => false,
                    'has_garage' => false,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => false,
                        'has_garage' => false,
                        'price' => 950,
                    ]
                ]
            ],
            'ok_with_en_suite_missing_garage' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'en_suite' => true,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => true,
                        'has_garage' => false,
                        'price' => 950,
                    ]
                ]
            ],
            'ok_missing_en_suite_with_garage' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'has_garage' => true,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => false,
                        'has_garage' => true,
                        'price' => 950,
                    ]
                ]
            ],
            'validation_required' => [
                'data' => [],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'name' => ['The name field is required.'],
                        'bedrooms' => ['The bedrooms field is required.'],
                        'price' => ['The price field is required.'],
                    ]
                ]
            ],
            'validation_nullable' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => false,
                        'has_garage' => false,
                        'price' => 950,
                    ]
                ]
            ],
            'validation_integer_1' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'bedrooms' => 'one',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'bedrooms' => ['The bedrooms must be an integer.'],
                    ]
                ]
            ],
            'validation_integer_2' => [
                'data' => [
                    'bedrooms' => 1.5,
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'bedrooms' => ['The bedrooms must be an integer.'],
                    ]
                ]
            ],
            'validation_numeric_1' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 'one',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'price' => ['The price must be a number.'],
                    ]
                ]
            ],
            'validation_numeric_2' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => false,
                        'has_garage' => false,
                        'price' => 950,
                    ]
                ]
            ],
            'validation_numeric_3' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950.89,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => false,
                        'has_garage' => false,
                        'price' => 950.89,
                    ]
                ]
            ],
            'validation_boolean_wrong' => [
                'data' => [
                    'en_suite' => 'not a bool',
                    'has_garage' => 'not a bool',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'en_suite' => ['The en suite field must be true or false.'],
                        'has_garage' => ['The has garage field must be true or false.'],
                    ]
                ]
            ],
            'validation_boolean_as_string_true' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'en_suite' => 'true',
                    'has_garage' => 'true',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'en_suite' => ['The en suite field must be true or false.'],
                        'has_garage' => ['The has garage field must be true or false.'],
                    ]
                ]
            ],
            'validation_boolean_as_string_false' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'en_suite' => 'false',
                    'has_garage' => 'false',
                ],
                'status' => 422,
                'json' => [
                    'errors' => [
                        'en_suite' => ['The en suite field must be true or false.'],
                        'has_garage' => ['The has garage field must be true or false.'],
                    ]
                ]
            ],
            'validation_boolean_as_1' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'en_suite' => 1,
                    'has_garage' => 1,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => true,
                        'has_garage' => true,
                        'price' => 950,
                    ]
                ]
            ],
            'validation_boolean_as_0' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'en_suite' => 0,
                    'has_garage' => 0,
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => false,
                        'has_garage' => false,
                        'price' => 950,
                    ]
                ]
            ],
            'validation_boolean_as_string_1' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'en_suite' => '1',
                    'has_garage' => '1',
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => true,
                        'has_garage' => true,
                        'price' => 950,
                    ]
                ]
            ],
            'validation_boolean_as_string_0' => [
                'data' => [
                    'name' => 'FP-01',
                    'bedrooms' => 1,
                    'price' => 950,
                    'en_suite' => '0',
                    'has_garage' => '0',
                ],
                'status' => 201,
                'json' => [
                    'message' => 'Floor Plan created.',
                    'floor_plan' => [
                        'id' => 1,
                        'name' => 'FP-01',
                        'bedrooms' => 1,
                        'en_suite' => false,
                        'has_garage' => false,
                        'price' => 950,
                    ]
                ]
            ],
        ];
    }
    #endregion

    /**
     * Test Create User
     * 
     * @dataProvider createDataProvider
     */
    public function testCreateUser($data, $status, $json)
    {
        $this->actingAs($this->userAdmin)
            ->postJson(self::URL, $data)
            ->assertStatus($status)
            ->assertJson($json);

        //Make sure user can log in
        if($status == 201) {
            $this->assertDatabaseHas('floor_plans', $json['floor_plan']);
        }
    }
}
