<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Grid\GridSearch;
use Illuminate\Support\Facades\DB;
use App\Models\MCode;
use App\Helpers\Common;
use App\Http\Requests\PG402Request;
use App\Models\MHaigoKey;
use App\Models\MHaigoKeyMei;

class HaigoKeyController extends Controller
{
    public $code = 'K51';

    public $routeIndex = 'haigo_key.index';

    public function index()
    {
        $mCode = new MCode();
        $mHaigoKey = new MHaigoKey();
        $listSeihinKbn = $mCode->getDataCombobox('K51');
        $GridSearch = new GridSearch('PG401');
        $qb = $mHaigoKey->listPG401();
        $qb = Common::applyOtherWhereSearch($GridSearch, $qb);
        $GridSearch->paginate($qb);
        return view('haigo_key.index', ['GridSearch' => $GridSearch, 'listSeihinKbn' => $listSeihinKbn]);
    }

    public function create()
    {
        $GridSearch             = new GridSearch('PG402');
        $mCode                  = new MCode();
        $recordHaigoKey         = (object)[];
        $GridSearch->pagination = Common::returnEmptyPagination();
        $listSeihinKbn          = $mCode->getDataCombobox($this->code);
       
        data_set($GridSearch->gridResultTable, 'mode', 'create');
        
        return view('haigo_key.form', compact('GridSearch', 'recordHaigoKey', 'listSeihinKbn'));
    }
    public function edit($key)
    {
        return $this->showForm('edit', $key);
    }
    public function copy($key)
    {
        return $this->showForm('copy', $key);
    }
    private function showForm($mode, $key)
    {
        $GridSearch     = new GridSearch('PG402');
        $mCode          = new MCode();
        $listSeihinKbn  = $mCode->getDataCombobox($this->code);

        // form
        $qbHaigoKey     = MHaigoKey::where(['del_flg' => FALSE, 'haigo_key' => $key]);
        $recordHaigoKey = $qbHaigoKey->first();
        
        if (empty($recordHaigoKey)) {
            session()->flash('error', __('messages.MSG_ERR_020')); // show alert
            session()->flash('url', route($this->routeIndex));
        }
        // table
        $model  = new MHaigoKeyMei();
        $qb     = $model->listPG402($key);
        
        $GridSearch->paginate($qb);
        data_set($GridSearch->gridResultTable, 'mode', $mode);
        
        return view('haigo_key.form', compact('GridSearch', 'recordHaigoKey', 'listSeihinKbn'));
    }

    public function save(PG402Request $request)
    {
        $formInputs = $request->all();

        $valuesHaigoKey = [
            'haigo_key'         => $formInputs['haigo_key'] ?? 0,
            'haigo_key_nm'      => $formInputs['haigo_key_nm'] ?? '',
            'seihin_kbn'        => $formInputs['seihin_kbn'] ?? '',
            'flat_base_keisu'   => $formInputs['flat_base_keisu'] ?? 0,
            'del_flg'           => FALSE,
            'upd_dt'            => now(),
            'upd_user_id'       => 99,
            'ins_dt'            => now(),
            'ins_user_id'       => 99,
        ];

        try {
            if ($formInputs['mode'] == 'create') {
                $res = MHaigoKey::create($valuesHaigoKey);
                session()->flash('success', __('messages.MSG_INF_003'));
                return response()->json([
                    'success'   => true, 
                    'msg'       => __('messages.MSG_INF_003'), 
                    'url'       => route($this->routeIndex),
                ]);
            }

            if ($formInputs['mode'] == 'copy') {
                DB::beginTransaction();
                try {
                    $res1 = MHaigoKey::create($valuesHaigoKey);
                    $res2 = MHaigoKeyMei::create([
                        'haigo_key'         => $formInputs['haigo_key'] ?? 0,
                        'hin_cd'            => $formInputs['hin_cd'] ?? 0,
                        'kikaku_cd'         => $formInputs['kikaku_cd'] ?? 0,
                        'ganryo_kbn'        => $formInputs['ganryo_kbn'] ?? '',
                        'bihikuru_keisu'    => $formInputs['bihikuru_keisu'] ?? 0,
                        'tonyu_group_no'    => $formInputs['tonyu_group_no'] ?? 0,
                        'disp_jun'          => $formInputs['disp_jun'] ?? 0,
                        'del_flg'           => FALSE,
                        'upd_dt'            => now(),
                        'upd_user_id'       => 99,
                        'ins_dt'            => now(),
                        'ins_user_id'       => 99,
                    ]);
                    DB::commit();
                    session()->flash('success', __('messages.MSG_INF_003'));
                    return response()->json([
                        'success'   => true, 
                        'msg'       => __('messages.MSG_INF_003'), 
                        'url'       => route($this->routeIndex),
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger()->info($e->getMessage());
                    return response()->json([
                        'success'   => false, 
                        'msg'       => __('messages.MSG_ERR_016'), 
                    ]);
                }
                
            }
            
            if ($formInputs['mode'] == 'edit') {
                $res = MHaigoKey::where('haigo_key', $formInputs['haigo_key'])
                                ->update([
                                    'haigo_key_nm'      => $formInputs['haigo_key_nm'] ?? '',
                                    'seihin_kbn'        => $formInputs['seihin_kbn'] ?? '',
                                    'flat_base_keisu'   => $formInputs['flat_base_keisu'] ?? 0,
                                    'upd_dt'            => now(),
                                    'upd_user_id'       => 99,
                            ]);
                session()->flash('success', __('messages.MSG_INF_004'));
                return response()->json([
                    'success'   => true, 
                    'msg'       => __('messages.MSG_INF_004'), 
                    'url'       => route($this->routeIndex),
                ]);
            }
        } catch (\Exception $e) {
            logger()->info($e->getMessage());
            return response()->json([
                'success'   => false, 
                'msg'       => __('messages.MSG_ERR_016'), 
            ]);
        }
    }

    public function delete(PG402Request $request)
    {
        $formInputs = $request->all();

        DB::beginTransaction();
        try {
            $values = [
                'del_flg'       => TRUE,
                'upd_dt'        => now(),
                'upd_user_id'   => 99,
            ];
            
            $upd1 = MHaigoKey::where('haigo_key', $formInputs['haigo_key'])->update($values);
            $upd2 = MHaigoKeyMei::where('haigo_key', $formInputs['haigo_key'])->update($values);

            DB::commit();

            session()->flash('success', __('messages.MSG_INF_005'));
            return response()->json([
                'success'   => true, 
                'msg'       => __('messages.MSG_INF_005'), 
                'url'       => route($this->routeIndex),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('danger', __('messages.MSG_ERR_017'));
            logger()->info($e->getMessage());
            return response()->json([
                'success'   => false, 
                'msg'       => __('messages.MSG_ERR_017'), 
            ]);
        }
    }
}
