<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Helpers\Grid\GridSearch;
use App\Models\MTokuisaki;
use Illuminate\Http\Request;
use App\Models\MCode;
use App\Models\MTokKanren;
use App\Http\Requests\TokuisakiRequest;
use App\Http\Requests\TokKanrenRequest;
use App\Models\MBusho;
use App\Models\MCalendar;
use App\Models\MUntin;
use App\Models\MUser;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TokuisakiController extends Controller
{
    public function index(Request $request)
    {
        $GridSearch = new GridSearch('PG601');
        $model = new MTokuisaki();
        $qb = $model->listPG601();
        $qb = Common::applyOtherWhereSearch($GridSearch, $qb);
        $GridSearch->paginate($qb);
        return view('tokuisaki.index', compact('GridSearch'));
    }

    public function create(Request $request)
    {
        $GridSearch = new GridSearch('PG602');
        $mode = 'create';
        $GridSearch->pagination = Common::returnEmptyPagination();
        $item = [];
        return view('tokuisaki.form', array_merge($this->getDefaultData(), compact(
            'GridSearch',
            'item',
            'mode',
            'request',
        )));
    }

    public function edit(Request $request, $tokCd, $tokCd2)
    {
        return $this->showForm($request, 'edit', $tokCd, $tokCd2);
    }

    public function copy(Request $request, $tokCd, $tokCd2)
    {
        return $this->showForm($request, 'copy', $tokCd, $tokCd2);
    }

    public function getDefaultData()
    {
        $mCode = new MCode();
        $mUser = new MUser();
        $mBusho = new MBusho();
        $mTokuisaki = new MTokuisaki();
        $mUntin = new MUntin();
        $mCalendar = new MCalendar();
        $configForm = require(app_path('Helpers/Grid/config/PG602.php'));
        $configForm = $configForm['form'];
        $listUntin = $mUntin->getDataCombobox();
        $listUser = $mUser->getDataCombobox();
        $dataOption = config('params.options.m_tokuisaki');
        $listCustomer3 = $mTokuisaki->getListCustomer(3);
        $listCustomer = $mTokuisaki->getListCustomer(0);
        $configForm['adr_ken']['list'] = [];
        $configForm['adr_si']['list'] = [];
        $configForm['cdr_cd']['list'] = $mCalendar->getDataCombobox();
        $configForm['tnkg_cd']['list'] = $dataOption['tnkg_cd'];
        $configForm['tok_kbn']['list'] =  $mCode->getDataCombobox('K02');
        $configForm['tok_shubetsu']['list'] = $mCode->getDataCombobox('K23');
        $configForm['untin_kbn']['list'] = $mCode->getDataCombobox('K03');
        $configForm['untin_pattern']['list'] = $listUntin;
        $configForm['oem_taisyo_flg']['list'] = $dataOption['oem_taisyo_flg'];
        $configForm['uke_busho_cd']['list'] = $mBusho->getDataCombobox();
        $configForm['ksjig_cd']['list'] = $dataOption['ksjig_cd'];
        $configForm['uke_tan_cd']['list'] = $listUser;
        $configForm['eig_busho_cd']['list'] = $listUntin;
        $configForm['eig_tan_cd']['list'] = $listUser;
        $configForm['hyouji_flg01']['list'] = $dataOption['hyouji_flg'];
        $configForm['hyouji_flg02']['list'] = $dataOption['hyouji_flg'];
        $configForm['hyouji_flg03']['list'] = $dataOption['hyouji_flg'];
        $configForm['hyouji_flg04']['list'] = $dataOption['hyouji_flg'];
        $configForm['hyouji_flg05']['list'] = $dataOption['hyouji_flg'];
        $configForm['hyouji_flg06']['list'] = $dataOption['hyouji_flg'];
        $configForm['hyouji_flg07']['list'] = $dataOption['hyouji_flg'];
        $configForm['hyouji_flg08']['list'] = $dataOption['hyouji_flg'];
        $configForm['hyouji_flg09']['list'] = $dataOption['hyouji_flg'];
        $configForm['hyouji_flg10']['list'] = $dataOption['hyouji_flg'];
        $configForm['mihon_label_kbn']['list'] = $mCode->getDataCombobox('105');
        $configForm['shukka_meisaisho_kbn']['list'] = $dataOption['shukka_meisaisho_kbn'];
        $configForm['yoshin_gen_kanri_flg']['list'] = $dataOption['yoshin_gen_kanri_flg'];
        $configForm['nifuda_hin_nm_hidden_flg']['list'] = $dataOption['nifuda_hidden_flg'];
        $configForm['nifuda_sikityo_hidden_flg']['list'] = $dataOption['nifuda_hidden_flg'];
        $configForm['not_uriage_flg']['list'] = $dataOption['not_uriage_flg'];
        return compact('configForm', 'listCustomer3', 'listCustomer');
    }

    public function showForm($request, $mode, $tokCd, $tokCd2)
    {
        $item = MTokuisaki::where(['del_flg' => false, 'tok_cd' => $tokCd, 'tok_cd2' => $tokCd2])->first();
        $GridSearch     = new GridSearch('PG602');
        $mTokKanren = new MTokKanren();
        $qb = $mTokKanren->listPG602($tokCd, $tokCd2);
        $GridSearch->paginate($qb);
        if ($mode == 'copy') {
            $GridSearch->pagination = Common::returnEmptyPagination();
        }
        return view('tokuisaki.form', array_merge($this->getDefaultData(), compact(
            'GridSearch',
            'item',
            'mode',
            'request',
        )));
    }

    public function store(TokuisakiRequest $request)
    {
        $formInputs = $request->all();
        try {
            DB::beginTransaction();
            $mTokuisaki = new MTokuisaki();
            $formInputs['tok_cd2'] = '000';
            $formInputs['upd_dt'] = now();
            $formInputs['ins_dt'] = now();
            $formInputs['upd_user_id'] = '99';
            $formInputs['ins_user_id'] = '99';
            $arrData = [];
            foreach ($formInputs as $key => $value) {
                if (in_array($key, $mTokuisaki->getFillable()) && !is_null($value)) {
                    $arrData[$key] = $value;
                }
            }
            $newRecord = $mTokuisaki->firstOrCreate($arrData);
            $this->saveTokKanren($newRecord['tok_cd'], $formInputs);
            DB::commit();
            session()->flash('success', __('messages.MSG_INF_003'));
            return response()->json([
                'success'   => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            logger()->info($e->getMessage());
            return response()->json([
                'success'   => false,
                'msg'       => __('messages.MSG_ERR_016'),
            ]);
        }
    }

    public function update(TokuisakiRequest $request)
    {
        $formInputs = $request->all();
        try {
            DB::beginTransaction();
            $mTokuisaki = new MTokuisaki();
            $formInputs['upd_dt'] = now();
            $formInputs['upd_user_id'] = '98';
            $arrData = [];
            foreach ($formInputs as $key => $value) {
                if (in_array($key, $mTokuisaki->getFillable()) && !is_null($value)) {
                    $arrData[$key] = $value;
                }
            }
            $mTokuisaki->where('tok_cd', $arrData['tok_cd'])->update($arrData);
            $this->saveTokKanren($formInputs['tok_cd'], $formInputs);
            DB::commit();
            session()->flash('success', __('messages.MSG_INF_004'));
            return response()->json([
                'success'   => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            logger()->info($e->getMessage());
            return response()->json([
                'success'   => false,
                'msg'       => __('messages.MSG_ERR_016'),
            ]);
        }
    }


    public function saveTokKanren($tokCd, $formInputs)
    {
        $mTokKanren = new MTokKanren();
        $dataToKanren = json_decode($formInputs['gridSearchItems']);
        foreach ($dataToKanren as $item) {
            $editFlg = $formInputs['edit_flg-' . $item->key];
            $item->sousai_flg = $formInputs['sousai_flg-' . $item->key];
            $item->del_flg = $formInputs['del_flg-' . $item->key];
            unset($item->tok_nm, $item->key, $item->edit_flg);
            if ($editFlg) {
                $item->tok_cd = $tokCd;
                $item->tok_cd2 = '000';
                $qbTokKanren = $mTokKanren->where('tok_cd', $item->tok_cd)->where('user_tok_cd', $item->user_tok_cd)->where('del_flg', false);
                $item->upd_user_id = 98;
                $item->upd_dt =  now();
                if ($qbTokKanren->exists()) {
                    $qbTokKanren->update((array)$item);
                } else {
                    $item->upd_user_id = 98;
                    $item->ins_dt =  now();
                    $mTokKanren->insert((array)$item);
                }
            }
        }
    }
    public function delete($tokCd, $tokCd2)
    {
        try {
            DB::beginTransaction();
            $values = [
                'del_flg'       => TRUE,
                'upd_dt'        => now(),
                'upd_user_id'   => 99,
            ];

            MTokuisaki::where('tok_cd', $tokCd)->where('tok_cd2', $tokCd2)->update($values);
            MTokKanren::where('tok_cd', $tokCd)->where('tok_cd2', $tokCd2)->update($values);
            DB::commit();

            session()->flash('success', __('messages.MSG_INF_005'));
            return response()->json([
                'success'   => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            logger()->info($e->getMessage());
            return response()->json([
                'success'   => false,
                'msg'       => __('messages.MSG_ERR_017'),
            ]);
        }
    }

    public function addItemGird(TokKanrenRequest $request)
    {
        $items = json_decode($request->gridSearchItems);
        foreach ($items as $item) {
            $item->sousai_flg = $request->{'sousai_flg-' . $item->key};
            $item->edit_flg = $request->{'edit_flg-' . $item->key};
            $item->del_flg = $request->{'del_flg-' . $item->key};
        }
        $data = array_merge($items, [
            count($items) => [
                'user_tok_cd' => $request->user_tok_cd,
                'user_tok_cd2' => $request->user_tok_cd2,
                'tok_nm' => $request->user_tok_nm,
                'sousai_flg' => $request->sousai_flg,
                'tok_cd' => $request->mode == 'create' ? null : $request->tok_cd,
                'tok_cd2' =>  $request->mode == 'create' ? null : $request->tok_cd,
                'edit_flg' => 1,
                'del_flg' => 0,
                'key' => $request->tok_cd . '-' . $request->tok_cd2 . '-' . $request->user_tok_cd . '-' . $request->user_tok_cd2
            ]
        ]);
        $pagination = new LengthAwarePaginator($data, count($data), config('params.perPageOptions.50'));
        $data = $request->input();
        $data['user_tok_cd'] = '';
        return back()->withInput(array_merge(['pagination' => $pagination], $data));
    }
}
