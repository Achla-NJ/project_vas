@extends('admin.layout')
@section('css')
{{-- <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}"> --}}
<!-- Include Date Range Picker CSS from CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.tiny.cloud/1/v0plwjbhkupcq29dv51ij6lxr0imsbosmsnl5g5zjr3js1r7/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        tinymce.init({
            selector: '.tinymce-editor',
            plugins: [
            'advlist','autolink',
            'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
            'fullscreen','insertdatetime','media','table','help','wordcount','code'
            ],
            toolbar:
            'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help | link image',
            automatic_uploads: true,

            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: (cb, value, meta) => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.addEventListener('change', (e) => {
                const file = e.target.files[0];

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    /*
                    Note: Now we need to register the blob in TinyMCEs image blob
                    registry. In the next release this part hopefully won't be
                    necessary, as we are looking to handle it internally.
                    */
                    const id = 'blobid' + (new Date()).getTime();
                    const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), { title: file.name });
                });
                reader.readAsDataURL(file);
                });

                input.click();
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    });
</script>
@endsection
@section('content')

    <main class="content">
        <div class="mb-3 pt-5 pb-4">
            <h1 class="h3 d-inline align-middle">Manage Setting</h1>
        </div>

        <div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h6>Note: Don't change the $details variable anywhere. Eg. "($details['agreement_date'])".</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card company-form">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.email-template.update') }}">
                            @csrf
                            @foreach ($emailFiles as $email)
                                <div class="mb-4">
                                    <label for="email-{{ $email['file'] }}" class="form-label">{{ $email['title']}}</label>
                                    <textarea id="email-{{ $email['file'] }}" name="emails[{{ $email['file'] }}]" class="tinymce-editor form-control">{{ $email['content'] }}</textarea>
                                    <small class="form-text text-muted">{{ $email['info'] }}</small>
                                </div>
                            @endforeach

                            <div class="fixed-card card p-3">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
