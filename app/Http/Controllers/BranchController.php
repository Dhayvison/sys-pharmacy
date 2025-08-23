<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;
use App\Models\Branch;
use App\Models\DTO\BranchDTO;
use App\Services\BranchService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class BranchController extends Controller
{
    public function index(BranchService $branchService): Response
    {
        $branches = $branchService->all();

        return Inertia::render('branches/index', ['branches' => $branches]);
    }

    public function store(StoreBranchRequest $request, BranchService $branchService)
    {
        $validated = $request->validated();

        try {
            $branchService->store(
                new BranchDTO(
                    $validated['name'],
                    $validated['identifier'],
                    $validated['cnpj'],
                )
            );
        } catch (\Throwable $th) {
            Log::error('Error creating branch: ' . $th->getMessage());
            throw ValidationException::withMessages([
                'name' => 'Não foi possível criar a filial. Verifique os dados cadastrados e tente novamente mais tarde.',
            ]);
        }

        return redirect()->back()->with('success', 'Filial registrada com sucesso!');
    }

    public function update(UpdateBranchRequest $request, Branch $branch, BranchService $branchService)
    {
        $validated = $request->validated();

        try {
            $branchService->update($branch->id, new BranchDTO(
                $validated['name'],
                $validated['identifier'],
                $validated['cnpj'],
            ));
        } catch (\Throwable $th) {
            Log::error('Error updating branch: ' . $th->getMessage());
            throw ValidationException::withMessages([
                'name' => 'Não foi possível atualizar a filial. Verifique os dados cadastrados e tente novamente mais tarde.',
            ]);
        }

        return redirect()->back()->with('success', 'Filial atualizada com sucesso!');
    }

    public function destroy(Branch $branch, BranchService $branchService)
    {
        $branchService->delete($branch);

        return redirect()->back()->with('success', 'Filial removida com sucesso!');
    }
}
