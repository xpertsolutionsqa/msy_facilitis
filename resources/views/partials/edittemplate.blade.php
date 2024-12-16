<div class="card">
    <div class="card-body">
        <form action="{{ route('template.update') }}" method="post" id="TemplateForm">
            @csrf
            <input type="hidden" value="{{ $templateName }}">
            <input type="hidden" id="arValue" name="ar_value">
            <input type="hidden" id="enValue" name="en_value">
            <div class="row p-5">
                <div class="col-md-6"> <label for=""> {{ __('In Arabic') }} </label>
                    {{-- <textarea name="" id="arText" cols="30" rows="10">{!! $template->ar_value !!}</textarea> --}}
                    <div id="ar_template">{!! $template->ar_value !!}</div>
                </div>
                <div class="col-md-6">
                    <label for=""> {{ __('In English') }} </label>
                    {{-- <textarea name="" id="enText" cols="30" rows="10">{!! $template->en_value !!}</textarea> --}}
                    <div id="en_template">{!! $template->en_value !!}</div>
                </div>
            </div>
            <br><br><br>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-block btn-outline-success">{{ __('Update') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    var CustomtoolbarOptions = [
        [{
            'header': [1, 2, 3, 4, 5, 6, false]
        }],
        [{
            'header': 1
        }, {
            'header': 2
        }], // custom button values
        [{
            'list': 'ordered'
        }, {
            'list': 'bullet'
        }],

        ['bold', 'italic', 'underline'],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'color': [] }, { 'background': [] }],  
        [{
            'direction': 'rtl'
        }],
        [{
            'align': []
        }],
        ['link', 'image', 'code-block']
    ];
    var arquill = new Quill('#ar_template', {
        theme: 'snow',
        modules: {
            toolbar: CustomtoolbarOptions
        }
    });
    var enquill = new Quill('#en_template', {
        theme: 'snow',
        modules: {
            toolbar: CustomtoolbarOptions
        }
    });

    $('#TemplateForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('template.update') }}",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                name: "{{ $templateName }}",
                arvalue: arquill.root.innerHTML,
                envalue: enquill.root.innerHTML,
            },
            success: function(data) {



                if (data.status == 'true') {
                    Swal.fire({
                        icon: 'success',
                        text: "{{ __('Updated') }}",
                        toast: true,
                        position: "top-start",
                        showConfirmButton: false,
                        timer: 3500
                    });
                } else {
                    showError();
                }

            },
            error: function() {
                showError();
            }
        });

    });
</script>
<script>
    // tinymce.init({
    //     selector: 'textarea#arText',
    //     language: 'ar',
       
       
    //     toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | checklist numlist bullist indent outdent',
    //     menubar: false,
        
    // });
    // tinymce.init({
    //     selector: 'textarea#enText',
    //     language: 'en',
        
    //     toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | checklist numlist bullist indent outdent',
    //     menubar: false,
       
    // });
     
</script>
