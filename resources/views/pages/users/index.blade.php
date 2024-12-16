@extends('layouts.app')

@section('content')
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="iq-top-navbar-{{ app()->getLocale() }}">
            @include('layouts.header')
        </div>
        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between">

                                <h3>{{ __('Clients') }}</h3>
                                <button class="btn btn-outline-primary" type="button" data-toggle-extra="tab"
                                    data-target="#create_user_model" data-toggle="modal"> {{ __('Add New Client') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" fill="currentColor">
                                        <path
                                            d="M14 14.252V16.3414C13.3744 16.1203 12.7013 16 12 16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM18 17V14H20V17H23V19H20V22H18V19H15V17H18Z">
                                        </path>
                                    </svg></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if (count($users) > 0)
                                    <div class="row">
                                        <div class="col-8">

                                        </div>
                                        <div class="col-md-4">
                                            <input id="myInput" onkeyup="myFunction(1,[1,2,3,4,5]);" type="text"
                                                placeholder="{{ __('Search') }}" class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                    <table id="myTable" class="table table-border rounded">
                                        <thead>
                                            <th>#</th>

                                            <th>{{ __('Number') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('User Name') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Type') }}</th>


                                            <th>{{ __('Created At') }}</th>
                                            <th> </th>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $i => $user)
                                                <tr class="{{ $user->status != '1' ? 'readTR' : '' }}">
                                                    <td>{{ $i + 1 }}</td>


                                                    <td>{{ $user->number }}</td>
                                                    <td>{{ $user->displayname }}</td>
                                                    <td>{{ $user->username }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone }}</td>

                                                    <td>{{ $user->clienttype }}</td>
                                                    <td>{{ $user->created_at }}</td>
                                                    <td>
                                                        <form class="d-inline"
                                                            action="{{ $user->status == '1' ? route('client.disable') : route('client.enable') }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="userId"
                                                                value="{{ $user->id }}">
                                                            <button type="submit"
                                                                class="btn {{ $user->status == '1' ? 'btn-outline-warning' : 'btn-outline-primary' }}">
                                                                {{ $user->status == '1' ? __('Disable') : __('Enable') }}
                                                                @if ($user->status == '1')
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" width="24" height="24"
                                                                        fill="currentColor">
                                                                        <path
                                                                            d="M8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7ZM12 1C8.68629 1 6 3.68629 6 7C6 10.3137 8.68629 13 12 13C15.3137 13 18 10.3137 18 7C18 3.68629 15.3137 1 12 1ZM15 18C15 16.3431 16.3431 15 18 15C18.4631 15 18.9018 15.105 19.2934 15.2924L15.2924 19.2934C15.105 18.9018 15 18.4631 15 18ZM16.7066 20.7076L20.7076 16.7066C20.895 17.0982 21 17.5369 21 18C21 19.6569 19.6569 21 18 21C17.5369 21 17.0982 20.895 16.7066 20.7076ZM18 13C15.2386 13 13 15.2386 13 18C13 20.7614 15.2386 23 18 23C20.7614 23 23 20.7614 23 18C23 15.2386 20.7614 13 18 13ZM12 14C12.0843 14 12.1683 14.0013 12.252 14.0039C11.8236 14.6189 11.4914 15.3059 11.2772 16.0431C8.30431 16.4 6 18.9309 6 22H4C4 17.5817 7.58172 14 12 14Z">
                                                                        </path>
                                                                    </svg>
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" width="24" height="24"
                                                                        fill="currentColor">
                                                                        <path
                                                                            d="M14 14.252V16.3414C13.3744 16.1203 12.7013 16 12 16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM17.7929 19.9142L21.3284 16.3787L22.7426 17.7929L17.7929 22.7426L14.2574 19.2071L15.6716 17.7929L17.7929 19.9142Z">
                                                                        </path>
                                                                    </svg>
                                                                @endif
                                                            </button>
                                                        </form>

                                                        <button type="button" class="btn btn-outline-danger DeleteUser"
                                                            userid="{{ $user->id }}"
                                                            usernumber="{{ $user->number }}">{{ __('Delete') }} <svg
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="currentColor">
                                                                <path
                                                                    d="M14 14.252V16.3414C13.3744 16.1203 12.7013 16 12 16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM19 17.5858L21.1213 15.4645L22.5355 16.8787L20.4142 19L22.5355 21.1213L21.1213 22.5355L19 20.4142L16.8787 22.5355L15.4645 21.1213L17.5858 19L15.4645 16.8787L16.8787 15.4645L19 17.5858Z">
                                                                </path>
                                                            </svg></button>
                                                        <button type="button" userid="{{ $user->id }}"
                                                            usernumber="{{ $user->number }}"
                                                            class="btn btn-outline-info EditClient">{{ __('Edit') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="currentColor">
                                                                <path
                                                                    d="M12 14V16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM14.5946 18.8115C14.5327 18.5511 14.5 18.2794 14.5 18C14.5 17.7207 14.5327 17.449 14.5945 17.1886L13.6029 16.6161L14.6029 14.884L15.5952 15.4569C15.9883 15.0851 16.4676 14.8034 17 14.6449V13.5H19V14.6449C19.5324 14.8034 20.0116 15.0851 20.4047 15.4569L21.3971 14.8839L22.3972 16.616L21.4055 17.1885C21.4673 17.449 21.5 17.7207 21.5 18C21.5 18.2793 21.4673 18.551 21.4055 18.8114L22.3972 19.3839L21.3972 21.116L20.4048 20.543C20.0117 20.9149 19.5325 21.1966 19.0001 21.355V22.5H17.0001V21.3551C16.4677 21.1967 15.9884 20.915 15.5953 20.5431L14.603 21.1161L13.6029 19.384L14.5946 18.8115ZM18 19.5C18.8284 19.5 19.5 18.8284 19.5 18C19.5 17.1716 18.8284 16.5 18 16.5C17.1716 16.5 16.5 17.1716 16.5 18C16.5 18.8284 17.1716 19.5 18 19.5Z">
                                                                </path>
                                                            </svg></button><br>
                                                        <button type="button" displayname="{{ $user->displayname }}"
                                                            userid="{{ $user->id }}" usernumber="{{ $user->number }}"
                                                            data-target="#reset_user_model" data-toggle="modal"
                                                            class="btn btn-block mt-1 btn-outline-dark ResetClient">{{ __('Reset Password') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="currentColor">
                                                                <path
                                                                    d="M6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7V8H19.5C20.3284 8 21 8.67157 21 9.5V13H19V10H5V20H13V22H4.5C3.67157 22 3 21.3284 3 20.5V9.5C3 8.67157 3.67157 8 4.5 8H6V7ZM16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V8H16V7ZM20.6399 20.1953L21.145 23.1406L18.5 21.75L15.855 23.1406L16.3601 20.1953L14.2202 18.1094L17.1775 17.6797L18.5 15L19.8225 17.6797L22.7798 18.1094L20.6399 20.1953Z">
                                                                </path>
                                                            </svg></button>

                                                        {{-- @if ($user->type != '0')
                                                        <button type="button"
                                                            class="btn btn-outline-success p-1 m-2">{{ __('Reset Password') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="currentColor">
                                                                <path
                                                                    d="M5.46257 4.43262C7.21556 2.91688 9.5007 2 12 2C17.5228 2 22 6.47715 22 12C22 14.1361 21.3302 16.1158 20.1892 17.7406L17 12H20C20 7.58172 16.4183 4 12 4C9.84982 4 7.89777 4.84827 6.46023 6.22842L5.46257 4.43262ZM18.5374 19.5674C16.7844 21.0831 14.4993 22 12 22C6.47715 22 2 17.5228 2 12C2 9.86386 2.66979 7.88416 3.8108 6.25944L7 12H4C4 16.4183 7.58172 20 12 20C14.1502 20 16.1022 19.1517 17.5398 17.7716L18.5374 19.5674Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    @endif --}}


                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                 <div class="text-center">{{__("No Clients Added Yet")}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <div id="editClientModel"></div>
    <div id="deleteClientModel"></div>

    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="reset_user_model">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">{{ __('Reset Password') }} </h3>
                </div>
                <div class="modal-body">
                    <form action="{{ route('client.reset') }} " method="post">
                        @csrf
                        <input type="hidden" name="id" id="useridToreset">
                        <input type="hidden" name="number" id="usernumberToreset">
                        <div class="p-5">
                            <h4>{{ __('Are You Sure To Reset') }} <b id="usernameToreset"></b> {{ __('messages.?') }}
                            </h4>
                        </div>


                        <div class="row">
                            <div class="col-md-4">

                                <button type="button" class="btn btn-outline-secondary btn-block" data-dismiss="modal"
                                    aria-label="Close"> {{ __('Cancel') }} </button>
                            </div>
                            <div class="col-md-8">
                                <button type="submit"
                                    class="btn btn-block btn-outline-warning">{{ __('Send') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="create_user_model">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">{{ __('Add New Client') }} </h3>
                </div>
                <div class="modal-body">
                    <form action="{{ route('client.create') }} " method="post">
                        @csrf

                        {{-- <div class="row">
                            <div class="col-md-12 card  ">
                                <label class="required-label" for="">{{ __('Type') }}</label>
                                <div class="row d-flex justify-content-center align-items-center p-2">
                                    <div class="d-flex">
                                        <input name="user_type" class="form-control usType smallcheck" checked
                                            type="radio" value="msy">
                                        <span class="space"> {{ __('MSY User') }} </span>
                                    </div>
                                    <div class="d-flex">
                                        <input name="user_type" class="form-control usType smallcheck" type="radio"
                                            value="outside">
                                        <span class="space"> {{ __('Outside User') }} </span>
                                    </div>

                                </div>
                            </div>

                        </div> --}}
                        {{-- <div id="msySection">
                            <div class="row p-3">
                                <div class="col-md-4">
                                    <label for="">{{ __('Display Name') }}</label>
                                    <input name="msydisplayname" class="form-control required" id="msyname">
                                </div>
                                <div class="col-md-4">
                                    <label for="">{{ __('AD Name') }}</label>
                                    <input name="username" class="form-control required" id="msyusername">
                                </div>
                                <div class="col-md-4">
                                    <label for="">{{ __('Email') }}</label>
                                    <input name="msyemail" type="email" class="form-control required" id="msyemail">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 card  ">
                                    <label class="required-label" for="">{{ __('Level') }}</label>
                                    <div class="row d-flex justify-content-center align-items-center p-2">
                                        <div class="d-flex">
                                            <input name="user_level" class="form-control   smallcheck" checked
                                                type="radio" value="1">
                                            <span class="space"> {{ __('MSY Sport Employee') }} </span>
                                        </div>
                                        <div class="d-flex">
                                            <input name="user_level" class="form-control   smallcheck" type="radio"
                                                value="2">
                                            <span class="space"> {{ __('MSY Assets Employee') }} </span>
                                        </div>
                                        <div class="d-flex">
                                            <input name="user_level" class="form-control   smallcheck" type="radio"
                                                value="3">
                                            <span class="space"> {{ __('MSY Div Manger') }} </span>
                                        </div>
                                        <div class="d-flex">
                                            <input name="user_level" class="form-control   smallcheck" type="radio"
                                                value="4">
                                            <span class="space"> {{ __('MSY Department Manger') }} </span>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div> --}}

                        <div class="row">
                            <div class="col-md-12 card  ">
                                <label class="required-label" for="">{{ __('Booker Type') }}</label>
                                <div class="row d-flex justify-content-start align-items-center p-2">

                                    @foreach (\App\Models\UserType::all() as $i => $type)
                                        <div class="d-flex">
                                            <input {{ $i == 0 ? 'checked' : '' }} id="{{ $type->id }}"
                                                name="type" class="form-control FaType smallcheck"
                                                value="{{ $type->id }}" type="radio"><span class="space">
                                                {{ $type->getTranslation('title', app()->getlocale()) }} </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row p-3">
                            <div class="col-md-4">
                                <label for="">{{ __('Display Name') }}</label>
                                <input name="displayname" class="form-control" id="outname">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('Email') }}</label>
                                <input name="email" type="email" class="form-control" id="outsiteemail">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('Phone') }}</label>
                                <input name="phone" class="form-control" id="outsitephone">
                            </div>
                        </div>






                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-danger btn-block" data-dismiss="modal"
                                    aria-label="Close"> {{ __('Cancel') }} </button>
                            </div>
                            <div class="col-6">

                                <button class="btn-block btn btn-outline-primary"
                                    type="submit">{{ __('Add') }}</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
