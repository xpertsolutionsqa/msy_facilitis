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
                                <div class="d-flex justify-content-center">
                                    <h3>{{ __('Create New Facility') }}</h3>
                                </div>

                            </div>
                        </div>
                        <form class="card p-2 " action="{{ route('facility.create') }}" method="post"
                            enctype="multipart/form-data" onsubmit="check()">
                            @csrf
                            <input type="hidden" value="0" id="locationpass">
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="required-label">{{ __('Club') }}</label>
                                        <select name="club" class="form-control required">
                                            @foreach (\App\Models\Club::all() as $club)
                                                <option value="{{ $club->id }}"> {{ $club->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="gender1" class=" required-label"> {{ __('Facility Type') }}
                                        </label><br>
                                        <div class="d-flex p-2">
                                            @foreach (\App\Models\FacilityTypes::where('status', '1')->get() as $type)
                                                <input type="radio" {{ $type->id == '1' ? 'checked' : '' }}
                                                    class="form-control radio smallradio required" name="type"
                                                    value="{{ $type->id }}"> <span
                                                    class="space">{{ $type->getTranslation('name', app()->getLocale()) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="ar_name" class="required-label">{{ __('Images') }}</label>
                                        <input type="file" name="images[]" multiple accept=".png,.jpeg,.jpg"
                                            class="form-control required" placeholder="{{ __('Ar Name') }}" />
                                    </div>
                                </div>

                                <div class="p-2"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ar_name" class="required-label">{{ __('Ar Name') }}</label>
                                        <input type="text" class="form-control required" name="ar_name"
                                            placeholder="{{ __('Ar Name') }}" />
                                    </div>
                                    <div class="col-md-6" class="required-label">
                                        <label for="en_name" class="required-label">{{ __('En Name') }}</label>
                                        <input type="text" class="form-control required" name="en_name"
                                            placeholder="{{ __('En Name') }}" />
                                    </div>

                                </div>
                                <div class="p-2"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="space" class="required-label">{{ __('Space') }}</label>
                                        <input type="text" class="form-control required" name="space"
                                            placeholder="{{ __('Space') }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="capacity" class="required-label">{{ __('Capacity') }}</label>
                                        <input type="text" class="form-control required" name="capacity"
                                            placeholder="{{ __('Capacity') }}" />
                                    </div>

                                </div>
                            </div>
                            <br>
                            <div class="card p-2 addressDiv">
                                <h6>{{ __('Address') }}</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="zone" class="required-label">{{ __('Zone') }}</label>
                                        <input type="text" class="form-control required locationValue" name="zone"
                                            id="zoneinput" placeholder="{{ __('Zone') }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="street" class="required-label">{{ __('Street No') }}</label>
                                        <input type="text" class="form-control required locationValue" name="street"
                                            id="streetinput" placeholder="{{ __('Street No') }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="buliding" class="required-label">{{ __('Building No') }}</label>
                                        <input type="text" class="form-control required locationValue" name="buliding"
                                            id="bulidinginput" placeholder="{{ __('Building No') }}" />
                                    </div>

                                    <div class="col-md-3">
                                        <label for="street" class="required-label">{{ __('Location') }}</label>
                                        <input type="text" class="form-control required" name="location"
                                            placeholder="{{ __('Location') }}" />
                                    </div>
                                    <p style="display: none" class="h6 p-2 error-msg" id="errorLoc">
                                        {{ __('Please Enter Valid Address') }}</p>
                                </div>
                            </div>
                            <input type="hidden" id="count" value="1" name="subconunt">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="d-flex p-2 justify-content-between">
                                        <h6>{{ __('Sub Facilities') }}</h6>
                                        <button type="button"
                                            class="btn btn-outline-primary AddSub">{{ __('Create New Sub Facility') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24" fill="currentColor">
                                                <path
                                                    d="M11 11V7H13V11H17V13H13V17H11V13H7V11H11ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z">
                                                </path>
                                            </svg></button>
                                    </div>
                                    <table id="subTable" class="table table-rounded">

                                        <tr count="1">
                                            <td>
                                                <input type="text" class="form-control required" name="subarname1"
                                                    placeholder="{{ __('Ar Name') }} *" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control required" name="subenname1"
                                                    placeholder="{{ __('En Name') }} *" />
                                            </td>
                                            <td>
                                                <select name="subtype1" class="form-control required" id="">
                                                    <option disabled value="">{{ __('Type') }} *</option>
                                                    @foreach (\App\Models\SubFacilityTypes::where('status', '1')->get() as $subtype)
                                                        <option value="{{ $subtype->id }}">{{ $subtype->name }}</option>
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td>
                                                <input type="text" class="form-control required" name="subcapacitpy1"
                                                    placeholder="{{ __('Capacity') }} *" />
                                            </td>
                                            <td width="25%">
                                                <textarea type="text" name="subcdesc1" rows="3" class="form-control  "
                                                    placeholder="{{ __('Description') }}" /></textarea>
                                            </td>
                                            <td>
                                                <input type="file" name="subfiles1[]" multiple
                                                    accept=".png,.jpeg,.jpg" class="form-control required"
                                                    placeholder="{{ __('Images') }} *" />
                                            </td>
                                            <td>
                                            </td>

                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-block btn-outline-success"> {{ __('Add') }}
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
