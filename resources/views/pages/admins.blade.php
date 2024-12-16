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
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h3>{{ __('Admins') }}</h3>
                                    <button class="btn p-1 m-0 btn-outline-primary" data-toggle-extra="tab"
                                        data-target="#create_admin_model" data-toggle="modal" type="button">
                                        {{ __('Add New Admin') }}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            @if (count($admins) == 0)
                                <div class="text-center p-5 m-5">
                                    <b> {{ __('No Admins') }} </b>
                                </div>
                            @else
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">

                                        </div>
                                        <div class="col-md-4">
                                            <input id="myInput" onkeyup="myFunction(2,[1,2,3]);" type="text"
                                                placeholder="{{ __('Search') }}" class="form-control">
                                        </div>
                                    </div>
                                    <br>

                                    <table id="myTable" class="table table-border ">
                                        <thead>
                                            <tr>
                                                <th> </th>

                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('User Name') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Phone') }}</th>
                                                <th>{{ __('Level') }}</th>
                                                <th class="text-center" colspan="0"> </th>

                                            </tr>


                                        </thead>
                                        <tbody>
                                            @foreach ($admins as $i => $admin)
                                                <tr>
                                                    <td> {{ $i + 1 }} </td>

                                                    <td>{{ $admin->displayname }}</td>
                                                    <td>{{ $admin->username }}</td>
                                                    <td>{{ $admin->email }}</td>
                                                    <td>{{ $admin->phone }}</td>
                                                    <td>{{ $admin->userType }}

                                                        @if ($admin->level == '3')
                                                           <br> <small class="badge badge-dark">{{ $admin->club->name }}</small>
                                                        @endif
                                                    </td>
                                                    {{-- <td class="text-center"> <input type="checkbox"
                                                            {{ $admin->add_facility == '1' ? 'checked' : '' }}
                                                            {{ $admin->email == $user->email ? 'disabled' : '' }}
                                                            class="form-control smallcheck changePer"
                                                            data_admin="{{ $admin->id }}" data_name="add_facility">
                                                    </td> --}}




                                                    <td>
                                                        @if ($user->email != $admin->email)
                                                            <form class="d-inline"
                                                                action="{{ $admin->status == '1' ? route('user.disable') : route('user.enable') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="adId"
                                                                    value="{{ $admin->id }}">
                                                                <input type="hidden" name="adNumber"
                                                                    value="{{ $admin->number }}">
                                                                <button type="submit"
                                                                    class="btn {{ $admin->status == '1' ? 'btn-outline-warning' : 'btn-outline-primary' }}">
                                                                    {{ $admin->status == '1' ? __('Disable') : __('Enable') }}
                                                                    @if ($admin->status == '1')
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" width="24"
                                                                            height="24" fill="currentColor">
                                                                            <path
                                                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z">
                                                                            </path>
                                                                        </svg>
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" width="24"
                                                                            height="24" fill="currentColor">
                                                                            <path
                                                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                                                            </path>
                                                                        </svg>
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <button type="button" userid="{{ $admin->id }}"
                                                            usernumber="{{ $admin->usernumber }}"
                                                            class="btn btn-outline-primary EditUser"> {{ __('Edit') }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="24" height="24" fill="currentColor">
                                                                <path
                                                                    d="M15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89H6.41421L15.7279 9.57627ZM17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785L17.1421 8.16206ZM7.24264 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L7.24264 20.89Z">
                                                                </path>
                                                            </svg></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editUserModel"></div>
    <div id="deleteUserModel"></div>

    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="create_admin_model">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">إضافة مستخدم جديد</h3>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.create') }}" id="createAdminForm" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('Name') }}</label>
                                <input type="text" class="form-control required" name="displayname">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('User Name') }}</label>
                                <input type="text" class="form-control required" name="username">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control required" name="email">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('Phone') }}</label>
                                <input type="text" class="form-control required" name="phone">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <label for="" class="required-label">{{ __('Level') }}</label>
                                <select name="level" class="form-control required " id="userLevel">
                                    @foreach (\App\Models\UserLevel::all() as $level)
                                        <option value="{{ $level->id }}"> {{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6" id="clubselect" style="display: none">
                                <label for="" class="required-label">{{ __('Club') }}</label>
                                <select name="club" id="userClub" class="form-control required">
                                    @foreach (\App\Models\Club::all() as $club)
                                        <option value="{{ $club->id }}"> {{ $club->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        {{-- <div class="row">
                            <div class="col-12">
                                <div class=" align-items-center">
                                    <div class="card p-2"> <label for="permissions">الصلاحيات </label>
                                        <div class="d-flex p-2">
                                            <input type="checkbox" class="form-control smallcheck" name="add_facility">
                                            <span class="space"> إضافة منشأة جديدة</span>

                                        </div>
                                        <div class="error-msg" id="per-error-msg"></div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-danger btn-block" data-dismiss="modal"
                                    aria-label="Close"> إلغاء </button>
                            </div>
                            <div class="col-6">

                                <button class="btn-block btn btn-outline-primary" type="submit">إضافة</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script>
        $(".changePer").change(function() {

            var newvalue = $(this).prop("checked");
            var userid = $(this).attr('data_admin');
            var field = $(this).attr('data_name');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: ' {{ route('changePer') }}',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    field: field,
                    userid: userid,
                    newvalue: newvalue
                },
                success: function(data) {
                    Swal.fire({
                        toast: true,
                        position: "top-start",
                        icon: "success",
                        title: "{{ __('Updated') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(error) {
                    Swal.fire({
                        toast: true,
                        position: "top-start",
                        icon: "error",
                        title: "{{ __('Something Wrong') }}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });


        });
    </script>
@endsection
