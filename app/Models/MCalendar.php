<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MCalendar extends Model
{
    use HasFactory;
    protected $table = "m_calendar";

    public function getDataCombobox()
    {
        $res = self::query()
            ->distinct()
            ->select(['cln_cd', 'cln_cd as cln_nm'])
            ->where('del_flg', FALSE)
            ->orderBy('cln_cd')
            ->pluck('cln_nm', 'cln_cd');
        return $res;
    }
}
