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
            @if ($errors->any()) @if($errors->has('libary'))
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Please Select Libary</h4>
            </div>
            @endif @if($errors->has('version'));
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">{{ $errors->first('version') }}</h4>
            </div>
            @endif @endif
            <div class="card">
                <div class="card-header">
                    <b> Select Libary</b>
                </div>
                <div class="card-body">
                    <form
                        action="{{ route('build-release.store') }}"
                        method="post"
                    >
                        @csrf
                        <div class="row m-3">
                            <div class="col">
                                <p>
                                    Lastest Build :
                                    <b
                                        >{{$latestBuild->released_version ?? "-"}}</b
                                    >
                                </p>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="V.1.0.0"
                                    required
                                    name="version"
                                    autocomplete="off"
                                />
                                @if($latestBuild != null)
                                <div class="form-check m-3">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="is_include"
                                        name="is_include"
                                        checked
                                    />
                                    <label
                                        class="form-check-label"
                                        for="is_include"
                                    >
                                        Include Last Build
                                    </label>
                                </div>
                                @endif
                            </div>
                            <div class="col">
                                <button
                                    type="submit"
                                    class="btn btn-success w-100"
                                >
                                    Build New Version
                                </button>
                            </div>
                        </div>

                        <div class="row m-3">
                            <div class="col">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Search"
                                    id="search"
                                />
                            </div>
                            <div class="col">
                                <button
                                    type="button"
                                    class="btn btn-primary w-100"
                                    id="btnSelectAll"
                                >
                                    Select All
                                </button>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            @foreach ($libaries as $libary)
                            <div class="form-check m-3">
                                @if($libary->released_version != null &&
                                $libary->released_version ==
                                $latestBuild->released_version)
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value="{{ $libary->name }}"
                                    name="libary[]"
                                    checked
                                    data-version="{{ $libary->released_version }}"
                                />
                                @else
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value="{{ $libary->name }}"
                                    name="libary[]"
                                    id="{{$libary->name}}"
                                />
                                @endif
                                <label
                                    class="form-check-label"
                                    for="{{$libary->name}}"
                                >
                                    {{ $libary->real_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection @section('scripts')
    <script>
        $(document).ready(function () {
            $(".alert").delay(3000).fadeOut("slow");
            $("#btnSelectAll").click(function () {
                if ($(this).text().trim() == "Select All") {
                    $('.d-flex input[type="checkbox"]').prop("checked", true);
                    $(this).text("Unselect All");
                } else {
                    $('.d-flex input[type="checkbox"]').prop("checked", false);
                    $(this).text("Select All");
                }
            });
            $("#search").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".form-check").filter(function () {
                    $(this).toggle(
                        $(this).text().toLowerCase().indexOf(value) > -1
                    );
                });
            });
            $("#is_include").change(function () {
                if ($(this).is(":checked")) {
                    $(".form-check-input").each(function () {
                        if ($(this).data("version") != null) {
                            $(this).prop("checked", true);
                        }
                    });
                } else {
                    $(".form-check-input").each(function () {
                        if ($(this).data("version") != null) {
                            $(this).prop("checked", false);
                        }
                    });
                }
            });
        });
    </script>
    @endsection
</div>
