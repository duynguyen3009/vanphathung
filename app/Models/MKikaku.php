<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MKikaku extends Model
{
    use HasFactory;
    const CREATED_AT = 'ins_dt';
    const UPDATED_AT = 'upd_dt';
    protected $table = "m_kikaku";
    protected $fillable = [
        "kikaku_cd",
        'tuya_kbn',
        'irime_kbn',
        'irime_tani_kbn',
        'size_kbn',
        'kejyo_kbn',
        'meji_kbn',
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id'
    ];
    public $timestamps = false;

    public function getListCombobox($hinCd)
    {
        $query = self::getQuery();
        $query->select(
            'm_kikaku.kikaku_cd',
            'K19.name as K19',
            'C112.name as C112',
            'K17.name as K17',
            'C113.name as C113',
            'C114.name as C114',
            'C115.name as C115'
        );

        $where = [
            ['m_kikaku.del_flg', '=', false]
        ];

        $res = $this->getQueryHaigoKeyMei($query, $where, $hinCd)->get();

        return $res;
    }

    public function getQueryHaigoKeyMei($query, $where, $hinCd) 
    {
        $query->join('m_hinmoku_kikaku', function($join) use ($hinCd) {
            $join->on('m_hinmoku_kikaku.kikaku_cd', '=', 'm_kikaku.kikaku_cd');
            $join->where('m_hinmoku_kikaku.hin_cd', '=', $hinCd);
            $join->on('m_hinmoku_kikaku.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as K19', function($join) {
            $join->on('K19.code', '=', DB::raw("'K19'"));
            $join->on('K19.kbn', '=', 'm_kikaku.tuya_kbn');
            $join->on('K19.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as C112', function($join) {
            $join->on('C112.code', '=', DB::raw("'112'"));
            $join->on('C112.kbn', '=', 'm_kikaku.irime_kbn');
            $join->on('C112.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as K17', function($join) {
            $join->on('K17.code', '=', DB::raw("'K17'"));
            $join->on('K17.kbn', '=', 'm_kikaku.irime_tani_kbn');
            $join->on('K17.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as C113', function($join) {
            $join->on('C113.code', '=', DB::raw("'113'"));
            $join->on('C113.kbn', '=', 'm_kikaku.size_kbn');
            $join->on('C113.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as C114', function($join) {
            $join->on('C114.code', '=', DB::raw("'114'"));
            $join->on('C114.kbn', '=', 'm_kikaku.kejyo_kbn');
            $join->on('C114.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as C115', function($join) {
            $join->on('C115.code', '=', DB::raw("'115'"));
            $join->on('C115.kbn', '=', 'm_kikaku.meji_kbn');
            $join->on('C115.del_flg', '=', DB::raw('false'));
        });

        $query->where($where);

        return $query;
    }
}
