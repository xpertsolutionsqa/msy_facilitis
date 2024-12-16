<div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="update_min_model">
    <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">{{ __('Update Maintenance') }} </h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('maintenance.edit') }} " enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" value="{{$min->id}}" name="id" />
                        <input type="hidden" value="{{$min->number}}" name="number" />
                        <div class="form-groug row p-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="first">{{ __('From Date') }}</span>
                                        </div>
                                        <input type="date" value="{{substr($min->startDate,0,10)}}" class="form-control required" name="start_date">
                                        <input type="time" value="{{substr($min->startDate,11,5)}}" class="form-control required" name="start_time">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="first">{{ __('To Date') }}</span>
                                        </div>
                                        <input type="date" value="{{substr($min->endDate,0,10)}}" class="form-control required" name="end_date">
                                        <input type="time" value="{{substr($min->endDate,11,5)}}" class="form-control required" name="end_time">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-md-12">
                                <label for="">{{ __('Maintenance Team') }}</label>
                                <textarea name="team" class="form-control" rows="5">{!! $min->team !!}</textarea>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-md-12">
                                <label for="">{{ __('Maintenance Agenda') }}</label>
                                <textarea name="notes" class="form-control" rows="5">{!! $min->description !!}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-danger btn-block" data-dismiss="modal"
                                    aria-label="Close"> {{ __('Cancel') }} </button>
                            </div>
                            <div class="col-6">
                                <button class="btn-block btn btn-outline-warning"
                                    type="submit">{{ __('Update') }}</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var deleteModel = new bootstrap.Modal(document.getElementById('update_min_model'), {});
    deleteModel.show();
</script>
