<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CnnModel extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'base_model',
        'accuracy',
        'loss',
        'val_accuracy',
        'val_loss',
    ];

    /**
     * log the created updated, deleted & restored events.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'user_id',
                'name',
                'base_model',
                'accuracy',
                'loss',
                'val_accuracy',
                'val_loss',
                'created_at',
                'updated_at',
            ])
            ->dontSubmitEmptyLogs()
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->useLogName(__('CNN Models'))
            ->setDescriptionForEvent(fn(string $eventName) => __("CNN Model {$eventName}."));
    }

    /**
     * The labels that belong to the Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'cnn_model_label', 'cnn_model_id', 'label_id');
    }
}
