<?php

namespace App\Models;

use App\Models\Traits\HasModelHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes, HasModelHistory;

    protected $fillable = [
        'street',
        'number',
        'complement',
        'reference_point',
        'neighborhood',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'addressable_type',
        'addressable_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Get the parent addressable model (morph to).
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}
