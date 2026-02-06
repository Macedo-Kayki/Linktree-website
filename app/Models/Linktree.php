<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linktree extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'title', 'description', 'icon', 'bg_color', 'bg_image', 'text_color'];

    public function dados()
    {
        return $this->hasMany(Linktreedado::class, 'linktree_id');
    }
}