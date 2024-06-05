<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_branch_balance extends Model
{
    use HasFactory;
    protected $table = 'stock_branch_balance';
    public static function branch_balance($value = [], $ret = '')
    {
        if ($ret == '') {
            $return = array();
            $branch = $value[0];
            $query = self::select('items.name', 'stock_branch_balance.*')
                ->join('items', 'stock_branch_balance.item_id', '=', 'items.item_id')
                ->where('stock_branch_balance.branch', '=', $branch)
                ->get();

            if ($query->count() > 0) {
                $return = $query->toArray();
            }
        } elseif ($ret == 'sell') {
            $branch = $value[0];
            $return = array();
            $query = self::select('items.*','stock_branch_balance.qty')
                ->join('items', 'stock_branch_balance.item_id', '=', 'items.item_id')
                ->where('stock_branch_balance.qty', '>', 0)
                ->where('stock_branch_balance.branch', '=', $branch)
                ->get();

            if ($query->count() > 0) {
                $return = $query->toArray();
            }
        } elseif ($ret == "data") {
            $branch = $value[0];
            $item = $value[1];
            $return = false;
            $query = self::where('item_id', $item)
                ->where('branch', $branch)
                ->get();

            if ($query->count() > 0) {
                $return = $query->first();
            }
        }
        return $return;
    }

}
