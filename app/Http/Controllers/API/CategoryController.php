<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function suggestDescription(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $description = $this->service->suggestDescription($validated['name']);

        return response()->json([
            'message' => "Descrição gerada com sucesso",
            'data' => [
                'description' => $description,
            ]
        ]);
    }
}
