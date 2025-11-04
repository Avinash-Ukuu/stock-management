<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockItem extends Model
{
    use HasFactory;

    protected $table    = 'stock_items';
    protected $guarded  = ['id'];

    public function stock():BelongsTo
    {
        return $this->belongsTo(Stock::class,'stock_id');
    }
}
