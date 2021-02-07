@extends('layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <form method="post" action=" {{ route('s3-store-file', ['path' => $path]) }}" enctype="multipart/form-data">
                @csrf

                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file">
                    <label class="custom-file-label" for="customFile">Выберите файл</label>
                    @error('file')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary">Загрузить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
