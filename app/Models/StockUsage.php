<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\Department;
use App\Models\StockConditionLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockUsage extends Model
{
    use HasFactory;

    protected $table    =   'stock_usages';
    protected $guarded  =   ['id'];

    public function stock():BelongsTo
    {
        return $this->belongsTo(Stock::class,'stock_id');
    }

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class,'department_id');
    }

    public function conditionLogs():HasMany
    {
        return $this->hasMany(StockConditionLog::class);
    }
}
