<?php

namespace App\Models;

use App\Models\Traits\HasModelHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Branch extends Model
{
    use HasFactory, SoftDeletes, HasModelHistory;

    protected $fillable = [
        'name',
        'identifier',
        'cnpj',
    ];

    public static function generateIdentifier($name)
    {
        return Str::slug($name, '');
    }
}
