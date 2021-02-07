@extends('layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <form method="post" action=" {{ route('s3-rename', ['path' => $path]) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Имя папки или файла<span class="text-danger">*</span></label>
                    <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}">
                    @error('name')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary">Переименовать</button>
                </div>
            </form>
        </div>
    </div>
@endsection
