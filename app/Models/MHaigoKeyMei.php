<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHaigoKeyMei extends Model
{
    use HasFactory;
    const CREATED_AT = 'ins_dt';
    const UPDATED_AT = 'upd_dt';
    protected $table = 'm_haigo_key_mei';
    protected $fillable = [
        'haigo_key',
        'hin_cd',
        'kikaku_cd',
        'ganryo_kbn',
        'bihikuru_keisu',
        'tonyu_group_no',
        'disp_jun',
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id',
    ];
    protected $primaryKey = ['haigo_key', 'hin_cd', 'kikaku_cd'];
    public $timestamps = false;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    public function listPG402($key)
    {
        $delFlg = FALSE;
        $qb = self::query();
        
        $qb = $qb->join('m_hinmoku', function($j) use($delFlg){
                    $j->on('m_haigo_key_mei.hin_cd', '=', 'm_hinmoku.hin_cd');
                    $j->where('m_hinmoku.del_flg', '=', $delFlg);
                })
                ->leftJoin('m_code', function($j) use($delFlg){
                    $j->on('m_code.kbn', '=', 'm_haigo_key_mei.ganryo_kbn');
                    $j->where('m_code.code', '=', 'K64');
                    $j->where('m_code.del_flg', '=', $delFlg);
                })
                ->leftJoin('m_kikaku', function($j) use($delFlg){
                    $j->on('m_kikaku.kikaku_cd', '=', 'm_haigo_key_mei.kikaku_cd');
                    $j->where('m_kikaku.del_flg', '=', $delFlg);
                })
                ->leftJoin('m_code as K19', function($j) use($delFlg){
                    $j->on('K19.kbn', '=', 'm_kikaku.tuya_kbn');
                    $j->where('K19.code', '=', 'K19');
                    $j->where('K19.del_flg', '=', $delFlg);
                })
                ->select([
                    'm_haigo_key_mei.hin_cd',  // 配合キー明細マスタ．品目CD
                    'm_hinmoku.hin_nm', // 品目マスタ．品目名称
                    'm_haigo_key_mei.kikaku_cd', // 配合キー明細マスタ．規格CD
                    'm_code.name as ganryo_kbn', // 共通コードマスタ．名称 AS 顔料区分
                    'K19.name as kikaku', // 規格
                    'm_haigo_key_mei.bihikuru_keisu', // 配合キー明細マスタ．ビヒクル係数
                    'm_haigo_key_mei.tonyu_group_no', // 配合キー明細マスタ．投入グループ番号
                    'm_haigo_key_mei.disp_jun',  // 配合キー明細マスタ．投入順
                    'm_haigo_key_mei.upd_dt',  // 配合キー明細マスタ．更新日
                    'm_haigo_key_mei.haigo_key',
                    'm_haigo_key_mei.ganryo_kbn as haigo_key_mei__ganryo_kbn',
                ])
                ->where('m_haigo_key_mei.haigo_key', $key)
                ->where('m_haigo_key_mei.del_flg', $delFlg)
                ->orderBy('m_haigo_key_mei.hin_cd')
                ->orderBy('m_haigo_key_mei.kikaku_cd')
                ;

        return $qb;
    }
}
