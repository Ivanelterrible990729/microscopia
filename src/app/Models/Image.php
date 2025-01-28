<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Image extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->fit(Fit::Contain, 224, 224)
            ->nonQueued();
    }

    /**
     * Get the images's label colors.
     */
    protected function labelsColor(): Attribute
    {
        return Attribute::make(
            get: fn () => count($this->labels) > 1
                ? "background-image: linear-gradient(to right, " . implode(', ', $this->labels->pluck('color')->toArray()) . ");"
                : "background-color: " . $this->labels?->first()?->color ?? '' .";"
        );
    }

    /**
     * Get the images's label names.
     */
    protected function labelsDesc(): Attribute
    {
        return Attribute::make(
            get: fn () => count($this->labels) > 0
            ? implode(', ', $this->labels->pluck('name')->toArray())
            : 'Sin etiqueta'
        );
    }

    /**
     * Get the user that owns the Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * The labels that belong to the Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'image_label', 'image_id', 'label_id');
    }
}
