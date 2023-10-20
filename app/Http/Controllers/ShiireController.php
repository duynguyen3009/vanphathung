<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Common;
use App\Helpers\Grid\GridSearch;
use App\Models\MShiire;
use App\Models\MKoza;
use App\Models\MBusho;
use App\Models\MUser;
use App\Http\Requests\ShiireRequest;

class ShiireController extends Controller
{
    private $mShiire;
    private $mKoza;
    private $mBusho;
    private $mUser;
    public function __construct(MShiire $mShiire, MKoza $mKoza, MBusho $mBusho, MUser $mUser) {
        $this->mShiire = $mShiire;
        $this->mKoza = $mKoza;
        $this->mBusho = $mBusho;
        $this->mUser = $mUser;
    }

    public function index()
    {
        $GridSearch = new GridSearch('PG501');
        $mShiire = $this->mShiire;
        $qb = $mShiire->getList();
        $qb = Common::applyOtherWhereSearch($GridSearch, $qb);
        $GridSearch->paginate($qb);
        $pageTitle = trans('site.title.shiire.index');
        
        return view('shiire.index', ['GridSearch' => $GridSearch, 'pageTitle' => $pageTitle]);
    }

    public function create (Request $request) {
        $pageTitle = trans('site.title.shiire.create');
        return view('shiire.form',[
            'mode' => 'create',
            'request' => $request->all(),
            'pageTitle' => $pageTitle,
            'dataCombobox' => $this->getDataCombobox(),
            'data' => []
        ]);
    }

    public function edit(Request $request, $shiire_cd)
    {
        $pageTitle = trans('site.title.shiire.edit');
        $shiire_cd2 = $request->input('shiire_cd2');
        $data = $this->mShiire->getDataDetail($shiire_cd, $shiire_cd2);
        $transformSearch    = json_decode(request('transform_search', ''));
        
        return view('shiire.form',[
            'mode' => 'edit',
            'request' => [
                "GridSearchForm" => $transformSearch
            ],
            'pageTitle' => $pageTitle,
            'dataCombobox' => $this->getDataCombobox(),
            'data' => $data
        ]);
    }

    public function store (ShiireRequest $request) {
        DB::beginTransaction();
        
        try {
            $dataInsert = array_merge($request->all(), [
            'shiire_cd2' => '000',
            'upd_user_id' => Auth::check() ? Auth::user()->id : '', 
            'ins_user_id' => Auth::check() ? Auth::user()->id : '',]);
            $this->mShiire->create($dataInsert);

            $this->mKoza->insert([
                'm_koza_id' => $request->input('shiire_cd'),
                'kinyu_nm' => $request->input('kinyu_nm'),
                'kinyu_siten_nm' => $request->input('kinyu_siten_nm'),
                'koza_type' => $request->input('koza_type'),
                'koza_no' => $request->input('koza_no'),
                'koza_meigi' => $request->input('koza_meigi'),
                'del_flg' => false,
                'upd_dt' => Carbon::now(),
                'upd_user_id' => Auth::check() ? Auth::user()->id : '',
                'ins_dt' => Carbon::now(),
                'ins_user_id' => Auth::check() ? Auth::user()->id : '',
            ]);
            DB::commit();

        } catch (\Exception $except) {
            DB::rollBack();
            if ($except instanceof \Illuminate\Database\QueryException) {
                $errorInfo = $except->errorInfo;
                $ErrorMessage = $errorInfo[2];
                return redirect()->back()->with('errorInsert',  $ErrorMessage);
            }
        }
        return redirect()->route('shiire.index');
    }

    public function update (ShiireRequest $request) {
        DB::beginTransaction();
        
        try {
            $this->mShiire
            ->where([
                ['shiire_cd', '=', $request->input('shiire_cd')],
                ['shiire_cd2', '=', '000'],
            ])
            ->update([
                'shiire_nm2' => $request->input('shiire_nm2'),
                'tel_no' => $request->input('tel_no'),
                'fax_no' => $request->input('fax_no'),
                'hatchu_fax_send_flg' => $request->input('hatchu_fax_send_flg'),
                'jyu_fax_no' => $request->input('jyu_fax_no'),
                'jyu_mail_adr' => $request->input('jyu_mail_adr'),
                'cellmail_adr' => $request->input('cellmail_adr'),
                'tan_nm' => $request->input('tan_nm'),
                'uke_busho_cd' => $request->input('uke_busho_cd'),
                'uke_tan_cd' => $request->input('uke_tan_cd'),
                'eig_tan_cd' => $request->input('eig_tan_cd'),
                'sime_tm' => $request->input('sime_tm'),
                'shitaukeho_note' => $request->input('shitaukeho_note'),
                'kenshuhokokusho_fax_send_kyoka' => $request->input('kenshuhokokusho_fax_send_kyoka'),
                'sizaibu_flg' => $request->input('sizaibu_flg'),
                'hatchu_mail_adr' => $request->input('hatchu_mail_adr'),
                'kenshusho_send_flg' => $request->input('kenshusho_send_flg'),
                'shiire_g2' => $request->input('shiire_g2'),
                'm_koza_id' => $request->input('m_koza_id'),
                'shiire_nm' => $request->input('shiire_nm'),
                'shiire_ryaku_nm' => $request->input('shiire_ryaku_nm'),
                'shiire_kana_ryaku_nm' => $request->input('shiire_kana_ryaku_nm'),
                'yubin_no' => $request->input('yubin_no'),
                'adr_ken' => $request->input('adr_ken'),
                'adr_si' => $request->input('adr_si'),
                'adr_tyo' => $request->input('adr_tyo'),
                'adr_ban' => $request->input('adr_ban'),
                'adr_bil' => $request->input('adr_bil'),
                'shiire_kbn' => $request->input('shiire_kbn'),
                'eig_busho_cd' => $request->input('eig_busho_cd'),
                'ksjig_cd' => $request->input('ksjig_cd'),
                'saimu_keijo_saki_shiire_cd' => $request->input('saimu_keijo_saki_shiire_cd'),
                'saimu_keijo_saki_shiire_cd2' => $request->input('saimu_keijo_saki_shiire_cd2'),
                'jigyosho_num' => $request->input('jigyosho_num'),
                'hatyusho_send_flg' => $request->input('hatyusho_send_flg'),
                'shiire_g1' => $request->input('shiire_g1'),
                'shiire_g3' => $request->input('shiire_g3'),
                'shiire_cd2' => '000',
                'del_flg' => false,
                'upd_dt' => Carbon::now(),
                'upd_user_id' => Auth::check() ? Auth::user()->id : '',
            ]);

            $this->mKoza
            ->where('m_koza_id', '=', $request->input('m_koza_id'))
            ->update([
                'kinyu_nm' => $request->input('kinyu_nm'),
                'kinyu_siten_nm' => $request->input('kinyu_siten_nm'),
                'koza_type' => $request->input('koza_type'),
                'koza_no' => $request->input('koza_no'),
                'koza_meigi' => $request->input('koza_meigi'),
                'del_flg' => false,
                'upd_dt' => Carbon::now(),
                'upd_user_id' => Auth::check() ? Auth::user()->id : '',
            ]);
            DB::commit();

        } catch (\Exception $except) {
            DB::rollBack();
            if ($except instanceof \Illuminate\Database\QueryException) {
                $errorInfo = $except->errorInfo;
                $ErrorMessage = $errorInfo[2];
                return redirect()->back()->with('errorInsert',  $ErrorMessage);
            }
        }
        return redirect()->route('shiire.index');

    }

    public function delete (Request $request) {
        DB::beginTransaction();
        
        try {

            $this->mShiire->where([
                ['shiire_cd', '=', $request->input('shiire_cd')],
                ['shiire_cd2', '=', '000'],
            ])
            ->update([
                'del_flg' => true,
                'upd_dt' => Carbon::now(),
                'upd_user_id' => Auth::check() ? Auth::user()->id : '',
            ]);

            $this->mKoza->where('m_koza_id', '=', $request->input('m_koza_id'))
            ->update([
                'del_flg' => true,
                'upd_dt' => Carbon::now(),
                'upd_user_id' => Auth::check() ? Auth::user()->id : '',
            ]);;
            DB::commit();

        } catch (\Exception $except) {
            DB::rollBack();
            if ($except instanceof \Illuminate\Database\QueryException) {
                $errorInfo = $except->errorInfo;
                $ErrorMessage = $errorInfo[2];
                return redirect()->back()->with('errorInsert',  $ErrorMessage);
            }
        }
        return redirect()->route('shiire.index');
    }

    public function getDataCombobox () {
        $shiire_kbn = $this->mShiire->getCodeCombobox('116');
        
        foreach ($this->mShiire->getSaimuKeijoSakiShiireCd() as $value) {
            $saimu_keijo_saki_shiire_cd[$value->shiire_cd] = $value->shiire_cd;
        }
        
        foreach ($this->mKoza->getMKoza() as $value) {
            $m_koza_id[$value->m_koza_id] = $value->m_koza_id;
        }

        foreach ($this->mBusho->getMBusho() as $value) {
            $busho_cd[$value->busho_cd] = $value->busho_cd;
        }

        foreach ($this->mUser->getMUser() as $value) {
            $user_id[$value->user_id] = $value->user_id;
        }

        $koza_type = $this->mShiire->getCodeCombobox(122);

        $data = [
            'shiire_kbn' => $shiire_kbn,
            'saimu_keijo_saki_shiire_cd' => $saimu_keijo_saki_shiire_cd,
            'koza_type' => $koza_type,
            'm_koza_id' => $m_koza_id,
            'uke_busho_cd' => $busho_cd,
            'eig_busho_cd' => $busho_cd,
            'uke_tan_cd' => $user_id?? [],
            'eig_tan_cd' => $user_id?? [],
        ];
        return $data;
    }

    public function ajax(Request $request) {
        switch ($request->input('key')) {
            case 'saimu_keijo_saki_shiire_cd':
                $data = $this->mShiire->getSaimuKeijoSakiShiireCd($request->input('saimuKeijoSakiShiireCd'));
                break;
    
            case 'm_koza_id':
                $data = $this->mKoza->getMKoza($request->input('m_koza_id'));
                break;
    
            case 'busho_cd':
                $data = $this->mBusho->getMBusho($request->input('busho_cd'));
                break;
    
            case 'user_id':
                $data = $this->mUser->getMUser($request->input('user_id'));
                break;
    
            default:
                return response()->json(400);
        }
    
        return response()->json(['data' => $data]);
    }
}
