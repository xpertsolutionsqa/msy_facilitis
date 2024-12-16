<div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="delete_user_model">
    <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">{{ __('Delete Facility') }} </h3>
            </div>
            <div class="modal-body">
                <div class="text-center p-5">
                    <div class="alert alert-secondary p-3 text-center">
                        <p class="text-center h3">{{ __('Are Your Sure You Want To Delete') }}
                            <b>{{ $facility->title }}</b>
                            {{ __('messages.?') }}
                        </p>   
                    </div>
                </div>
                <form action="{{ route('facility.delete') }} " method="post">
                    @csrf

                    <input type="hidden" name="id" value="{{ $facility->id }}">
                    <input type="hidden" name="number" value="{{ $facility->number }}">
                    <div class="row">
                        <div class="col-3">
                            <button type="button" class="btn btn-outline-danger btn-block" data-dismiss="modal"
                                aria-label="Close"> {{ __('Cancel') }} </button>
                        </div>
                        <div class="col-9">

                            <button class="btn-block btn btn-outline-danger" type="submit">{{ __('Delete') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var deleteModel = new bootstrap.Modal(document.getElementById('delete_user_model'), {});
    deleteModel.show();
</script>
