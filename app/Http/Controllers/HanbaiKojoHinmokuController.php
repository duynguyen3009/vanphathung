<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Common;
use App\Helpers\Grid\GridSearch;
use App\Models\MHinmoku;
use App\Models\MKskyoten;

class HanbaiKojoHinmokuController extends Controller
{
    private $mHinmoku;
    private $mKskyoten;
    public function __construct(MHinmoku $mHinmoku, MKskyoten $mKskyoten)
    {
        $this->mHinmoku = $mHinmoku;
        $this->mKskyoten = $mKskyoten;
    }

    public function index()
    {
        $GridSearch = new GridSearch('PG201');
        $qb = $this->mHinmoku->listPG201();
        $qb = Common::applyOtherWhereSearch($GridSearch, $qb);
        $GridSearch->orderByDefault = ['hin_cd'];
        $GridSearch->paginate($qb);
        $listKskyoten = $this->mKskyoten->getDataCombobox();
        $listMHinmoku = $this->mHinmoku->getHinKbnOptions();
        data_set($GridSearch->gridResultTable, 'hin_kbn_all', $listMHinmoku);
        data_set($GridSearch->gridResultTable, 'ktn_cd_all', $listKskyoten);

        return view('hanbai_kojo_hinmoku.index', [
            'GridSearch' => $GridSearch,
            'hin_kbn_all' => $listMHinmoku,
            'ktn_cd_all' => $listKskyoten
        ]);
    }

    // PG202
    public function spec(Request $request)
    {
        dd($request->all());
    }
}
