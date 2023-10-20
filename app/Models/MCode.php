<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCode extends Model
{
    use HasFactory;
    const CREATED_AT = 'ins_dt';
    const UPDATED_AT = 'upd_dt';
    protected $table = "m_code";
    protected $fillable = [
        "code",
        'kbn',
        'disp',
        'name',
        'code_name',
        'ver',
        'del_flg',
        'upd_dt',
        'upd_user_id',
        'ins_dt',
        'ins_user_id'
    ];
    public $timestamps = false;

    public function getDataCombobox($code)
    {
        $res = self::query()
            ->select(['kbn', 'name'])
            ->where('del_flg', FALSE)
            ->where('code', $code)
            ->orderBy('disp')
            ->pluck('name', 'kbn');
        return $res;
    }

    public function scopeList($query, $where = array()) {
        if(!empty($where)) {
            $query->where($where);
        }
        return $query->where('del_flg', '=', false)->get();
    }
}
