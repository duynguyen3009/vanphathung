<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Helpers\Grid\GridSearch;
use App\Http\Requests\GanryoPumpRequest;
use App\Helpers\Common;
use App\Models\MGanryoPump;
use App\Models\MGanryoShusei;
use App\Models\MKskyoten;
use App\Models\MHinmoku;
use App\Models\MKojoCode;
use App\Models\MKikaku;

class GanryoPumpController extends Controller
{
    protected $mHinmoku;
    protected $mKskyoten;
    protected $mKojoCode;
    protected $mKikaku;
    protected $mGanryoPump;

    public $routeIndex = 'ganryo_pump.index';

    public function __construct(MKskyoten $mKskyoten, MHinmoku $mHinmoku, MKojoCode $mKojoCode, MKikaku $mKikaku, MGanryoPump $mGanryoPump)
    {
        $this->mKskyoten    = $mKskyoten;
        $this->mHinmoku     = $mHinmoku;
        $this->mKojoCode    = $mKojoCode;
        $this->mKikaku      = $mKikaku;
        $this->mGanryoPump  = $mGanryoPump;
    }

    public function index()
    {
        $GridSearch     = new GridSearch('PG301');
        $listKskyoten   = $this->mKskyoten->getDataCombobox();
        $qb             = $this->mGanryoPump->listPG301();
        $qb             = Common::applyOtherWhereSearch($GridSearch, $qb);
        $GridSearch->paginate($qb);

        return view('ganryo_pump.index', compact('GridSearch', 'listKskyoten'));
    }

    public function create(Request $request)
    {
        $mode               = 'create';
        $transformSearch    = json_decode(request('transform_search', ''));
        $listKskyoten       = $this->mKskyoten->getDataCombobox();
        $listHinmoku        = $this->mHinmoku->list();

        return view('ganryo_pump.form', compact('listKskyoten', 'listHinmoku', 'mode', 'transformSearch'));
    }

    public function edit(Request $request, $ktnCd, $hinCd, $kikakuCd, $dispenserKbn)
    {
        $mode               = 'edit';
        $transformSearch    = json_decode(request('transform_search', ''));
        $record             = $this->mGanryoPump->getRecord($ktnCd, $hinCd, $kikakuCd, $dispenserKbn)->first();
        $listKskyoten       = $this->mKskyoten->getDataCombobox();
        $listHinmoku        = $this->mHinmoku->list();
        $listKojoCode       = $this->mKojoCode->list($ktnCd)->pluck('kbn', 'kbn');
        $listKikaku         = $this->mKikaku->getListCombobox($hinCd);

        return view('ganryo_pump.form', compact('listKskyoten', 'listHinmoku', 'listKojoCode', 'listKikaku', 'mode', 'transformSearch', 'record'));
    }

    public function copy(Request $request, $ktnCd, $hinCd, $kikakuCd, $dispenserKbn)
    {
        $mode               = 'copy';
        $transformSearch    = json_decode(request('transform_search', ''));
        $record             = $this->mGanryoPump->getRecord($ktnCd, $hinCd, $kikakuCd, $dispenserKbn)->first();
        $listKskyoten       = $this->mKskyoten->getDataCombobox();
        $listHinmoku        = $this->mHinmoku->list();
        $listKojoCode       = $this->mKojoCode->list($ktnCd)->pluck('kbn', 'kbn');
        $listKikaku         = $this->mKikaku->getListCombobox($hinCd);

        return view('ganryo_pump.form', compact('listKskyoten', 'listHinmoku', 'listKojoCode', 'listKikaku', 'mode', 'transformSearch', 'record'));
    }

    public function store(GanryoPumpRequest $request)
    {
        $formInputs = $request->all();
        $loginUserId = data_get(Auth::user(), 'user_id', null);

        DB::beginTransaction();
        try {
            if ($formInputs['mode'] == 'create' || $formInputs['mode'] == 'copy') {
                $res1 = MGanryoPump::create([
                    'ktn_cd'                => $formInputs['ktn_cd'] ?? 0,
                    'hin_cd'                => $formInputs['hin_cd'] ?? 0,
                    'kikaku_cd'             => $formInputs['kikaku_cd'] ?? 0,
                    'dispenser_kbn'         => $formInputs['dispenser_kbn'] ?? 0,
                    'lot_no'                => $formInputs['lot_no'] ?? 0,
                    'keisu'                 => $formInputs['keisu'] ?? 0,
                    'hakidasu_ryo_nama_dai' => empty(data_get($formInputs, 'row1.average')) ?  data_get($formInputs, 'row1.hakidasu_ryo_nama_dai') : data_get($formInputs, 'row1.average'),
                    'hakidasu_ryo_nama_sho' => empty(data_get($formInputs, 'row2.average')) ?  data_get($formInputs, 'row2.hakidasu_ryo_nama_sho') : data_get($formInputs, 'row2.average'),
                    'hakidasu_ryo_usu_dai'  => empty(data_get($formInputs, 'row3.average')) ?  data_get($formInputs, 'row3.hakidasu_ryo_usu_dai') : data_get($formInputs, 'row3.average'),
                    'hakidasu_ryo_usu_sho'  => empty(data_get($formInputs, 'row4.average')) ?  data_get($formInputs, 'row4.hakidasu_ryo_usu_sho') : data_get($formInputs, 'row4.average'),
                    'del_flg'               => FALSE,
                    'upd_dt'                => now(),
                    'upd_user_id'           => $loginUserId,
                    'ins_dt'                => now(),
                    'ins_user_id'           => $loginUserId,
                ]);

                DB::commit();

                session()->flash('success', __('messages.MSG_INF_003'));
                return response()->json([
                    'success'   => true,
                    'msg'       => __('messages.MSG_INF_003'),
                    'url'       => route($this->routeIndex),
                ]);
            }
            if ($formInputs['mode'] == 'edit') {
                $where = [
                    'ktn_cd'        => $formInputs['ktn_cd'],
                    'hin_cd'        => $formInputs['hin_cd'],
                    'kikaku_cd'     => $formInputs['kikaku_cd'],
                    'dispenser_kbn' => $formInputs['dispenser_kbn'],
                ];

                $res1 = MGanryoPump::where($where)
                                ->update([
                                    'lot_no'                => $formInputs['lot_no'] ?? 0,
                                    'keisu'                 => $formInputs['keisu'] ?? 0,
                                    'hakidasu_ryo_nama_dai' => empty(data_get($formInputs, 'row1.average')) ?  data_get($formInputs, 'row1.hakidasu_ryo_nama_dai') : data_get($formInputs, 'row1.average'),
                                    'hakidasu_ryo_nama_sho' => empty(data_get($formInputs, 'row2.average')) ?  data_get($formInputs, 'row2.hakidasu_ryo_nama_sho') : data_get($formInputs, 'row2.average'),
                                    'hakidasu_ryo_usu_dai'  => empty(data_get($formInputs, 'row3.average')) ?  data_get($formInputs, 'row3.hakidasu_ryo_usu_dai') : data_get($formInputs, 'row3.average'),
                                    'hakidasu_ryo_usu_sho'  => empty(data_get($formInputs, 'row4.average')) ?  data_get($formInputs, 'row4.hakidasu_ryo_usu_sho') : data_get($formInputs, 'row4.average'),
                                    'upd_dt'                => now(),
                                    'upd_user_id'           => $loginUserId,
                            ]);

                DB::commit();
                session()->flash('success', __('messages.MSG_INF_004'));
                return response()->json([
                    'success'   => true,
                    'msg'       => __('messages.MSG_INF_004'),
                    'url'       => route($this->routeIndex),
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->info($e->getMessage());
            return response()->json([
                'success'   => false,
                'msg'       => __('messages.MSG_ERR_016'),
            ]);
        }
    }

    public function delete(Request $request)
    {
        $formInputs = $request->all();

        DB::beginTransaction();
        try {
            $values = [
                'del_flg'       => TRUE,
                'upd_dt'        => now(),
                'upd_user_id'   => data_get(Auth::user(), 'user_id', null),
            ];

            $upd1 = MGanryoPump::where([
                'ktn_cd'        => $formInputs['ktn_cd'],
                'dispenser_kbn' => $formInputs['dispenser_kbn'],
                'hin_cd'        => $formInputs['hin_cd'],
                'kikaku_cd'     => $formInputs['kikaku_cd'],
            ])->update($values);

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

    public function ajax(Request $request)
    {
        if(!$request->ajax()) {
            abort(403);
        }

        if($request->type) {
            $value = $request->value;
            switch ($request->type) {
                case 'ktn_cd':
                    $data = $this->mKojoCode->list($value)->pluck('kbn', 'kbn');
                    break;
                case 'hin_cd':
                    $data = $this->mKikaku->getListCombobox($value);
                    break;
                default:
                    $data = [];
                    break;
            }
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
