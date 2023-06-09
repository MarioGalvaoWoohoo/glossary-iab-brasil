<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Repository\Contracts\ExpenseRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    protected $expenseRepository;

    public function __construct(ExpenseRepositoryInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function index()
    {
        // $users = collect($this->repository->findAll());
        $response = $this->expenseRepository->paginate();

        return ExpenseResource::collection(collect($response->items()))
                        ->additional([
                            'meta' => [
                                'total' => $response->total(),
                                'current_page' => $response->currentPage(),
                                'last_page' => $response->lastPage(),
                                'first_page' => $response->firstPage(),
                                'per_page' => $response->perPage(),
                            ]
                        ]);
    }

    public function show($id)
    {
        try {
            $expense = $this->expenseRepository->findById($id);

            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => new ExpenseResource($expense),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    public function listAll()
    {
        try {
            $expense =  $this->expenseRepository->findAll();

            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => ExpenseResource::collection($expense),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'category' => 'required|integer',
                'date' => 'required|date',
                'value' => 'nullable|max:50',
                'description' => 'required|min:3|max:150',
                'payment_method' => 'required|integer',
                'location' => 'required|min:3|max:150',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'person_to_pay' => 'required|min:3|max:150',
                'payment_status' => 'required|integer',
                'installments' => 'required|integer',
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $expense = $this->expenseRepository->create($request->all());

            return response()->json([
                'message' => 'Expense created successfully',
                'data' => new ExpenseResource($expense),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        try {

            $validatedData = Validator::make($request->all(), [
                'category' => 'required|integer',
                'date' => 'required|date',
                'value' => 'nullable|max:50',
                'description' => 'required|min:3|max:150',
                'payment_method' => 'required|integer',
                'location' => 'required|min:3|max:150',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'person_to_pay' => 'required|min:3|max:150',
                'payment_status' => 'required|integer',
                'installments' => 'required|integer',
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $expense = $this->expenseRepository->update($id, $request->all());

            return response()->json([
                'message' => 'Expense updated successfully!',
                'data' => new ExpenseResource($expense),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }

    }

    public function destroy(int $id)
    {
        try {
            $this->expenseRepository->delete($id);
            return response()->json([
                'message' => 'Expense deleted successfully!',
                'data' => [],
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }

    }

}
