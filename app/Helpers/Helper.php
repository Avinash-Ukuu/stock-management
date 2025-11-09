<?php

use App\Http\Controllers\cms\StockLogController;

if (!function_exists("saveStockLogs")) {
    function saveStockLogs($data)
    {
        $stockLogs   =   new StockLogController();
        $stockLogs->saveStockLogs($data);
    }
}
