<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKoza extends Model
{
    use HasFactory;
    protected $table = "m_koza";
    public $timestamps = false;

    public function getMKoza ($m_koza_id = null) {
        $query = $this->select('m_koza_id', 'kinyu_nm', 'kinyu_siten_nm', 'koza_type', 'koza_no', 'koza_meigi')
        ->where('del_flg', 'f');
    
        if($m_koza_id !== null) {
            $query->where('m_koza_id', '=', $m_koza_id);
        }

        return $query->orderBy('m_koza_id')->get();
    }
}
