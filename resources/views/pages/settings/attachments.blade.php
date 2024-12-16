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
                                <h3>{{ __('Attachments') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card col-md-12 p-2">
                        <table class="table rounded">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Accept') }}</th>
                                    <th>{{ __('Max') }}</th>
                                    <th>{{ __('Required') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\Attachment::all() as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @php
                                                $types = explode(',', $item->accept);
                                            @endphp
                                            @foreach ($types as $type)
                                                <div class="border badge text-primary border-primary">{{ substr($type, 1) }}
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->max }}</td>
                                        <td> <input type="checkbox" {{ $item->required == '1' ? 'checked' : '' }}
                                                class="changeReq smallcheck form-control" data-id="{{ $item->id }}">
                                        </td>
                                        <td>
                                            <form class="d-inline"
                                                action="{{ $item->status == '1' ? route('attachment.disable') : route('attachment.enable') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit"
                                                    class="btn {{ $item->status == '1' ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                                    {{ $item->status == '1' ? __('Disable') : __('Enable') }}
                                                    @if ($item->status == '1')
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            width="24" height="24" fill="currentColor">
                                                            <path
                                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z">
                                                            </path>
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            width="24" height="24" fill="currentColor">
                                                            <path
                                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                                            </path>
                                                        </svg>
                                                    @endif
                                                </button>
                                                <button data-toggle-extra="tab" data-target="#edit_attach_model"
                                                    data-toggle="modal" type="button"
                                                    class="btn btn-outline-success EditAttach "
                                                    accept="{{ $item->accept }}" max="{{ $item->max }}"
                                                    arname="{{ $item->getTranslation('name', 'ar') }}"
                                                    enname="{{ $item->getTranslation('name', 'en') }}"
                                                    id="{{ $item->id }}">{{ __('Edit') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach


                                <tr>
                                    <form action="{{ route('settings.attachemnts.save') }}" method="post">

                                        @csrf
                                        <td>+</td>
                                        <td>
                                            <input required class="required form-control m-2" name="arname"
                                                placeholder="{{ __('Ar Name') }} *" type="text">
                                            <input required class="required form-control m-2" name="enname"
                                                placeholder="{{ __('En Name') }} *" type="text">
                                        </td>
                                        <td>
                                            <select class="form-control select2" required multiple name="accept[]">
                                                <option disabled>{{ __('Type') }}</option>
                                                <option value=".png">png</option>
                                                <option value=".jpg">jpg</option>
                                                <option value=".jpeg">jpeg</option>
                                                <option value=".pdf">pdf</option>
                                                <option value=".docx">docx</option>
                                                <option value=".doc">doc</option>
                                                <option value=".ppt">ppt</option>
                                                <option value=".xlsx">xlsx</option>
                                                <option value=".xls">xls</option>
                                                <option value=".mp4">mp4</option>
                                                <option value=".rar">rar</option>
                                                <option value=".zip">zip</option>
                                            </select>
                                        </td>
                                        <td><input required class="required form-control"
                                                placeholder="{{ __('Max') }} *   MB" type="number" name="max"
                                                min="1" id=""></td>
                                        <td><input class="required form-control smallcheck" type="checkbox" name="required"
                                                min="1" id=""></td>
                                        <td> <button type="submit"
                                                class="btn btn-outline-success">{{ __('Add') }}</button> </td>
                                    </form>
                                </tr>
                            </tbody>

                        </table>


                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="edit_attach_model" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">{{ __('Edit Attachment') }} </h3>
                </div>
                <div class="modal-body">
                    <form action="{{route('attachment.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="attachid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">{{ __('Ar Name') }}</label>
                                <input type="text" class="form-control" name="arname" required id="attacharname">
                            </div>
                            <div class="col-md-6">
                                <label for="">{{ __('En Name') }}</label>
                                <input type="text" class="form-control" name="enname" required id="attachenname">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">{{ __('Max') }}</label>
                                <input type="number" class="form-control" class="form-control" name="max" required
                                    id="attachmax">
                            </div>
                            <div class="col-md-6">
                                <label for="">{{ __('Accept') }}</label>
                                <select class="form-control  " required multiple name="accept[]" id="attachaccept">
                                    <option>{{ __('Type') }}</option>
                                    <option value=".png">png</option>
                                    <option value=".jpg">jpg</option>
                                    <option value=".jpeg">jpeg</option>
                                    <option value=".pdf">pdf</option>
                                    <option value=".docx">docx</option>
                                    <option value=".doc">doc</option>
                                    <option value=".ppt">ppt</option>
                                    <option value=".xlsx">xlsx</option>
                                    <option value=".xls">xls</option>
                                    <option value=".mp4">mp4</option>
                                    <option value=".rar">rar</option>
                                    <option value=".zip">zip</option>
                                </select>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-outline-success">{{__("Edit")}}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
