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

                                <h3>{{ __('Languages') }}</h3>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-xl-12">
                                    <form action="{{ route('settings.languages.save') }}" id="LangForm" method="post">
                                        @csrf

                                        <div class="row">
                                            <div class="col-8">

                                            </div>
                                            <div class="col-md-4">
                                                <input id="myInput" onkeyup="myFunction(1,[0]);" type="text"
                                                    placeholder="{{ __('Search') }}" class="form-control">
                                            </div>
                                        </div>
                                        <br>

                                        <table id="myTable" class="table table-border ">
                                            <thead>
                                                <tr>
                                                    <th>المفتاح | KEY</th>
                                                    <th width="25%">بالعربي</th>
                                                    <th width="25%">In English</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($arlabels as $label => $value)
                                                    <tr>
                                                        <td> <label class="form-label"
                                                                for="example3cols1Input">{{ $label }}
                                                            </label></td>
                                                        <td><input class="form-control" type="text"
                                                                value="{{ $value }}"
                                                                name="arlabel[{{ $label }}]" id=""></td>
                                                        <td><input class="form-control" type="text"
                                                                value="{{ isset($enlabels->$label) ? $enlabels->$label : '' }}"
                                                                name="enlabel[{{ $label }}]" id=""></td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                </div>



                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
