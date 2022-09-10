<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'owner',
        'manager',
    ];

    public function players(){
        return $this->hasMany(Player::class,'club_id', 'id');
    }
}
