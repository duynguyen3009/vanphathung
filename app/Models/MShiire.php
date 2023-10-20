<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\MCode;
use Illuminate\Database\Eloquent\Builder;

class MShiire extends Model
{
    use HasFactory;
    protected $table = "m_shiire";
    protected $fillable = [
        'shiire_cd',
        'shiire_cd2',
        'shiire_nm',
        'shiire_nm2',
        'shiire_ryaku_nm',
        'shiire_kana_ryaku_nm',
        'tel_no',
        'fax_no',
        'hatchu_fax_send_flg',
        'jyu_fax_no',
        'jyu_mail_adr',
        'cellmail_adr',
        'yubin_no',
        'adr_ken',
        'adr_si',
        'adr_tyo',
        'adr_ban',
        'adr_bil',
        'tan_nm',
        'shiire_kbn',
        'uke_busho_cd',
        'uke_tan_cd',
        'eig_busho_cd',
        'eig_tan_cd',
        'ksjig_cd',
        'sime_tm',
        'saimu_keijo_saki_shiire_cd',
        'saimu_keijo_saki_shiire_cd2',
        'shitaukeho_note',
        'kenshuhokokusho_fax_send_kyoka',
        'jigyosho_num',
        'sizaibu_flg',
        'm_koza_id',
        'hatchu_mail_adr',
        'hatyusho_send_flg',
        'kenshusho_send_flg',
        'shiire_g1',
        'shiire_g2',
        'shiire_g3',
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id',
    ];
    protected $primaryKey = ['shiire_cd', 'shiire_cd2'];
    public $incrementing = false;
    public $timestamps = false;


    public function getList()
    {
        return $this->query('shiire_cd', 'shiire_nm', 'shiire_cd2', 'shiire_nm2', 'tel_no', 'fax_no', 'yubin_no', 'adr_ken', 'adr_si', 'adr_tyo', 'adr_ban', 'adr_bil')
        ->where('del_flg', 'f')->getQuery();
    }

    public function getCodeCombobox($code){
        return (new MCode())->getDataCombobox($code);
    }

    public function getSaimuKeijoSakiShiireCd ($saimu_keijo_saki_shiire_cd = null) {
        $query = $this->select('shiire_cd','shiire_cd2','shiire_nm','shiire_nm2')
        ->where('del_flg', 'f')
        ->where('shiire_kbn', '=', '0');

        if ($saimu_keijo_saki_shiire_cd !== null) {
            $query->where('shiire_cd', '=', $saimu_keijo_saki_shiire_cd);
        }

        return $query->get();
    }

    public function getDataDetail ($shiire_cd, $shiire_cd2) {
        $result = $this->select('*')
        ->leftJoin('m_koza', function ($join) {
            $join->on('m_shiire.m_koza_id','=','m_koza.m_koza_id')
                 ->on('m_koza.del_flg', '=', DB::raw('false'));
        })
        ->where('m_shiire.del_flg','=', DB::raw('false'))
        ->where('m_shiire.shiire_cd','=',$shiire_cd)
        ->where('m_shiire.shiire_cd2','=',$shiire_cd2)
        ->get()
        ->first();
        if ($result) {
            return $result->toArray();
        }
        return [];
    }
    
}
