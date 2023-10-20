<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MTokKanren extends Model
{
    use HasFactory;

    protected $table = "m_tok_kanren";
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'tok_cd',
        'tok_cd2',
        'user_tok_cd',
        'user_tok_cd2',
        'sousai_flg',
        'endhat_dt',
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id',
    ];

    function listPG602($tokCd, $tokCd2)
    {
        $delFlg = FALSE;
        $qb = self::getQuery();

        $qb = $qb->join('m_tokuisaki', function ($j) use ($delFlg) {
            $j->on('m_tokuisaki.tok_cd', '=', 'm_tok_kanren.user_tok_cd');
            $j->on('m_tokuisaki.tok_cd2', '=', 'm_tok_kanren.user_tok_cd2');
            $j->where('m_tokuisaki.del_flg', '=', $delFlg);
        });

        $qb->select(
            'user_tok_cd',
            'user_tok_cd2',
            'tok_nm',
            'sousai_flg',
            'm_tok_kanren.tok_cd',
            'm_tok_kanren.tok_cd2',
            DB::raw('0 as edit_flg'),
            DB::raw('0 as del_flg'),
            DB::raw("m_tok_kanren.tok_cd || '-' || m_tok_kanren.tok_cd2 || '-' || user_tok_cd || '-' || user_tok_cd2 as key")
        )
            ->where('m_tok_kanren.del_flg', $delFlg)
            ->where('m_tok_kanren.tok_cd2', $tokCd2)
            ->where('m_tok_kanren.tok_cd', $tokCd);
        return $qb;
    }
}
