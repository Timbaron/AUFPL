<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AufplSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_gameweek',
        'transfer_window_open',
        'squad_selection_open',
    ];
}
