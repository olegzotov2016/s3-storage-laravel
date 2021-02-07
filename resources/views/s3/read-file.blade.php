@extends('layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <h3>содержимое файла</h3>
            <div>{{ $text }}</div>
        </div>
    </div>
@endsection
