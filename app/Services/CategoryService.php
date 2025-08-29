<?php

namespace App\Services;

use App\Models\Category;
use App\Models\DTO\CategoryDTO;
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
        return $deepSeekService->generateCategoryDescriptionByName($categoryName);
    }
}
