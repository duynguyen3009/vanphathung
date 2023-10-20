<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MUntin extends Model
{
    use HasFactory;
    protected $table = "m_untin";

    public function getDataCombobox()
    {
        $res = self::query()
            ->select(['busho_cd', 'untin_pattern'])
            ->where('del_flg', FALSE)
            ->orderBy('busho_cd')
            ->pluck('untin_pattern', 'busho_cd');
        return $res;
    }
}
