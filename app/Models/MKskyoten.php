<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MKskyoten extends Model
{
    use HasFactory;
    protected $table = 'm_kskyoten';
    protected $primaryKey = ['ktn_cd'];
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ktn_cd',
        'ktn_nm',
        'del_flg',
    ];

    public function getDataCombobox()
    {
        $res = self::query()->getQuery()
                ->select(['ktn_cd', 'ktn_nm'])
                ->where('del_flg', FALSE)
                ->orderBy('ktn_cd')
                ->pluck('ktn_nm', 'ktn_cd');

        return $res;
    }
}
