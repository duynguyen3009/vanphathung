<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MBusho extends Model
{
    use HasFactory;
    protected $table = "m_busho";

    function getDataComboBox()
    {
        $res = self::query()
            ->select('busho_cd', 'busho_nm')
            ->where('del_flg', false)
            ->orderBy('busho_cd')
            ->pluck('busho_nm', 'busho_cd');
        return $res;
    }
    public function getMBusho ($mBushoCd = null) {
        $query = $this->select('busho_cd', 'busho_nm')
        ->where('del_flg', 'f');
    
        if($mBushoCd !== null) {
            $query->where('busho_cd', '=', $mBushoCd);
        }

        return $query->orderBy('busho_cd')->get();
    }

}
