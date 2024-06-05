<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class posteloutboxing extends Model
{
    use HasFactory;
    protected $table = 'posteloutboxing';
    protected $primaryKey = 'out_id';
    protected $fillable = [
        'name',
        'phone',
        'pt_reference',
        'amount',
        'blanch',
        'user_id',
        'status',
        'pdate',

    ];

    public function products()
    {
        return $this->hasMany(OutboxingMailProduct::class,'post_card_id');
    }

    public static function getMonthlySumData($year, $blanch)
    {
        return DB::table('posteloutboxing')
            ->select(DB::raw('SUM(amount) as amounts'), DB::raw('SUM(qty) as qty'), DB::raw('MAX(created_at) as reg_date'))
            ->whereYear('created_at', $year)
            ->where('blanch', $blanch)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
    }
    public static function postel($value = 0, $ret = '')
    {
        $branch = Auth::user()->branch;
        $query = DB::table('posteloutboxing')->where('blanch', $branch);

        if ($ret == '') {
            $result = $query->orderByDesc('out_id')->get()->toArray();
        } elseif ($ret == 'date') {
            if (isset($value[0]) && !empty($value[0]) && isset($value[1]) && !empty($value[1])) {
                $start = $value[0];
                $end = $value[1];
                if ($start != $end) {
                    $query->whereBetween('created_at', [$start, $end]);
                } else {
                    $regdate = $start;
                    $query->whereDate('created_at', $regdate);
                }
            } else {
                $regdate = date('Y-m-d');
                $query->whereDate('created_at', $regdate);
            }

            $result = $query->get()->toArray();
        }

        return $result;
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
            ->leftJoin('posteloutboxing AS b', function ($join) use ($v) {
                $join->on('a.id', '=', 'b.blanch')->whereRaw($v);
            })
            ->select(
                DB::raw('MAX(a.name) AS name'),
                DB::raw('SUM(IFNULL(b.qty, 0)) AS qty'),
                DB::raw('SUM(IFNULL(b.amount, 0)) AS total')
            )
            // ->whereRaw("1=1 $v")
            ->groupBy('a.id');

        $result = $query->get();

        return $result;
    }
}
