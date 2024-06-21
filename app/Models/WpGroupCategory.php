<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WpGroupCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img'
    ];

    // Definição do relacionamento
    public function wpGroups()
    {
        return $this->hasMany(WpGroup::class, 'wp_group_category_id');
    }
}
