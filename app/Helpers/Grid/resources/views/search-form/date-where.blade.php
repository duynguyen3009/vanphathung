<div class="u-box u-box-flex">
    <div class="u-box-heading">{{ @$label }}</div>
    <div class="u-box-body">
        <div class="input-icon">
            <input type="text" id="datepicker_{{$keyFrom}}"
                   value="{{ $parent->dataRequest($keyFrom) }}"
                   name="{{ $parent->dataRequestName() . "[$keyFrom]" }}"
                   class="form-control form-control-sm w-120px grid-submit datetime" placeholder=""/>
            <div class="input-icon__icon input-icon__icon--right">
                <span><i class="icofont-calendar"></i></span>
            </div>
        </div>
        @if(isset($keyTo))
        <div class="mb-2"></div>
        <div class="input-icon">
            <input type="text" id="datepicker_{{$keyTo}}"
                   value="{{ $parent->dataRequest($keyTo) }}"
                   name="{{ $parent->dataRequestName() . "[$keyTo]" }}"
                   class="form-control form-control-sm w-120px grid-submit datetime" placeholder=""/>
            <div class="input-icon__icon input-icon__icon--right">
                <span><i class="icofont-calendar"></i></span>
            </div>
        </div>
        @endif
    </div>
</div>