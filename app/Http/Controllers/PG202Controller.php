<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Helpers\Grid\GridSearch;
use App\Http\Requests\PG202Request;
use App\Helpers\Common;
use App\Models\MKskyoten;
use App\Models\MKikaku;

class PG202Controller extends Controller
{
    protected $mKskyoten;
    protected $mKikaku;

    public $routeIndex = '';

    public function __construct(MKskyoten $mKskyoten, MKikaku $mKikaku)
    {
        $this->mKskyoten    = $mKskyoten;
        $this->mKikaku      = $mKikaku;
    }

    public function edit(Request $request, $hinCd, $hinNm)
    {
        // \Log::info(print_r('edit', TRUE) );
        // $mode               = 'edit';
        // $transformSearch    = json_decode(request('transform_search', ''));
        $GridSearch         = new GridSearch('PG202');
        $listKskyoten       = $this->mKskyoten->getDataCombobox();
        $qb = $this->mKikaku->listPG202();
        $GridSearch->paginate($qb);
       
        data_set($GridSearch->gridResultTable, 'mode', 'edit');

        return view('pg202.form', compact('GridSearch','listKskyoten'));
    }

    public function saveHanbaiKojo(PG202Request $request)
    {
        $formInputs = $request->all();
        \Log::info(print_r($formInputs, TRUE) );die();
        // $request->validate([
        //     'jyu_entry_fuka_flg__10000016_1_3176' => 'min:10',
        // ],
        // [
        //     'required'  => 'Không được rỗng',
        //     'min'  => 'nhỏ nhất là 10',
        // ]);
        // \Log::info(print_r('saveHanbaiKojo', TRUE) );
        // \Log::info(print_r($formInput, TRUE) );
        // die();
    }
}