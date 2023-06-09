<?php

namespace App\Repository\Eloquent;

use App\Exceptions\CustomException;
use Carbon\Carbon;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Model;
use App\Repository\Contracts\ExpenseRepositoryInterface;
use App\Repository\Contracts\PaginationInterface;
use App\Repository\Presenters\PaginationPresenter;
use Illuminate\Validation\ValidationException;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    protected $model;

    public function __construct(Expense $expense)
    {
        $this->model = $expense;
    }

    public function customExceptionFindIdNotFound(): void
    {
        throw new CustomException('Não existe despesa para o ID informado', 404);
    }

    public function paginate(int $page = 1): PaginationInterface
    {
        return new PaginationPresenter($this->model->paginate());
    }

    public function findAll(): object
    {
        return $this->model->all();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?Model
    {
        $expense = $this->model->find($id);

        if (!$expense) {
            $this->customExceptionFindIdNotFound();
        }

        return $expense;
    }

    public function update(int $id, array $data): Model
    {
        $expense = $this->model->find($id);

        if (!$expense) {
            $this->customExceptionFindIdNotFound();
        }

        $expense->fill($data);
        $expense->save();

        return $expense;
    }

    public function delete(int $id): bool
    {
        $expense = $this->model->find($id);

        if (!$expense) {
            $this->customExceptionFindIdNotFound();
        }

        return $this->model->find($id)->delete();
    }

}
