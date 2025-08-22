<?php

namespace App\Models\Traits;

use App\Models\ModelHistory;
use Illuminate\Support\Facades\Auth;

trait HasModelHistory
{
    /**
     * Get the model history for the model.
     */
    public function histories()
    {
        return $this->morphMany(ModelHistory::class, 'model');
    }

    /**
     * Boot the trait and register event listeners for history.
     */
    protected static function bootHasModelHistory()
    {
        static::created(function ($model) {
            if ($model->keyType === 'int') {
                $model->histories()->create([
                    'action' => ModelHistory::ACTION_CREATED,
                    'changes' => $model->toArray(),
                    'user_id' => Auth::id(),
                ]);
            }
        });

        static::updated(function ($model) {
            if ($model->keyType === 'int') {
                $changes = $model->getChanges();
                unset($changes['updated_at']);
                if (!empty($changes)) {
                    $model->histories()->create([
                        'action' => ModelHistory::ACTION_UPDATED,
                        'changes' => $changes,
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        });

        static::deleted(function ($model) {
            if ($model->keyType === 'int') {
                $model->histories()->create([
                    'action' => ModelHistory::ACTION_DELETED,
                    'changes' => $model->toArray(),
                    'user_id' => Auth::id(),
                ]);
            }
        });
    }
}
