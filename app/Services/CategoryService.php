<?php

namespace App\Services;

use App\Models\Category;
use App\Models\DTO\CategoryDTO;
use App\Models\DTO\PromptDTO;
use App\Repositories\CategoryRepository;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function all()
    {
        return $this->categoryRepository->all();
    }

    public function store(CategoryDTO $categoryData)
    {
        return $this->categoryRepository->create($categoryData);
    }

    public function update($id, CategoryDTO $categoryData)
    {
        return $this->categoryRepository->update($id, $categoryData);
    }

    public function destroy($id)
    {
        return $this->categoryRepository->delete($id);
    }

    public function delete(Category $category)
    {
        return $this->categoryRepository->deleteModel($category);
    }

    public function suggestDescription(string $categoryName)
    {
        $deepSeekService = new DeepSeekService();

        $prompt = new PromptDTO(
            persona: "Você é um especialista em publicidade e marketing digital muito criativo.",
            objective: "Gere uma frase promocional para descrição da categoria \"$categoryName\" de um site farmacéutico.",
            context: "A descrição será usada na área de vendas do site, logo abaixo do nome da categoria.",
            tone: "Use um tom profissional.",
            format: "A frase deve ser curta e de fácil leitura."
        );

        return $deepSeekService->generate($prompt, 1.5);
    }
}
