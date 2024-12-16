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
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('facility.details', ['FaNumber' => $facility->number]) }}"
                                        class="btn btn-outline-info"><back-icon></back-icon>{{ __('Go Back') }} </a>
                                    <h3>{{ __('Edit Facility') }}</h3>
                                    <div class="p-3"></div>
                                </div>

                            </div>
                        </div>
                        @if (isset($facility->images) && count($facility->images) > 0)
                            <div class="row">
                                @foreach ($facility->images as $i => $image)
                                    <div class="col-md-3 card p-2" id="imageCard{{ $i }}">
                                        <img src="{{config('app.url')}}/public/{{ $image->url }}" alt="image" srcset="">
                                        @if (count($facility->images) > 1)
                                            <br>
                                            <form action="{{ route('facility.removeimage') }}" method="post">

                                                @csrf
                                                <input type="hidden" name="id" value="{{ $facility->id }}">
                                                <input type="hidden" name="number" value="{{ $facility->number }}">
                                                <input type="hidden" name="path" value="{{ $image->url }}">
                                                <button type="submit" class="btn btn-block btn-outline-danger  ">
                                                    {{ __('Delete') }}</button>
                                            </form>
                                        @endif


                                    </div>
                                @endforeach
                                @if (count($facility->images) < 4)
                                    <div class=" card col-md-3 h-100 p-3">
                                        <form action="{{ route('facility.addimage') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{ $facility->number }}" name="number">
                                            <input type="hidden" value="{{ $facility->id }}" name="id">

                                            <input class="form-control required " max="2" type="file"
                                                accept=".png,.jpg,.jpeg" name="images[]" multiple>
                                            <br><br>
                                            <button type="submit"
                                                class="btn btn-block p-2 btn-outline-success">{{ __('Add Images') }}</button>

                                        </form>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-center">{{ __('No Images for this Facility') }}</p> <br>
                            <form action="{{ route('facility.addimage') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $facility->number }}" name="number">
                                <input type="hidden" value="{{ $facility->id }}" name="id">

                                <input class="form-control required " type="file" accept=".png,.jpg,.jpeg"
                                    name="images[]" multiple>
                                <br><br>
                                <button type="submit"
                                    class="btn btn-block p-2 btn-outline-success">{{ __('Add Images') }}</button>

                            </form>
                        @endif
                        <form class="card p-2 " action="{{ route('facility.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="number" value="{{ $facility->number }}">
                            <input type="hidden" name="id" value="{{ $facility->id }}">
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ar_name" class="required-label">{{ __('Ar Name') }}</label>
                                        <input type="text" class="form-control required" name="ar_name"
                                            value="{{ $facility->getTranslation('title', 'ar') }}"
                                            placeholder="{{ __('Ar Name') }}" />
                                    </div>
                                    <div class="col-md-6" class="required-label">
                                        <label for="en_name" class="required-label">{{ __('En Name') }}</label>
                                        <input type="text" class="form-control required" name="en_name"
                                            value="{{ $facility->getTranslation('title', 'en') }}"
                                            placeholder="{{ __('En Name') }}" />
                                    </div>

                                </div>
                                <div class="p-2"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="gender1" class=" required-label"> {{ __('Facility Type') }}
                                        </label><br>
                                        <div class="d-flex p-2">
                                            @foreach (\App\Models\FacilityTypes::where('status', '1')->get() as $type)
                                                <input type="radio" {{ $type->id == $facility->type ? 'checked' : '' }}
                                                    class="form-control radio smallradio required" name="type"
                                                    value="{{ $type->id }}"> <span
                                                    class="space">{{ $type->getTranslation('name', app()->getLocale()) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="space" class="required-label">{{ __('Space') }}</label>
                                        <input type="text" class="form-control required" name="space"
                                            value="{{ $facility->space }}" placeholder="{{ __('Space') }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="capacity" class="required-label">{{ __('Capacity') }}</label>
                                        <input type="text" class="form-control required" name="capacity"
                                            value="{{ $facility->capacity }}" placeholder="{{ __('Capacity') }}" />
                                    </div>
                                </div>



                                <div class="p-2"></div>

                            </div>
                            <br>
                            <div class="card p-2">
                                <h6>{{ __('Address') }}</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="zone" class="required-label">{{ __('Zone') }}</label>
                                        <input type="number" class="form-control required" name="zone"
                                            value="{{ $facility->zone }}" placeholder="{{ __('Zone') }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="buliding" class="required-label">{{ __('Building No') }}</label>
                                        <input type="text" class="form-control required" name="buliding"
                                            value="{{ $facility->building }}" placeholder="{{ __('Building No') }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="street" class="required-label">{{ __('Street No') }}</label>
                                        <input type="text" class="form-control required" name="street"
                                            value="{{ $facility->street }}" placeholder="{{ __('Street No') }}" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="street" class="required-label">{{ __('Location') }}</label>
                                        <input type="text" class="form-control required" name="location"
                                            value="{{ $facility->location }}" placeholder="{{ __('Location') }}" />
                                    </div>

                                </div>
                            </div>
                            <input type="hidden" id="count" value="1" name="subconunt">


                            <button type="submit" class="btn btn-block btn-outline-success"> {{ __('Edit') }}
                            </button>
                        </form>

                        <div class="card">
                            <div class="card-body p-2">
                                <div class="d-flex p-2 justify-content-between">
                                    <h6>{{ __('Sub Facilities') }}</h6>
                                    <button type="button" data-toggle-extra="tab" data-target="#create_sub_fa_model"
                                        data-toggle="modal"
                                        class="btn btn-outline-primary ">{{ __('Create New Sub Facility') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="currentColor">
                                            <path
                                                d="M11 11V7H13V11H17V13H13V17H11V13H7V11H11ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z">
                                            </path>
                                        </svg></button>
                                </div>
                                @if (count($facility->subfacilities) > 0)
                                    <div class="border p-2">

                                        <div class="row border-bottom">
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="col-md-2 text-center ">{{ __('Ar Name') }}</div>
                                                    <div class="col-md-2 text-center ">{{ __('En Name') }}</div>
                                                    <div class="col-md-2 text-center ">{{ __('Type') }}</div>
                                                    <div class="col-md-2 text-center ">{{ __('Capacity') }}</div>
                                                    <div class="col-md-2 text-center ">{{ __('Description') }}</div>
                                                    <div class="col-md-2 text-center "> </div>
                                                </div>
                                            </div>


                                        </div>

                                        @foreach ($facility->subfacilities as $sub)
                                            <div class="row {{ $sub->status != '1' ? 'readTR m-1' : '' }}">
                                                <div class="col-md-10">
                                                    <form action="{{ route('sub.edit') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="number"
                                                            value="{{ $facility->number }}">
                                                        <input type="hidden" name="sub"
                                                            value="{{ $sub->id }}">
                                                        <input type="hidden" name="id"
                                                            value="{{ $facility->id }}">
                                                        <div class="row p-1">
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control required"
                                                                    value="{{ $sub->getTranslation('title', 'ar') }}"
                                                                    name="arname" placeholder="{{ __('Ar Name') }} *" />
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control required"
                                                                    value="{{ $sub->getTranslation('title', 'en') }}"
                                                                    name="enname" placeholder="{{ __('En Name') }} *" />
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control required"
                                                                    value="{{ $sub->type }}" name="type"
                                                                    placeholder="{{ __('Type') }} *" />
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control required"
                                                                    name="capacity" value="{{ $sub->size }}"
                                                                    placeholder="{{ __('Capacity') }} *" />
                                                            </div>
                                                            <div class="col-md-2">
                                                                <textarea type="text" rows="1" class="form-control" name="description"
                                                                    placeholder="{{ __('Description') }}" />{!! $sub->description !!}</textarea>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="submit"
                                                                    class="btn btn-outline-danger">{{ __('Edit') }}</button>
                                                            </div>
                                                        </div>

                                                    </form>

                                                </div>
                                                <div class="col-md-2">
                                                    <div class="d-flex align-items-center justify-content-center">


                                                        <form class="d-inline "
                                                            action="{{ $sub->status == '1' ? route('subfacility.disable') : route('subfacility.enable') }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="sub"
                                                                value="{{ $sub->id }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $facility->id }}">
                                                            <button type="submit"
                                                                class="btn m-1 {{ $sub->status == '1' ? 'btn-outline-warning' : 'btn-outline-primary' }}">
                                                                {{ $sub->status == '1' ? __('Disable') : __('Enable') }}
                                                                @if ($sub->status == '1')
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" width="24" height="24"
                                                                        fill="currentColor">
                                                                        <path
                                                                            d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z">
                                                                        </path>
                                                                    </svg>
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" width="24" height="24"
                                                                        fill="currentColor">
                                                                        <path
                                                                            d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                                                        </path>
                                                                    </svg>
                                                                @endif
                                                            </button>
                                                        </form>
                                                        {{-- <form action="" method="post">
                                                            @csrf
                                                            <input type="hidden" name="sub"
                                                                value="{{ $sub->id }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $facility->id }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-danger">{{ __('Delete') }}</button>
                                                        </form> --}}
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">


                                                        @foreach ($sub->images as $img)
                                                            <div class="card m-1 col-md-2">
                                                                <img class="rounded p-1"
                                                                    src="{{config('app.url')}}/public/{{ $img->url }}"
                                                                    alt="a" srcset="">
                                                                <form action="{{ route('subimage.remove') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="sub"
                                                                        value="{{ $sub->id }}">
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $facility->id }}">
                                                                    <input type="hidden" name="url"
                                                                        value="{{ $img->url }}">
                                                                    <button type="submit"
                                                                        class="btn btn-block btn-outline-danger">{{ __('Delete') }}</button>
                                                                </form>
                                                            </div>
                                                        @endforeach
                                                        <div class=" card d-flex align-items-center justify-content-center col-md-2">

                                                            <form action="{{ route('subimage.add') }}" method="post"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="file" accept=".png,.jpeg,.jpg"
                                                                    name="images[]" multiple
                                                                    class="form-control required">
                                                                    <div class="p-2"></div>
                                                                <input type="hidden" name="sub"
                                                                    value="{{ $sub->id }}">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $facility->id }}">
                                                                
                                                                <button type="submit"
                                                                    class="btn btn-block btn-outline-info">{{ __('Add') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center">
                                        <p class="h6">{{ __('No Sub Facilities added') }}</p><br>

                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="create_sub_fa_model">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">{{ __('Create New Sub Facility') }} </h3>
                </div>
                <div class="modal-body">
                    <form action="{{ route('subfacility.create') }} " enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" name="FaId" value="{{ $facility->id }}">
                        <input type="hidden" name="FaNum" value="{{ $facility->number }}">
                        <div class="form-groug row p-3">
                            <div class="col-md-6">
                                <label class="required-label" for="">{{ __('Ar Name') }}</label>
                                <input type="text" name="arname" class="form-control required">
                            </div>
                            <div class="col-md-6">
                                <label class="required-label" for="">{{ __('En Name') }}</label>
                                <input type="text" name="enname" class="form-control required">
                            </div>
                            <div class="col-md-4">
                                <label class="required-label" for="">{{ __('Type') }}</label>
                                <input type="text" name="type" class="form-control required">
                            </div>
                            <div class="col-md-4">
                                <label class="required-label" for="">{{ __('Capacity') }}</label>
                                <input type="text" name="capacity" class="form-control required">
                            </div>
                            <div class="col-md-4">
                                <label class="required-label" for="">{{ __('Images') }}</label>
                                <input type="file" multiple accept=".png,.jpg,.jpeg" name="images[]" class="form-control required">
                            </div>


                        </div>
                        <div class="row p-1">
                            <div class="col-md-12">
                                <label for="">{{ __('Description') }}</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
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
