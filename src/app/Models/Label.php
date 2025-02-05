<?php

namespace App\Models;

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
        return $this->belongsToMany(CNNModel::class, 'c_n_n_model_label', 'label_id', 'c_n_n_model_id');
    }
}
