<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'investment_accounts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'amount',
        'open_rate'
    ];
}
