<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_HOME = 'home_phone';
    public const TYPE_WORK = 'work_phone';
    public const TYPE_MOBILE = 'mobile_phone';
    public const TYPE_WHATSAPP = 'whatsapp';

    protected $table = 'phones';

    protected $fillable = [
        'country_code',
        'area_code',
        'number',
        'type',
    ];

    protected $hidden = [
        'phoneable_type',
        'phoneable_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the parent phoneable model (morph to).
     */
    public function phoneable()
    {
        return $this->morphTo();
    }
}
