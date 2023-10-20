<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\MCode;

class MHinmoku extends Model
{
    use HasFactory;
    const CREATED_AT = 'ins_dt';
    const UPDATED_AT = 'upd_dt';
    protected $table = 'm_hinmoku';
    protected $fillable = [
        'hin_cd',
        'hin_nm',
        'del_flg'
    ];
    public $timestamps = false;

    public function scopeList($query, $where = array()) {
        if(!empty($where)) {
            $query->where($where);
        }
        return $query->where('del_flg', '=', false)->orderBy('hin_cd', 'ASC')->get();
    }

    public function listPG101()
    {
        return self::query()->leftJoin('m_code', function ($join) {
            $join->on('m_code.kbn', 'm_hinmoku.hin_kbn')
                ->where('m_code.code', '=', 'K05')
                ->where('m_code.del_flg', false);
        })
            ->leftJoin('m_user', function ($join) {
                $join->on('m_user.user_id', 'm_hinmoku.upd_user_id')
                    ->where('m_user.del_flg', false);
            })
            ->select(
                'm_code.name',
                'hin_cd',
                'hin_nm',
                'm_hinmoku.upd_dt',
                'm_user.user_nm'
            )
            ->where('m_hinmoku.del_flg', false)->getQuery();
    }

    public function listPG201()
    {
        $mHanbaiKojoHinmoku = DB::table('m_hanbai_kojo_hinmoku')
            ->where('del_flg', 'f')
            ->select('ktn_cd', 'hin_cd');
        $mSeizoKojoHinmoku = DB::table('m_seizo_kojo_hinmoku')
            ->where('del_flg', 'f')
            ->select('ktn_cd', 'hin_cd');
        $kojoHinmoku = $mHanbaiKojoHinmoku->union($mSeizoKojoHinmoku);

        $query = $this->query()
            ->leftJoinSub($kojoHinmoku, 'kojo_hinmoku', 'm_hinmoku.hin_cd', '=', 'kojo_hinmoku.hin_cd')
            ->select([
                "m_hinmoku.hin_cd",
                "m_hinmoku.hin_nm",
                "m_hinmoku.hin_kbn",
                DB::raw("COUNT(kojo_hinmoku.ktn_cd) AS cnt_ktn_cd"),
                DB::raw("STRING_AGG(kojo_hinmoku.ktn_cd, ','  ORDER BY kojo_hinmoku.ktn_cd) AS ktn_cd_all")
            ])
            ->where('m_hinmoku.del_flg', 'f')
            ->groupBy(['m_hinmoku.hin_cd', 'm_hinmoku.hin_nm'])
        ;
        $qb = new Builder($this->getConnection());
        return $qb->fromSub($query, 'pg201');
    }

    public function getHinKbnOptions(){
        return (new MCode())->getDataCombobox('K05');
    }

}
