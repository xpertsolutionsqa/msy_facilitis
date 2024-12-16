<div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="edit_user_model">
    <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">{{ __('Edit User') }} </h3>
            </div>
            <div class="modal-body">
                @if (isset($user))
                    <form action="{{ route('user.edit') }}" id="createAdminForm" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <input type="hidden" name="number" value="{{ $user->usernumber }}">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('Name') }}</label>
                                <input type="text" class="form-control required" value="{{ $user->displayname }}"
                                    name="displayname">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('User Name') }}</label>
                                <input type="text" class="form-control required" value="{{ $user->username }}"
                                    name="username">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control required" value="{{ $user->email }}"
                                    name="email">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('Phone') }}</label>
                                <input type="text" class="form-control required" value="{{ $user->phone }}"
                                    name="phone">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('Level') }}</label>
                                <select name="level" class="form-control required" id="userEditLevel">
                                    @foreach (\App\Models\UserLevel::all() as $level)
                                        <option {{ $user->level == $level->id ? 'selected' : '' }}
                                            value="{{ $level->id }}">
                                            {{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            
                            <div class="col-md-6" id="editclubselect"
                                style="display: {{ $user->level == '3' ? 'unset' : 'none' }}">
                                <label for="" class="required-label">{{ __('Club') }}</label>
                                <select name="club" id="userEditClub" class="form-control required">
                                    @foreach (\App\Models\Club::all() as $club)
                                        <option {{$user->club_id == $club->id ? 'selected' : ''}} value="{{ $club->id }}"> {{ $club->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="p-1"></div>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-danger btn-block" data-dismiss="modal"
                                    aria-label="Close"> {{ __('Cancel') }} </button>
                            </div>
                            <div class="col-6">

                                <button class="btn-block btn btn-outline-warning"
                                    type="submit">{{ __('Edit') }}</button>
                            </div>
                        </div>


                    </form>
                @else
                    <form action="{{ route('client.edit') }} " method="post">
                        @csrf
                        <input type="hidden" name="user_type" value="{{ $client->type }}">
                        <input type="hidden" name="id" value="{{ $client->id }}">
                        <input type="hidden" name="number" value="{{ $client->number }}">


                        <div class="row">
                            <div class="col-md-12 card  ">
                                <label class="required-label" for="">{{ __('Booker Type') }}</label>
                                <div class="row d-flex justify-content-start align-items-center p-2">

                                    @foreach (\App\Models\UserType::all() as $i => $type)
                                        <div class="d-flex">
                                            <input {{ $client->type == $type->id ? 'checked' : '' }}
                                                id="{{ $type->id }}" name="type"
                                                class="form-control   smallcheck" value="{{ $type->id }}"
                                                type="radio"><span class="space">
                                                {{ $type->getTranslation('title', app()->getlocale()) }} </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row p-3">
                            <div class="col-md-4">
                                <label for="">{{ __('Display Name') }}</label>
                                <input name="displayname" class="form-control" value="{{ $client->displayname }}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('Email') }}</label>
                                <input name="email" type="email" class="form-control"
                                    value="{{ $client->email }}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('Phone') }}</label>
                                <input name="phone" class="form-control" value="{{ $client->phone }}">
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
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('edit_user_model'), {});
    myModal.show();
</script>
