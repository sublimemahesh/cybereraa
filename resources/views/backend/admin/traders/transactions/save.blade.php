<div class="row">
    <div class="col-sm-8">
        <form class="theme-form" enctype="multipart/form-data" id="transaction-form">

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="out_usdt">OUT USDT</label>
                <div class="col-sm-9">
                    <input class="form-control" id="out_usdt" name="out_usdt" placeholder="OUT USDT" type="number" value="{{ $transaction->out_usdt ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="usdt_out_time">USDT OUT TIME</label>
                <div class="col-sm-9">
                    <input class="form-control" id="usdt_out_time" name="usdt_out_time" placeholder="USDT OUT TIME" type="datetime-local" value="{{ $transaction->usdt_out_time ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="in_usdt">IN USDT</label>
                <div class="col-sm-9">
                    <input class="form-control" id="in_usdt" name="in_usdt" placeholder="IN USDT" type="number" value="{{ $transaction->in_usdt ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="usdt_in_time">USDT IN TIME</label>
                <div class="col-sm-9">
                    <input class="form-control" id="usdt_in_time" name="usdt_in_time" placeholder="USDT IN TIME" type="datetime-local" value="{{ $transaction->usdt_in_time ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="reference">REFERENCE</label>
                <div class="col-sm-9">
                    <input class="form-control" id="reference" name="reference" placeholder="REFERENCE" type="text" value="{{ $transaction->reference ?? null }}">
                </div>
            </div>


            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" id="{{ $btn_id }}-transaction" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            const TRADER_ID = '{{ $trader->id ?? null }}'
            const TRANSACTION_ID = '{{ $transaction->id ?? null }}'
        </script>
    @endpush
</div>
