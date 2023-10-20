<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MTokuisaki extends Model
{
    use HasFactory;

    protected $table = "m_tokuisaki";
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'tok_cd',
        'tok_cd2',
        'tok_nm',
        'tok_nm2',
        'tok_ryaku_nm',
        'tok_kana_ryaku_nm',
        'houjin_cd',
        'tel_no',
        'fax_no',
        'jyu_fax_no',
        'jyu_fax_mail_adr',
        'jyu_mail_adr',
        'cellmail_adr',
        'yubin_no',
        'adr_ken_cd',
        'adr_si_cd',
        'adr_ken',
        'adr_si',
        'adr_tyo',
        'adr_ban',
        'a_cd',
        'b_cd',
        'c_cd',
        'd_cd',
        'e_cd',
        'tk_cd',
        'cdr_cd',
        'saiken_keijo_saki_tok_cd',
        'saiken_keijo_saki_tok_cd2',
        'tnkg_cd',
        'tok_kbn',
        'tok_shubetsu',
        'untin_kbn',
        'untin_pattern',
        'oem_taisyo_flg',
        'disp_ctrl_oem',
        'uke_busho_cd',
        'uke_tan_cd',
        'eig_busho_cd',
        'eig_tan_cd',
        'ksjig_cd',
        'hyouji_flg01',
        'hyouji_flg02',
        'hyouji_flg03',
        'hyouji_flg04',
        'hyouji_flg05',
        'hyouji_flg06',
        'hyouji_flg07',
        'hyouji_flg08',
        'hyouji_flg09',
        'hyouji_flg10',
        'hai_group_cd_1',
        'hai_group_cd_2',
        'endhat_dt',
        'shukka_meisaisho_kbn',
        'yoshin_gendo_amount',
        'yoshin_gen_kanri_flg',
        'jigyosho_num',
        'nifuda_hin_nm_hidden_flg',
        'nifuda_sikityo_hidden_flg',
        'not_uriage_flg',
        'mihon_label_kbn',
        'tok_g1',
        'tok_g2',
        'tok_g3',
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id'
    ];

    function listPG601()
    {
        $qb = self::query()->getQuery();
        $qbMTokKanren = MTokKanren::select([
            'tok_cd AS m_tok_kanren__tok_cd',
            'tok_cd2 AS m_tok_kanren__tok_cd2',
            DB::raw('count(*) AS cnt_tok_kanren')])
            ->where('del_flg', 'f')
            ->groupBy(['tok_cd', 'tok_cd2']);
        $mainTbl = $this->table;
        $qb->leftJoinSub($qbMTokKanren, $joinTbl = 't1', function ($qb) use ($mainTbl, $joinTbl) {
            $qb->on("{$mainTbl}.tok_cd", '=', "{$joinTbl}.m_tok_kanren__tok_cd")
                ->on("{$mainTbl}.tok_cd2", '=', "{$joinTbl}.m_tok_kanren__tok_cd2");
        });
        $qb->select(["{$mainTbl}.*"])
            ->addSelect(DB::raw("
                CASE 
                    WHEN {$joinTbl}.cnt_tok_kanren > 0 THEN '有'
                    ELSE '無い'
                END AS shimuke_saki
            "))
            ->where("{$mainTbl}.del_flg", 'f');
        return $qb;
    }

    function getListCustomer($tokKbn)
    {
        $res = self::query()
            ->select('tok_cd', 'tok_cd2', 'tok_nm', 'tok_nm2')
            ->where('del_flg', FALSE)
            ->where('tok_kbn', $tokKbn)
            ->get();
        return $res;
    }
}
