<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MUser extends Authenticatable
{
    use HasFactory;
    protected $table = "m_user";
    protected $primaryKey = "user_id";

    function getDataComboBox()
    {
        $res = self::query()
            ->select('user_id', 'user_nm')
            ->where('del_flg', false)
            ->orderBy('user_id')
            ->pluck('user_nm', 'user_id');
        return $res;
    }

    public function getMUser ($user_id = null) {
        $query = $this->select('user_id', 'user_nm')
        ->where('del_flg', 'f');

        if($user_id !== null) {
            $query->where('user_id', '=', $user_id);
        }

        return $query->orderBy('user_id')->get();
    }
}
