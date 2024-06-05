<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class main_stock_balance extends Model
{
    use HasFactory;
    protected $table = 'main_stock_balance';
    public static function main_stock_balance($value = [], $ret)
    {
        $return = [];

        if ($ret == '') {
            $return = main_stock_balance::select('items.name', 'main_stock_balance.*')
                ->join('items', 'main_stock_balance.item_id', '=', 'items.item_id')
                ->get()
                ->toArray();
        } elseif ($ret == 'available') {
            $return = main_stock_balance::select('items.name', 'main_stock_balance.*')
                ->join('items', 'main_stock_balance.item_id', '=', 'items.item_id')
                ->where('main_stock_balance.qty', '>', 0)
                ->get()
                ->toArray();
        } elseif ($ret == 'data') {
            $item = $value[0];
            $return = main_stock_balance::where('item_id', $item)
                ->first()
                ->toArray();
        }

        return $return;
    }
}
