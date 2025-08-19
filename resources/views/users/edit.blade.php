@extends('layout.main')

@section('top-title', $user->name)

@section('title', $user->name)

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('users') }}">
            Usuarios
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ $user->name }}
    </li>
@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-user me-1"></i>
        Editar a {{ $user->name  }}
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            @if (Auth::user()->role == 1)
            <div class="mb-3">
                <label for="" class="form-label">ID</label>
                <input type="text" class="form-control" id="" name="" @disabled(true) value="{{ $user->id }}">
            </div>
            @endif


            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input type="email" class="form-control" id="email" name="email" required value="{{ $user->email }}">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="" disabled>Seleccione un rol</option>
                        @if (Auth::user()->role == 1)
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Administrador</option>
                        @endif
                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }} >Gerente</option>
                        <option value="3" {{ $user->role == 3 ? 'selected' : '' }} >Operador</option>
                        <option value="4" {{ $user->role == 4 ? 'selected' : '' }} >Contador</option>
                        <option value="5" {{ $user->role == 5 ? 'selected' : '' }} >Cliente</option>
                        <option value="6" {{ $user->role == 6 ? 'selected' : '' }} >Proveedor</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="language" class="form-label">Idioma</label>
                <select class="form-select" id="language" name="language" required>
                    <option value="">Seleccione un Idioma</option>
                        <option value="1" {{ $user->language == 1 ? 'selected' : '' }}>Español</option>
                        <option value="2" {{ $user->language == 2 ? 'selected' : '' }}>Inglés</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Foto</label>
                <br/>
                @if (asset('storage/users/img/' . $user->id . '.png'))
                    <img src="{{ asset('storage/users/img/' . $user->id . '.png') }}" alt="Foto del empleado {{ $user->name }}" class="img-fluid rounded -ml-px w-25">
                @endif

                @if (asset('storage/users/img/' . $user->id . '.png'))
                    <div class="mb-3">
                        <label class="form-label">Borrar Foto</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="delete_image" name="delete_image">
                            <label class="form-check-label" for="delete_image">Eliminar foto actual</label>
                        </div>
                    </div>
                @endif
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="active" class="form-label">Activo</label>
                <select class="form-control" id="active" name="active">
                    <option value="S" {{ $user->active == "S" ? 'selected' : '' }}>Si</option>
                    <option value="N" {{ $user->active == "N" ? 'selected' : '' }}>No</option>
                </select>
            </div>
            @if (Auth::user()->role == 1)
             <div class="mb-3">
                <label for="status" class="form-label">Estado</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $user->status == "1" ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $user->status == "0" ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            @endif



            <div class="d-flex flex-row justify-content-around">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                </button>


                <a class="btn btn-secondary" href="{{ route('users') }}">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
