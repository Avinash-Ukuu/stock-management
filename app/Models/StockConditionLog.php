<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\StockUsage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockConditionLog extends Model
{
    use HasFactory;

    protected $guarded  =   ['id'];

    public function stock():BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function stockUsage():BelongsTo
    {
        return $this->belongsTo(StockUsage::class);
    }

}
