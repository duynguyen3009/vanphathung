<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MHaigoKey extends Model
{
    use HasFactory;
    protected $table = "m_haigo_key";
    protected $primaryKey = 'haigo_key';
    public $timestamps = false;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'haigo_key',
        'haigo_key_nm',
        'seihin_kbn',
        'flat_base_keisu',
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id',
    ];

    public function listPG401()
    {
        return self::query('haigo_key', 'haigo_key_nm', 'm_code.kbn', 'flat_base_keisu',)
            ->where('m_haigo_key.del_flg', 'f')
            ->leftJoin('m_code', function ($join) {
                $join->on('m_code.kbn', 'm_haigo_key.seihin_kbn')
                    ->where('m_code.code', '=', 'K51')
                    ->where('m_code.del_flg', 'f');
            })->getQuery();
    }

    public function getHaigoKeyJoinCode($haigoKeyCd, $code) {
        return self::query()
            ->join('m_code', function($join) use ($code) {
                $join->on('m_code.kbn', '=', 'm_haigo_key.seihin_kbn');
                $join->on('m_code.code', '=', DB::raw("'".$code."'"));
                $join->on('m_code.del_flg', '=', DB::raw('false'));
            })
            ->where([
                ['m_haigo_key.haigo_key', '=', $haigoKeyCd],
                ['m_haigo_key.del_flg', '=', false]
            ])
            ->first();
    }
}
