<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MGanryoPump extends Model
{
    use HasFactory;
    protected $table = 'm_ganryo_pump';
    protected $primaryKey = ['ktn_cd', 'hin_cd', 'kikaku_cd', 'dispenser_kbn'];
    public $timestamps = false;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ktn_cd',
        'hin_cd',
        'kikaku_cd',
        'dispenser_kbn',
        'hakidasu_ryo_nama_dai',
        'hakidasu_ryo_nama_sho',
        'lot_no',
        'hakidasu_ryo_usu_dai',
        'hakidasu_ryo_usu_sho',
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id',
    ];

    public function listPG301()
    {
        $delFlg = FALSE;
        $qb = self::query()->getQuery();

        $qb = $qb->leftJoin('m_hinmoku', function($j) use($delFlg){
                    $j->on('m_hinmoku.hin_cd', '=', 'm_ganryo_pump.hin_cd');
                    $j->where('m_hinmoku.del_flg', '=', $delFlg);
                })
                ->leftJoin('m_kikaku', function($j) use($delFlg){
                    $j->on('m_kikaku.kikaku_cd', '=', 'm_ganryo_pump.kikaku_cd');
                    $j->where('m_kikaku.del_flg', '=', $delFlg);
                })
                ->leftJoin('m_code', function($j) use($delFlg){
                    $j->on('m_code.kbn', '=', 'm_kikaku.tuya_kbn');
                    $j->where('m_code.code', '=', 'K19');
                    $j->where('m_code.del_flg', '=', $delFlg);
                })

                ->select([
                    'm_ganryo_pump.ktn_cd',
                    'm_ganryo_pump.hin_cd',
                    'm_hinmoku.hin_nm',
                    'm_ganryo_pump.kikaku_cd',
                    'm_code.name',
                    'm_ganryo_pump.dispenser_kbn',
                    'm_ganryo_pump.lot_no',
                    'm_ganryo_pump.keisu',
                ])
                ->where('m_ganryo_pump.del_flg', $delFlg)
                ->orderBy('m_ganryo_pump.ktn_cd')
                ;
        return $qb;
    }

    public function getRecord($ktnCd, $hinCd, $kikakuCd, $dispenserKbn)
    {
        $delFlg = FALSE;
        $qb = self::query()->getQuery();

        $qb = $qb->leftJoin('m_hinmoku', function($j) use($delFlg){
                    $j->on('m_hinmoku.hin_cd', '=', 'm_ganryo_pump.hin_cd');
                    $j->where('m_hinmoku.del_flg', '=', $delFlg);
                })
                ->select([
                    'm_ganryo_pump.ktn_cd',
                    'm_ganryo_pump.hin_cd',
                    'm_hinmoku.hin_nm',
                    'm_ganryo_pump.kikaku_cd',
                    'm_ganryo_pump.dispenser_kbn',
                    'm_ganryo_pump.lot_no',
                    'm_ganryo_pump.keisu',
                    'm_ganryo_pump.hakidasu_ryo_nama_dai',
                    'm_ganryo_pump.hakidasu_ryo_nama_sho',
                    'm_ganryo_pump.hakidasu_ryo_usu_dai',
                    'm_ganryo_pump.hakidasu_ryo_usu_sho',
                ])
                ->where('m_ganryo_pump.del_flg', $delFlg)
                ->where('m_ganryo_pump.ktn_cd', $ktnCd)
                ->where('m_ganryo_pump.hin_cd', $hinCd)
                ->where('m_ganryo_pump.kikaku_cd', $kikakuCd)
                ->where('m_ganryo_pump.dispenser_kbn', $dispenserKbn)
                ;

        return $qb;
    }
}
