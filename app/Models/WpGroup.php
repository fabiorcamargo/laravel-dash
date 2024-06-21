<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'wp_group_category_id',
        'cademi_code',
        'name',
        'description',
        'link',
        'inicio',
        'fim',
    ];

    /**
     * Get the user that owns 
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // Definição do relacionamento
    public function wpGroupCategory()
    {
        return $this->belongsTo(WpGroupCategory::class, 'wp_group_category_id');
    }
}
