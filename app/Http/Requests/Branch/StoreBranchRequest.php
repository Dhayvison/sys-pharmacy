<?php

namespace App\Http\Requests\Branch;

use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'identifier' => Branch::generateIdentifier($this->name),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'identifier' => ['required', 'string', 'max:255', 'unique:branches,identifier'],
            'cnpj' => ['nullable', 'string', 'max:18', 'unique:branches,cnpj'],
        ];
    }
}
