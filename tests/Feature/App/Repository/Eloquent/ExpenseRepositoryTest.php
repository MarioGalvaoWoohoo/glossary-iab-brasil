<?php

namespace Tests\Feature\App\Repository\Eloquent;

use App\Models\Expense;
use App\Repository\Contracts\ExpenseRepositoryInterface;
use App\Repository\Eloquent\ExpenseRepository;
use App\Repository\Exceptions\NotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        $this->repository = new ExpenseRepository(new Expense());

        parent::setUp();
    }

    public function test_implements_interface()
    {
        $this->assertInstanceOf(
            ExpenseRepositoryInterface::class,
            $this->repository
        );
    }

    public function test_find_all_empty()
    {
        $response = $this->repository->findAll();

        $this->assertIsObject($response);
        $this->assertCount(0, $response);
    }

    public function test_find_all()
    {
        Expense::factory()->count(10)->create();

        $response = $this->repository->findAll();

        $this->assertCount(10, $response);
    }

    public function test_create()
    {
        $data = [
            'category' => 4,
            'date' => '2023-05-15 23:59:59',
            'value' => 25.0,
            'description' => 'healthcare for the week',
            'payment_method' => 3,
            'location' => 'Supermarket',
            'start_date' => '2023-05-15 23:59:59',
            'end_date' => '2023-06-15 23:59:59',
            'person_to_pay' => 'John Doe',
            'payment_status' => 1,
            'installments' => 5,
        ];

        $expense = Expense::factory()->create($data);

        $this->assertNotNull($expense);
        $this->assertInstanceOf(Expense::class, $expense);
        $this->assertDatabaseHas('expenses', [
            'category' => 4,
            'date' => '2023-05-15 23:59:59',
            'value' => 25.0,
            'description' => 'healthcare for the week',
            'payment_method' => 3,
            'location' => 'Supermarket',
            'start_date' => '2023-05-15 23:59:59',
            'end_date' => '2023-06-15 23:59:59',
            'person_to_pay' => 'John Doe',
            'payment_status' => 1,
            'installments' => 5,
        ]);
    }

    public function test_update()
    {
        $expense = Expense::factory()->create();

        $data = [
            'category' => 2,
            'description' => 'Groceries for the week - atualizado',
        ];

        $response = $this->repository->update($expense->id, $data);

        $this->assertNotNull($response);
        $this->assertIsObject($response);
        $this->assertDatabaseHas('expenses', [
            'category' => 2,
            'description' => 'Groceries for the week - atualizado',
        ]);
    }

    public function test_delete()
    {
        $expense = Expense::factory()->create();

        $deleted = $this->repository->delete($expense->id);

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('expenses', [
            'id' => $expense->id
        ]);
    }

    public function test_find()
    {
        $expense = Expense::factory()->create();

        $response = $this->repository->findById($expense->id);

        $this->assertIsObject($response);
    }

    // public function test_find_not_found()
    // {
    //     $this->expectException(NotFoundException::class);

    //     $this->repository->findById(9999);
    //     // $this->assertNull($response);
    // }
}
