<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Label extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'labels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'color',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'folder_name',
    ];

    /**
     * Get the images's label colors.
     */
    protected function folderName(): Attribute
    {
        return Attribute::make(
            get: fn () => sanitizeFileName(strtolower($this->name))
        );
    }

    /**
     * The images that belong to the Label
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_label', 'label_id', 'image_id');
    }

    /**
     * The images that belong to the Label
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function models(): BelongsToMany
    {
        return $this->belongsToMany(CnnModel::class, 'cnn_model_label', 'label_id', 'cnn_model_id');
    }
}
