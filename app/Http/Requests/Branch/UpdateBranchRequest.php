<?php

namespace App\Http\Requests\Branch;

use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'identifier' => ['sometimes', 'required', 'string', 'max:255', 'unique:branches,identifier,' . $this->branch->id],
            'cnpj' => ['sometimes', 'nullable', 'string', 'max:18', 'unique:branches,cnpj,' . $this->branch->id],
        ];
    }
}
