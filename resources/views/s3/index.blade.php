@extends('layouts.main')

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary-dark">
                <div class="card-header pt-3 pb-3">
                    <div class="row">
                        <div class="col-md-6 d-flex align-items-middle">
                            <h5 class="mb-0 card-title">
                                <i class="fas fa-layer-group"></i>
                                S3 Storage
                            </h5>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Создать
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item"
                                       href="{{ route('s3-create-folder-form', ['path' => $parentDirectory]) }}">Создать
                                        папку</a>
                                    <a class="dropdown-item"
                                       href="{{ route('s3-upload-file', ['path' => $parentDirectory]) }}">Загрузить
                                        файл</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-group">
                    @foreach( $directories as $directory)
                        <li class="list-group-item">
                            <a href="{{ route('s3-open-folder', ['path' => $directory]) }}">
                                <i class="fas fa-folder"></i> {{ $directory }}
                            </a>
                            <form class="btn-group float-right"
                                  action="{{ route('s3-delete-folder', ['folder' => $directory, 'path' => $parentDirectory]) }}"
                                  method="POST">
                                <a class="btn btn-secondary btn-sm"
                                   href="{{ route('s3-rename-form', ['path' => $directory]) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Вы уверены, что хотите удалить этот элемент?');">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </li>
                    @endforeach
                    @foreach( $files as $file)
                        <li class="list-group-item">
                            <i class="fas fa-file"></i> {{ $file }}
                            <form class="btn-group float-right"
                                  action="{{ route('s3-delete-file', ['file' => $file, 'path' => $parentDirectory]) }}"
                                  method="POST">
                                <a class="btn btn-secondary btn-sm"
                                   href="{{ route('s3-download-file', ['file' => $file]) }}">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a class="btn btn-secondary btn-sm"
                                   href="{{ route('s3-read-file', ['file' => $file]) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-secondary btn-sm"
                                   href="{{ route('s3-rename-form', ['path' => $file]) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Вы уверены, что хотите удалить этот элемент?');">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
