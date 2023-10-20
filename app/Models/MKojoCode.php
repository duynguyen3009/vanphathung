<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKojoCode extends Model
{
    use HasFactory;
    const CREATED_AT = 'ins_dt';
    const UPDATED_AT = 'upd_dt';
    protected $table = "m_kojo_code";
    protected $fillable = [
        "ktn_cd",
        "cd",
        "kbn",
        "disp",
        "value_1",
        "value_2",
        "cd_nm",
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id'
    ];
    public $timestamps = false;

    public function list($ktnCd)
    {
        $qb = self::query()
            ->where('del_flg', FALSE)
            ->where('cd', 'DISPENKB')
            ->where('ktn_cd', $ktnCd)
            ->orderBy('disp');
            
        return $qb;
    }
}