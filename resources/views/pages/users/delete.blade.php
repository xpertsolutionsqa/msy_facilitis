<div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="delete_user_model">
    <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">{{ __('Delete User') }} </h3>
            </div>
            <div class="modal-body">
                <div class="text-center p-5">
                    <div class="alert alert-secondary p-4 text-center">
                        <p class="h3">{{ __('Are Your Sure You Want To Delete') }} <b>{{ $user->displayname }}</b>
                            {{ __('messages.?') }} </p>
                    </div>
                </div>
                <form action="{{ route('client.delete') }} " method="post">
                    @csrf
                    <input type="hidden" name="user_type" value="{{ $user->type }}">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <input type="hidden" name="number" value="{{ $user->number }}">




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
