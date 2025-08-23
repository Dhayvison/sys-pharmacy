<?php

namespace App\Repositories;

use App\Models\Branch;

class BranchRepository extends Repository
{
    public function __construct(Branch $branch)
    {
        parent::__construct($branch);
    }

    public function all()
    {
        return $this->model->orderBy('name')->get();
    }
}
