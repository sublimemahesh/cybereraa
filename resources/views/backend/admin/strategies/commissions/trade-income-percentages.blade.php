<div class="row">
    <div class="col-sm-8">
        <div class="form-group row mb-2">
            <label class="col-sm-3 col-form-label" for="trade_income_level_count">Commission Level Count</label>
            <div class="col-sm-9">
                <input class="form-control" id="trade_income_level_count" name="trade_income_level_count" value="{{ count($trade_income) }}" type="number">
            </div>
        </div>
        <div id="level-income-inputs">
            @foreach($trade_income as $level => $income)
                <div class="form-group row mb-2" id="trade-income-level-{{ $level }}">

                    <label class="col-sm-3 col-form-label" for="trade_income.{{ $level }}">Trade Income Level {{ $level }} (%)</label>

                    <div class="col-sm-9">
                        <input class="form-control" data-input="trade_income" id="trade_income.{{ $level }}" name="trade_income[{{ $level }}]" value="{{ $income }}" placeholder="Trade Income" type="number">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
