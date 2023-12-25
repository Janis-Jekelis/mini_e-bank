<?php

namespace App\Models;

use App\Models\accounts\InvestmentAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'amount',
        'open_rate'
    ];
    public function investAcc():BelongsTo
    {
        return $this->belongsTo(InvestmentAccount::class);
    }
}
