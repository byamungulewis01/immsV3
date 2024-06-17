<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'chuk_id' => $this->chuk_id,
            'gender' => ($this->gender == 'male') ? 'Male' : 'Female',
            'dateOfBirth' => $this->dateOfBirth,
            'district_id' => DB::table('rwanda_addresses')->where('dist_id',$this->district_id)->select('dist_id','district')->get(),
            'sector_id' => DB::table('rwanda_addresses')->where('sect_id',$this->sector_id)->select('sect_id','sector')->get(),
            'status' => $this->status,
            'user_id' => User::find( $this->user_id),
        ];
    }
}
