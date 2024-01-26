<?php

namespace Firdavs9512\LaravelLogger\Traits;

use Firdavs9512\LaravelLogger\Models\Log;

trait Logger
{
    public static function bootLoggable()
    {
        if (config('laravel-logger.log_events')['on_update']) {
            static::updating(function ($model) {
                $model->logChanges();
            });
        }

        if (config('laravel-logger.log_events')['on_create']) {
            static::created(function ($model) {
                $model->logCreated();
            });
        }

        if (config('laravel-logger.log_events')['on_delete']) {
            static::deleted(function ($model) {
                $model->logDeleted();
            });
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::bootLoggable();
    }

    public function logChanges()
    {
        $changes = $this->getDirty();

        if (!empty($changes)) {
            foreach ($changes as $attribute => $value) {
                Log::create([
                    'action' => 'updated',
                    'model' => static::class,
                    'model_id' => $this?->id,
                    'old_value' => [$attribute => $this->getOriginal($attribute)],
                    'new_value' => [$attribute => $value],
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'ip' => request()->ip(),
                ]);
            }
        }
    }

    public function logCreated()
    {
        $values = $this->getAttributes();

        if (!empty($values)) {
            Log::create([
                'action' => 'created',
                'model' => static::class,
                'model_id' => $this?->id,
                'old_value' => null,
                'new_value' => $values,
                'user_id' => auth()->check() ? auth()->id() : null,
                'ip' => request()->ip(),
            ]);
        }
    }

    public function logDeleted()
    {
        $values = $this->getAttributes();

        if (!empty($values)) {
            Log::create([
                'action' => 'deleted',
                'model' => static::class,
                'model_id' => $this?->id,
                'old_value' => $values,
                'new_value' => null,
                'user_id' => auth()->check() ? auth()->id() : null,
                'ip' => request()->ip(),
            ]);
        }
    }
}
