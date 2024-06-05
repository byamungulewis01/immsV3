<?php

namespace App\Models;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table='items';
    protected $primaryKey = 'item_id';
    protected $fillable = [
        'name',
        'category',
        'purchasingprice',
        'sellingprice',
        'description',
        'inStore'
    ];
    // declare that an item belongs to a category
    public function category_info()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }
    public function purchase()
    {
        return $this->hasMany(Purchase::class,'item_id','item_id');
    }
}
