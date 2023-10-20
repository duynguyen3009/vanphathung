@php
  $items = [
    'hinmoku.index', // 品目マスタメンテ
    'hanbai_kojo_hinmoku.index',// 販売工場別＆製造工場別品目マスタメンテ
    'ganryo_pump.index', //顔料ポンプマスタ
    'haigo_key.index', //配合キーマスタ
    'shiire.index', //仕入先マスタ
    'tokuisaki.index', //得意先マスタ
  ];
@endphp
@extends('layouts.app')
@section('main')
  <div class="row">
    <div class="col-md-12 stretch-card grid-margin">
      <div class="card">
        <div class="card-body">
          <p class="card-title">マスタメンテ関連</p>
          <ul class="list-arrow" style="padding-left: 1rem">
            @foreach ($items as $item)
              <li class="m-2"><a href="{{ route($item) }}">
                  {{ $item=='hanbai_kojo_hinmoku.index' ? '販売工場別＆製造工場別品目マスタメンテ' : trans("site.title.{$item}") }}
                </a></li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection
