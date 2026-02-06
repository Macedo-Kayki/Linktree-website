<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linktreedado extends Model
{
    use HasFactory;
    
    protected $table = 'linktreedados';

    protected $fillable = [
        'linktree_id',
        'name_link',
        'url_link',
        'icon',
        'button_color'
    ];
}