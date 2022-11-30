@extends('layouts.app') @section('header')

<link
    rel="stylesheet"
    href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
    type="text/css"
/>

@endsection @section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="alert alert-success" role="alert" style="display: none">
                <h4 class="alert-heading">Upload Success!</h4>
            </div>
            @if ($errors->any()) @if($errors->has('error'))
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">{{ $errors->first('error') }}</h4>
            </div>
            @endif @endif @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Delete success</h4>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <b> Upload Libary</b>
                </div>
                <div class="card-body">
                    <div class="container">
                        <form
                            class="dropzone"
                            id="libaryDropzone"
                            action="{{ route('uploadFile') }}"
                        ></form>
                        <button
                            type="button"
                            class="btn btn-success w-100 mt-2"
                            id="submitAll"
                        >
                            Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-3">
            <div class="card">
                <div class="card-header">Libary</div>
                <div class="card-body">
                    <table id="lib-table">
                        <thead>
                            <tr>
                                <th>Name Libary</th>
                                <th>Released Version</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($libaries as $libary)
                            <tr>
                                <td>{{ $libary->name }}</td>
                                <td>
                                    {{ $libary->released_version ?? 'Not Yet Released' }}
                                </td>
                                <td>
                                    <a
                                        href="{{$libary->file_path}}"
                                        class="btn btn-primary"
                                        >Download</a
                                    >
                                    <a
                                        href="{{route('delete.libary',$libary->id)}}"
                                        class="btn btn-danger"
                                        >Delete</a
                                    >
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function () {
        $("#lib-table").DataTable();
        const myDropzone = new Dropzone("#libaryDropzone", {
            url: "{{ route('uploadFile') }}",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 15,
            maxFilesize: 2,
            maxFiles: 15,
            acceptedFiles: ".zip",
            addRemoveLinks: true,
            dictRemoveFile: "Remove",
            dictFileTooBig: "Image is larger than 2MB",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (file, response) {
                console.log(response);
            },
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
                $("." + file.previewElement.classList[0])
                    .find(".dz-error-message")
                    .text(response);
            },
            queuecomplete: function (file, response) {
                $(".alert-success").fadeIn(3000, function () {
                    window.location.reload();
                });
            },
        });

        $("#submitAll").on("click", function () {
            myDropzone.processQueue();
        });
    });
</script>
@endsection
