<?php

namespace Tests\Feature\Api;

use App\Models\Expense;
use Illuminate\Http\Response;
use Tests\TestCase;

class ExpenseApiTest extends TestCase
{
    protected string $endpoint = '/api/expenses';

    /**
     * @dataProvider dataProviderPagination
     */
    public function test_paginate(
        int $total,
        int $page = 1,
        int $totalPage = 15
    ) {
        Expense::factory()->count($total)->create();

        $response = $this->getJson("{$this->endpoint}?page={$page}");

        $response->assertOk();
        $response->assertJsonCount($totalPage, 'data');
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page'
            ],
            'data' => [
                '*' => [
                    'category',
                    'date',
                    'value',
                    'description',
                    'payment_method',
                    'location',
                    'start_date',
                    'end_date',
                    'person_to_pay',
                    'payment_status',
                    'installments',
                ]
            ]
        ]);
        $response->assertJsonFragment(['total' => $total]);
        $response->assertJsonFragment(['current_page' => $page]);
    }

    public function dataProviderPagination(): array
    {
        return [
            'test total paginate empty' => ['total' => 0, 'page' => 1, 'totalPage' => 0],
            'test total 40 expenses page one' => ['total' => 40, 'page' => 1, 'totalPage' => 15],
            'test total 20 expenses page two' => ['total' => 20, 'page' => 2, 'totalPage' => 5],
            'test total 100 expenses page two' => ['total' => 100, 'page' => 2, 'totalPage' => 15],
        ];
    }

    /**
     * @dataProvider dataProviderCreateExpense
     */
    public function test_create(
        array $payload,
        int $statusCode,
        array $structureResponse
    ) {
        $response = $this->postJson($this->endpoint, $payload);
        // $response->assertCreated();
        $response->assertStatus($statusCode);
        $response->assertJsonStructure($structureResponse);
    }

    public function dataProviderCreateExpense(): array
    {
        return [
            'test created' => [
                'payload' => [
                    'date' => '2023-05-01',
                    'category' => 2,
                    'value' => 150.02,
                    'description' => 'Descrição fake',
                    'location' => 'Cidade fake',
                    'start_date' => '2023-05-01',
                    'end_date' => '2023-08-01',
                    'person_to_pay' => 'Mario George',
                    'payment_method' => 2,
                    'payment_status' => 2,
                    'installments' => 1,
                ],
                'statusCode' => Response::HTTP_CREATED,
                'structureResponse' => [
                    'data' => [
                        'id',
                        'category',
                        'date',
                        'value',
                        'description',
                        'payment_method',
                        'location',
                        'start_date',
                        'end_date',
                        'person_to_pay',
                        'payment_status',
                        'installments',
                        'paid_installments',
                    ]
                ]
            ]
        ];
    }

    public function test_find()
    {
        $expense = Expense::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$expense->id}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'category',
                'date',
                'value',
                'description',
                'payment_method',
                'location',
                'start_date',
                'end_date',
                'person_to_pay',
                'payment_status',
                'installments',
            ]
        ]);
    }

    public function test_find_not_found()
    {
        $response = $this->getJson("{$this->endpoint}/9999");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider providerExpenseUpdate
     */
    public function test_update(array $payload, int $statusCode)
    {
        $expense = Expense::factory()->create();

        $response = $this->putJson("{$this->endpoint}/{$expense->id}", $payload);
        $response->assertStatus($statusCode);
    }

    public function providerExpenseUpdate(): array
    {
        return [
            'test update ok' => [
                'payload' => [
                    'date' => '2024-05-01',
                    'category' => 2,
                    'value' => 150.02,
                    'description' => 'Descrição fake',
                    'location' => 'Cidade fake',
                    'start_date' => '2024-05-01',
                    'end_date' => '2024-08-01',
                    'person_to_pay' => 'Mario George',
                    'payment_method' => 2,
                    'payment_status' => 2,
                    'installments' => 1,
                ],
                'statusCode' => Response::HTTP_OK
            ],
            'test update empty payload' => [
                'payload' => [],
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY
            ],
        ];
    }

    public function test_update_not_found()
    {
        $response = $this->putJson("{$this->endpoint}/9999", [
            'date' => '2024-05-01',
            'category' => 2,
            'value' => 150.02,
            'description' => 'Descrição fake',
            'location' => 'Cidade fake',
            'start_date' => '2024-05-01',
            'end_date' => '2024-08-01',
            'person_to_pay' => 'Mario George',
            'payment_method' => 2,
            'payment_status' => 2,
            'installments' => 1,
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete_not_found()
    {
        $response = $this->deleteJson("{$this->endpoint}/9999");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete()
    {
        $expense = Expense::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$expense->id}");
        $response->assertStatus(Response::HTTP_OK);
    }
}
