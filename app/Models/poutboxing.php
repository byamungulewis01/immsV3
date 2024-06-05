<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class poutboxing extends Model
{
    use HasFactory;
    protected $table = 'poutboxing';
    protected $primaryKey = 'out_id';
    protected $fillable = [
        'tracking',
        'snames',
        'sphone',
        'semail',
        'snid',
        'saddress',
        'c_id',
        'rnames',
        'rphone',
        'remail',
        'raddress',
        'weight',
        'unit',
        'amount',
        'tax',
        'item_id',
        'postage',
        'ptype',
        'blanch',
        'user_id',
        'status',
        'pdate',
        'tradate',
        'recdate',
    ];
    public static function byrange($start, $end)
    {
        //get branch id from cuurent user
        $branch = auth()->user()->branch;
        if (isset($start) && !empty($start) && isset($end) && !empty($end)) {
            if ($start != $end) {
                $v = "AND DATE(poutboxing.created_at) BETWEEN '$start' AND '$end'";
            } else {
                $regdate = $start;
                $v = "AND DATE(poutboxing.created_at='$regdate')";
            }
        } else {
            $regdate = date('Y-m-d');
            $v = "AND DATE(poutboxing.created_at)='$regdate'";
        }

        $sql = "SELECT * FROM `poutboxing` WHERE blanch='$branch' $v";
        $results = DB::select($sql);

        return $results;
    }
    public static function getMonthlySumData($year, $blanch)
    {
        return DB::table('poutboxing')
            ->select(
                DB::raw('SUM(amount) as amount'),
                DB::raw('SUM(tax) as tax'),
                DB::raw('SUM(postage) as postage'),
                DB::raw('MAX(created_at) as reg_date')
            )
            ->whereYear('created_at', $year)
            ->where('blanch', $blanch)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
    }
    public static function ems_report($start = '', $end = '')
    {
        $v = '';
        if (isset($start) && !empty($start) && isset($end) && !empty($end)) {
            if ($start != $end) {
                $v = "DATE(b.created_at) BETWEEN '$start' AND '$end'";
            } else {
                $regdate = $start;
                $v = "DATE(b.created_at) = '$regdate'";
            }
        } else {
            $regdate = date('Y-m-d');
            $v = "DATE(b.created_at) = '$regdate'";
        }

        $query = DB::table('branches as a')
            ->leftJoin('poutboxing AS b', function ($join) use ($v) {
                $join->on('a.id', '=', 'b.blanch')->whereRaw($v);
            })
            ->select(
                DB::raw('MAX(a.name) AS name'),
                DB::raw('CONCAT(SUM(IFNULL(b.weight, 0))," ",MAX(b.unit)) AS weight'),
                DB::raw('SUM(IFNULL(b.amount, 0)) AS amount'),
                DB::raw('SUM(IFNULL(b.tax, 0)) AS tax'),
                DB::raw('SUM(IFNULL(b.postage, 0)) AS postage'),
                DB::raw('
                (
                    SUM(
                        IFNULL(b.amount, 0)
                    ) +
                    SUM(
                        IFNULL(b.tax, 0)
                    ) +
                    SUM(
                        IFNULL(b.postage, 0)
                    )

                ) AS total')
            )
            // ->whereRaw("1=1 $v")
            ->groupBy('a.id');

        $result = $query->get();

        return $result;
    }
}
