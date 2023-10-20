<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MGanryoShusei extends Model
{
    use HasFactory;
    protected $table = 'm_ganryo_shusei';
    protected $primaryKey = ['ktn_cd', 'shohi_hin_cd'];
    public $timestamps = false;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ktn_cd',
        'shohi_hin_cd',
        'keisu',
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id',
    ];
}