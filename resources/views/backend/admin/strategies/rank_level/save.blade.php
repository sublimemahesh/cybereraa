<div class="card">
    <div class="card-header">
        <h5 class="card-title">Rank level </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="theme-form" enctype="multipart/form-data" id="withdrawal-form">

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank 01</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="rank_level" name=""
                                type="number">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank gift</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="" name="" placeholder="" type="text">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank bonus </label>
                        <div class="col-sm-9">
                            <input class="form-control" id="" name="" placeholder="" type="text">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" id="{{ $btn_id }}-package"
                                class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



{{-- //////////////////////////  rank bonus levels  //////////////////// --}}
<div class="card">
    <div class="card-header">
        <h5 class="card-title"> Rank bonus levels </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="theme-form" enctype="multipart/form-data" id="withdrawal-form">

                    <div id='bonus_textflied'></div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" id="{{ $btn_id }}-package"
                                class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- //////////////////////////  rank  gift levels  //////////////////// --}}
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Rank gift levels </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="theme-form" enctype="multipart/form-data" id="withdrawal-form">

                    <div id='gift_textflied'></div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" id="{{ $btn_id }}-package"
                                class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




{{-- ////////////////////////////  Rank package requirement ///////////////////// --}}

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Rank package requirement</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="theme-form" enctype="multipart/form-data" id="withdrawal-form">

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank 01</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="rank_level" name="" placeholder=""
                                type="text">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank 02</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="" name="" placeholder=""
                                type="text">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank 03</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="" name="" placeholder=""
                                type="text">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank 04</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="" name="" placeholder=""
                                type="text">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank 05</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="" name="" placeholder=""
                                type="text">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank 06</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="" name="" placeholder=""
                                type="text">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="name">Rank 07</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="" name="" placeholder=""
                                type="text">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" id="{{ $btn_id }}-package"
                                class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@push('scripts')
    <script>
        $(document).ready(function() {

            $("#rank_level").keyup(function() {

                $('#gift_textflied').html('');
                $('#bonus_textflied').html('');
                text_rank_level = $("#rank_level").val();

                rank_level = parseInt(text_rank_level);

                if (text_rank_level.trim().length === 0 || rank_level > 7 || rank_level <= 0) {
                    return;
                    alert('dd');
                }





                if (rank_level == 7) {
                    bonus = 5;
                    gift = 2;
                } else if (rank_level % 2 === 0) {
                    gift = 2;
                    bonus = rank_level - gift;
                } else {
                    gift = 1;
                    bonus = rank_level - gift;

                }



                for (i = 0; i < bonus; ++i) {
                    newDiv = $(
                        '<div class="form-group row mb-2">' +
                        '<label class="col-sm-3 col-form-label" for="amount">Rank </label>' +
                        '<div class="col-sm-9">' +
                        '<input class="form-control" id="" name=""  type="text">' +
                        '</div>' +
                        '</div>'
                    );
                    $('#bonus_textflied').append(newDiv);
                }


                for (i = 0; i < gift; ++i) {
                    newDiv = $(
                        '<div class="form-group row mb-2">' +
                        '<label class="col-sm-3 col-form-label" for="amount">Rank Level</label>' +
                        '<div class="col-sm-9">' +
                        '<input class="form-control" id="" name=""  type="text">' +
                        '</div>' +
                        '</div>'
                    );
                    $('#gift_textflied').append(newDiv);
                }
            });
        });
    </script>
@endpush
