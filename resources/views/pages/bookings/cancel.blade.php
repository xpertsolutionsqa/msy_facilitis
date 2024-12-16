<div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="cancel_booking_model">
    <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">{{ __('Cancel Booking') }} </h3>
            </div>
            <div class="modal-body">
                <div class="text-center p-5">
                    <div class="alert alert-secondary p-4 text-center">
                        <p class="h3">{{ __('Are Your Sure You Want To Cancel') }} <b>{{ $booking->event_name }} #
                                {{ $booking->number }}</b>
                            {{ __('messages.?') }} </p>
                    </div>
                </div>
                <form action="{{ route('booking.cancel') }} " method="post">
                    @csrf
                     
                    <input type="hidden" name="id" value="{{ $booking->id }}">
                    <input type="hidden" name="number" value="{{ $booking->number }}">




                    <div class="row">

                        <div class="col-md-12">

                            <button class="btn-block btn btn-outline-danger" type="submit">{{ __('Cancel') }}</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var cancelModel = new bootstrap.Modal(document.getElementById('cancel_booking_model'), {});
    cancelModel.show();
</script>
