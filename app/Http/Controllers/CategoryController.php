<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\DTO\CategoryDTO;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $categories = $this->service->all();

        return Inertia::render('shopping/categories', ['categories' => $categories]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->service->store(
                new CategoryDTO(
                    $validated['name'],
                    $validated['description']
                )
            );
        } catch (\Throwable $th) {
            Log::error('Error creating category: ' . $th->getMessage());
            throw ValidationException::withMessages([
                'name' => 'Não foi possível criar a categoria. Verifique os dados cadastrados e tente novamente mais tarde.',
            ]);
        }

        return redirect()->back()->with('success', 'Categoria registrada com sucesso!');
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        try {
            $this->service->update($category->id, new CategoryDTO(
                $validated['name'],
                $validated['description']
            ));
        } catch (\Throwable $th) {
            Log::error('Error updating category: ' . $th->getMessage());
            throw ValidationException::withMessages([
                'name' => 'Não foi possível atualizar a categoria. Verifique os dados cadastrados e tente novamente mais tarde.',
            ]);
        }

        return redirect()->back()->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Category $category)
    {
        $this->service->delete($category);

        return redirect()->back()->with('success', 'Categoria removida com sucesso!');
    }

    public function suggestDescription(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $description = $this->service->suggestDescription($validated['name']);

        return redirect()->back()->with([
            'message' => "Descrição gerada com sucesso",
            'data' => [
                'description' => $description,
            ]
        ]);
    }
}
