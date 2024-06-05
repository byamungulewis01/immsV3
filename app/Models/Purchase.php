<?php

namespace App\Models;

use App\Models\Item;
// use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = "purchasehist";
    protected $primaryKey = "purcha_id";
    protected $fillable = ['item_id', 'quantity', 'total', 'supplier_id', 'code', 'inStore'];
    // public function getPurchaseTotalsByCode()
    // {
    //     $results = $this->select('supplier_id', 'code', DB::raw('MAX(created_at) as created_at'), DB::raw('SUM(quantity) as quantity'), DB::raw('SUM(total) as total'))
    //         ->groupBy('code','supplier_id')->orderByDesc('created_at')
    //         ->get();

    //     return $results;
    // }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
    public function supplier()
    {
        return $this->belongsTo(supplier::class, 'supplier_id', 'id');
    }
}
