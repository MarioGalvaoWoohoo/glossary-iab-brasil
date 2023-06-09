<?php

namespace App\Repository\Eloquent;

use App\Exceptions\CustomException;
use Carbon\Carbon;
use App\Models\Expense;
use App\Models\PaidInstallment;
use App\Repository\Contracts\PaidInstallmentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class PaidInstallmentRepository implements PaidInstallmentRepositoryInterface
{
    protected $model;

    public function __construct(PaidInstallment $paidInstallment)
    {
        $this->model = $paidInstallment;
    }

    public function customExceptionFindIdNotFound(): void
    {
        throw new CustomException('Não existe despesa para o ID informado', 404);
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
