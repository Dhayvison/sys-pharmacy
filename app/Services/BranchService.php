<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\DTO\BranchDTO;
use App\Repositories\BranchRepository;

class BranchService
{
    protected $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function all()
    {
        return $this->branchRepository->all();
    }

    public function store(BranchDTO $branchData)
    {
        $branch = $this->branchRepository->create($branchData);

        return $branch;
    }

    public function update($id, BranchDTO $branchData)
    {
        $branch = $this->branchRepository->update($id, $branchData);

        return $branch;
    }

    public function destroy($id)
    {
        $branch = $this->branchRepository->delete($id);

        return $branch;
    }

    public function delete(Branch $branch)
    {
        return $this->branchRepository->deleteModel($branch);
    }
}
