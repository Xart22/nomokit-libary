@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <b>
                        Current Version:
                        {{ $activeBuilds->released_version ?? '-' }}</b
                    >
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <a
                                    href="{{ route('build-release.index') }}"
                                    class="btn btn-primary w-100"
                                >
                                    Create New Version
                                </a>
                            </div>
                            <div class="col">
                                <a
                                    href="{{ route('upload') }}"
                                    class="btn btn-warning w-100"
                                >
                                    Upload Libary
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-3">
            <div class="card">
                <div class="card-header">History Release</div>
                <div class="card-body">
                    <table id="lib-table">
                        <thead>
                            <tr>
                                <th>Release Version</th>
                                <th>Release Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($builds as $build)
                            <tr>
                                <td>{{ $build->released_version }}</td>
                                <td>{{ $build->created_at }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary"
                                        >Download</a
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
<script>
    $(document).ready(function () {
        $("#lib-table").DataTable();
    });
</script>
@endsection
