<div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="edit_booking_model">
    <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">{{ __('Edit Booking') }} </h3>
            </div>
            <div class="modal-body">

                <form action="{{ route('booking.cancel') }} " method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $booking->id }}">
                    <input type="hidden" name="number" value="{{ $booking->number }}">

                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control required" name="event_name" value="{{ $booking->event_name }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control required" name="event_name" value="{{ $booking->event_name }}">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control required" name="event_name" value="{{ $booking->event_name }}">
                        </div>
                    </div>






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
    var cancelModel = new bootstrap.Modal(document.getElementById('edit_booking_model'), {});
    cancelModel.show();
</script>
