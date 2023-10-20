<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HaigoKeyMeiRequest;
use App\Models\MCode;
use App\Models\MHinmoku;
use App\Models\MHaigoKey;
use App\Models\MHaigoKeyMei;
use App\Models\MKikaku;
use Carbon\Carbon;
use DB;

class HaigoKeyMeiController extends Controller
{
    protected $mCode;
    protected $mHinmoku;
    protected $mHaigoKey;
    protected $mHaigoKeyMei;
    protected $mKikaku;

    public function __construct(MCode $mCode, MHinmoku $mHinmoku, MHaigoKey $mHaigoKey, MHaigoKeyMei $mHaigoKeyMei, MKikaku $mKikaku) {
        $this->mCode = $mCode;
        $this->mHinmoku = $mHinmoku;
        $this->mHaigoKey = $mHaigoKey;
        $this->mHaigoKeyMei = $mHaigoKeyMei;
        $this->mKikaku = $mKikaku;
    }

    public function create(Request $rq, $haigoKeyCd)
    {   
        $oldForm = $rq;
        $mode = 'create';
        $mHinmokus = $this->mHinmoku->list();
        $haigoKey = $this->mHaigoKey->getHaigoKeyJoinCode($haigoKeyCd, 'K51');
        $mCodes = $this->mCode->list([['code', '=', 'K64']]);
        $haigoKeyMei = null;
        return view('haigo_key_mei.form', compact('mHinmokus', 'mCodes', 'haigoKey', 'haigoKeyMei', 'oldForm', 'haigoKeyCd', 'mode'));
    }

    public function store(HaigoKeyMeiRequest $rq) 
    {   
        DB::begintransaction();
        try {
            $this->mHaigoKeyMei->insert([
                'haigo_key' => $rq->haigo_key,
                'hin_cd' => $rq->hin_cd,
                'kikaku_cd' => $rq->kikaku_cd,
                'ganryo_kbn' => $rq->ganryo_kbn ?? '',
                'bihikuru_keisu' => $rq->bihikuru_keisu ?? 0,
                'tonyu_group_no' => $rq->tonyu_group_no ?? 0,
                'disp_jun' => $rq->disp_jun ?? 0,
                'ver' => 0,
                'del_flg' => false,
                'upd_user_id' => \Auth::check() ? \Auth::user()->user_id : '',
                'upd_dt' => Carbon::now(),
                'ins_dt' => Carbon::now(),
                'ins_user_id' => \Auth::check() ? \Auth::user()->user_id : '',
            ]);
            DB::commit();
            session()->flash('success', __('messages.MSG_INF_003'));
        } catch(\Exception $e) {
            DB::rollback();
            \Log::error('INSERT HAIGO_KEY_MEI::'. $e->getMessage());
            return back()->withInput()->withErrors(['messageError' => trans('messages.MSG_ERR_016')]);
        }
        return redirect()->route('haigo_key.edit', ['haigoKey' => $rq->haigo_key])->withInput($rq->input());
    }

    public function edit(Request $rq, $haigoKeyCd, $hinCd, $kikakuCd)
    {
        $mode = 'edit';
        $oldForm = $rq;
        $haigoKey = $this->mHaigoKey->getHaigoKeyJoinCode($haigoKeyCd, 'K51');
        $mCodes = $this->mCode->list([['code', '=', 'K64']]);
        $mHinmokus = $this->mHinmoku->list();
        $query = $this->mHaigoKeyMei->getQuery();
        $query->select(
                    'm_haigo_key_mei.haigo_key',
                    'm_haigo_key_mei.hin_cd',
                    'm_haigo_key_mei.kikaku_cd',
                    'm_haigo_key_mei.ganryo_kbn',
                    'm_haigo_key_mei.bihikuru_keisu',
                    'm_haigo_key_mei.tonyu_group_no',
                    'm_haigo_key_mei.disp_jun',
                    'K19.name as K19',
                    'C112.name as C112',
                    'K17.name as K17',
                    'C113.name as C113',
                    'C114.name as C114',
                    'C115.name as C115'
                );
        $query->join('m_kikaku', 'm_kikaku.kikaku_cd', 'm_haigo_key_mei.kikaku_cd');
        
        $where = [
            ['m_haigo_key_mei.haigo_key', '=', $haigoKeyCd],
            ['m_haigo_key_mei.del_flg', '=', false],
            ['m_haigo_key_mei.kikaku_cd', '=', $kikakuCd],
            ['m_haigo_key_mei.hin_cd', '=', $hinCd],
        ];
        $haigoKeyMei = $this->getQueryhaigoKeyMei($query, $where, $hinCd)->first();
        return view('haigo_key_mei.form', compact('mHinmokus', 'mCodes', 'haigoKey', 'haigoKeyMei', 'oldForm', 'haigoKeyCd', 'hinCd', 'kikakuCd', 'mode'));
    }

    public function update(HaigoKeyMeiRequest $rq, $haigoKeyCd, $hinCd, $kikakuCd)
    {
        DB::begintransaction();
        try {
            $this->mHaigoKeyMei->where([
                ['haigo_key' , '=', $rq->haigo_key],
                ['hin_cd', '=', $rq->hin_cd],
                ['kikaku_cd', '=', $rq->kikaku_cd],
                ['del_flg', '=', false]
            ])->update([
                'ganryo_kbn' => $rq->ganryo_kbn ?? '',
                'bihikuru_keisu' => $rq->bihikuru_keisu ?? 0, 
                'tonyu_group_no' => $rq->tonyu_group_no ?? 0,
                'disp_jun' => $rq->disp_jun ?? 0,
                'ver' => 0,
                'del_flg' => false,
                'upd_user_id' => \Auth::check() ? \Auth::user()->user_id : '',
                'upd_dt' => Carbon::now()
            ]);
            DB::commit();
            session()->flash('success', __('messages.MSG_INF_004'));
        } catch(\Exception $e) {
            DB::rollback();
            \Log::error('UPDATE HAIGO_KEY_MEI::'. $e->getMessage());
            return back()->withInput()->withErrors(['messageError' => trans('messages.MSG_ERR_016')]);
        }
        return redirect()->route('haigo_key.edit', ['haigoKey' => $rq->haigo_key])->withInput($rq->input());
    }

    public function delete(Request $rq, $haigoKeyCd, $hinCd, $kikakuCd)
    {
        DB::begintransaction();
        try {
            $this->mHaigoKeyMei->where([
                ['hin_cd', '=', $hinCd],
                ['haigo_key', '=', $haigoKeyCd],
                ['kikaku_cd', '=', $kikakuCd]
            ])->update([
                'del_flg' => true,
                'upd_user_id' => \Auth::check() ? \Auth::user()->user_id : '',
                'upd_dt' => Carbon::now()
            ]);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            \Log::error('DELETE HAIGO_KEY_MEI:'. $e->getMessage());
            return back()->withInput()->withErrors(['messageError' => trans('messages.MSG_ERR_016')]);
        }
        session()->flash('success', __('messages.MSG_INF_005'));
        return redirect()->route('haigo_key.edit', ['haigoKey' => $rq->haigo_key])->withInput($rq->input());
    }

    public function ajax(Request $rq)
    {   
        if(!$rq->ajax()) {
            abort(403);
        }

        if($rq->key) {
            $id = $rq->id;
            switch ($rq->key) {
                case 'hin_cd':
                    $data['hin_cd'] = DB::table('m_hinmoku')->where('del_flg', false)->where('hin_cd', $id)->first();
                    $query = $this->mKikaku->getQuery();
                    $query->select(
                        'm_kikaku.kikaku_cd',
                        'K19.name as K19',
                        'C112.name as C112',
                        'K17.name as K17',
                        'C113.name as C113',
                        'C114.name as C114',
                        'C115.name as C115'
                    );
                    $where = [
                        ['m_kikaku.del_flg', '=', false]
                    ];
                    $data['kikaku_cd'] = $this->getQueryhaigoKeyMei($query, $where, $id)->orderBy('kikaku_cd', 'ASC')->get();
                    break;
                default:
                    $data = [];
                    break;
            }
        }
        return response()->json($data);
    }

    private function getQueryhaigoKeyMei($query, $where, $hinCd) {
        $query->join('m_hinmoku_kikaku', function($join) use ($hinCd) {
            $join->on('m_hinmoku_kikaku.kikaku_cd', '=', 'm_kikaku.kikaku_cd');
            $join->where('m_hinmoku_kikaku.hin_cd', '=', $hinCd);
            $join->on('m_hinmoku_kikaku.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as K19', function($join) {
            $join->on('K19.code', '=', DB::raw("'K19'"));
            $join->on('K19.kbn', '=', 'm_kikaku.tuya_kbn');
            $join->on('K19.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as C112', function($join) {
            $join->on('C112.code', '=', DB::raw("'112'"));
            $join->on('C112.kbn', '=', 'm_kikaku.irime_kbn');
            $join->on('C112.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as K17', function($join) {
            $join->on('K17.code', '=', DB::raw("'K17'"));
            $join->on('K17.kbn', '=', 'm_kikaku.irime_tani_kbn');
            $join->on('K17.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as C113', function($join) {
            $join->on('C113.code', '=', DB::raw("'113'"));
            $join->on('C113.kbn', '=', 'm_kikaku.size_kbn');
            $join->on('C113.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as C114', function($join) {
            $join->on('C114.code', '=', DB::raw("'114'"));
            $join->on('C114.kbn', '=', 'm_kikaku.kejyo_kbn');
            $join->on('C114.del_flg', '=', DB::raw('false'));
        })
        ->leftjoin('m_code as C115', function($join) {
            $join->on('C115.code', '=', DB::raw("'115'"));
            $join->on('C115.kbn', '=', 'm_kikaku.meji_kbn');
            $join->on('C115.del_flg', '=', DB::raw('false'));
        });
        $query->where($where);
        return $query;
    }
}
