<div class="border  ">
    <div class=" p-2 blur-shadow ">

        <div class="d-flex justify-content-between align-items-center">
            <h6 class="text-center"> <b>{{ $booking->event_name }}</b></h6>
            <div class="text-center">

                <p style="font-size: 13px">
                    <samll> {{ __('Created At') }} : {{ $booking->created_at }}</small>
                </p>
                {!! $booking->htmlstatus !!}
            </div>
        </div>
    </div>


    <div class="card-body">

        <p class="border-info text-info border p-1 ">
            {{ __('From Date') . ' ' . $booking->start_date . ' ' . $booking->start_time . '   ' . __('To Date') . ' ' . $booking->end_date . ' ' . $booking->end_time }}


        <div class="d-flex justify-content-between ">
            <p class="border border-primary text-primary   p-2  ">{{ __('Requierd Days No') . ' : ' . $booking->days }}
            </p>
            <p class="border border-danger text-danger   p-2  ">
                {{ __('Expected Participants No') . ' : ' . $booking->particpations }}
            </p>
        </div>

        <div class="blur-shadow   p-2 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} ">
            <p><b>{{ __('Requierd Sub Facilities') }}</b></p>
            <ul>
                @foreach ($booking->subs as $item)
                    <li class=" ph-4 ">{{ $item->title . ' : (' . $item->type . ')' }}</li>
                @endforeach
            </ul>



        </div>

        {{-- <div class="p-2"></div> --}}



        {{-- <div class="blur-shadow rounded p-1  ">
          <p><b>{{ __('Contact Information') }}</b></p>
          <p> {{ __('Name') . ' : ' . $booking->cname }}</p>
          <p> {{ __('Phone') . ' : ' . $booking->cphone }}</p>
          <p> {{ __('Email') . ' : ' . $booking->cemail }}</p>
      </div> --}}
        {{-- @if (count($booking->files) > 0)

          <div class="p-2"></div>
          <div class="blur-shadow rounded p-1  ">
              <p><b>{{ __('Attachments') }}</b></p>
              @foreach ($booking->files as $index => $file)
                  @php
                      $extension = pathinfo($file->url, PATHINFO_EXTENSION) ?? 'unknown';
                  @endphp

                  <button title={{ $file->filename }}" class="btn filebtn " extension="{{ $extension }}"
                      filepath = "{{ $file->url }}">
                      @switch($extension)
                          @case('rar')
                          @case('zip')
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                  fill="rgba(127,127,127,1)">
                                  <path
                                      d="M20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM19 20V4H5V20H19ZM14 12V17H10V14H12V12H14ZM12 4H14V6H12V4ZM10 6H12V8H10V6ZM12 8H14V10H12V8ZM10 10H12V12H10V10Z">
                                  </path>
                              </svg>
                          @break

                          @case('pdf')
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                  fill="rgba(127,127,127,1)">
                                  <path
                                      d="M5 4H15V8H19V20H5V4ZM3.9985 2C3.44749 2 3 2.44405 3 2.9918V21.0082C3 21.5447 3.44476 22 3.9934 22H20.0066C20.5551 22 21 21.5489 21 20.9925L20.9997 7L16 2H3.9985ZM10.4999 7.5C10.4999 9.07749 10.0442 10.9373 9.27493 12.6534C8.50287 14.3757 7.46143 15.8502 6.37524 16.7191L7.55464 18.3321C10.4821 16.3804 13.7233 15.0421 16.8585 15.49L17.3162 13.5513C14.6435 12.6604 12.4999 9.98994 12.4999 7.5H10.4999ZM11.0999 13.4716C11.3673 12.8752 11.6042 12.2563 11.8037 11.6285C12.2753 12.3531 12.8553 13.0182 13.5101 13.5953C12.5283 13.7711 11.5665 14.0596 10.6352 14.4276C10.7999 14.1143 10.9551 13.7948 11.0999 13.4716Z">
                                  </path>
                              </svg>
                          @break

                          @case('docx')
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                  fill="rgba(127,127,127,1)">
                                  <path
                                      d="M16 8V16H14L12 14L10 16H8V8H10V13L12 11L14 13V8H15V4H5V20H19V8H16ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                  </path>
                              </svg>
                          @break

                          @case('xls')
                          @case('xlsx')
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                  fill="rgba(127,127,127,1)">
                                  <path
                                      d="M13.2 12L16 16H13.6L12 13.7143L10.4 16H8L10.8 12L8 8H10.4L12 10.2857L13.6 8H15V4H5V20H19V8H16L13.2 12ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                  </path>
                              </svg>
                          @break

                          @case('png')
                          @case('jpg')
                          @case('jpeg')
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                  fill="rgba(127,127,127,1)">
                                  <path
                                      d="M15 8V4H5V20H19V8H15ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM11 9.5C11 10.3284 10.3284 11 9.5 11C8.67157 11 8 10.3284 8 9.5C8 8.67157 8.67157 8 9.5 8C10.3284 8 11 8.67157 11 9.5ZM17.5 17L13.5 10L8 17H17.5Z">
                                  </path>
                              </svg>
                          @break

                          @default
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                  fill="rgba(127,127,127,1)">
                                  <path
                                      d="M13 12H16L12 16L8 12H11V8H13V12ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                  </path>
                              </svg>
                      @endswitch
                  </button>
              @endforeach
          </div>
      @endif --}}
        <div class="p-1"></div>
        <div class="blur-shadow {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} p-2">
            <small>{{ $booking->notes }}</small>
        </div>


    </div>
    <div class="card-footer">
        <a href="{{ route('booking.details', $booking->number) }}"
            class="btn btn-block btn-outline-primary">{{ __('Details') }}

            @if (app()->getlocale() == 'ar')
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                    fill="currentColor">
                    <path
                        d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z">
                    </path>
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                    fill="currentColor">
                    <path
                        d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                    </path>
                </svg>
            @endif

        </a>

    </div>
</div>
