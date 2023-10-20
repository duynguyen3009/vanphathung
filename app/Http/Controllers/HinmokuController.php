<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Helpers\Grid\GridSearch;
use App\Http\Controllers\Controller;
use App\Models\MCode;
use App\Models\MHinmoku;
use Illuminate\Http\Request;

class HinmokuController extends Controller
{
    public function index()
    {
        $mCode = new MCode();
        $mHinmoku = new MHinmoku();
        $listSeihinKbn = $mCode->getDataCombobox('K05');
        $GridSearch = new GridSearch('PG101');
        $qb = $mHinmoku->listPG101();
        $qb = Common::applyOtherWhereSearch($GridSearch, $qb);
        $GridSearch->paginate($qb);
        return view('hinmoku.index', ['GridSearch' => $GridSearch, 'listSeihinKbn' => $listSeihinKbn]);
    }

    public function create()
    {
        dump('create');
        dd(request()->all());
    }

    public function edit()
    {
        dump('edit');
        dd(request()->all());
    }
    public function copy()
    {
        dump('copy');
        dd(request()->all());
    }
}
