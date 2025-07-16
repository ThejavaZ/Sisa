@extends('layout.main')

@section('top-title', 'Ajustes')

@section('title', 'Ajustes')

@section('breadcrumb')

@endsection

@section('content')
<div class="card">
    <div class="card-header bg-primary text-2xl text-white bolder">
        Ajustes
    </div>
    <div class="card-body">
        <form class="form form-control-lg card" action="">
            <legend>cambiar contraseña</legend>
            <fieldset class="m-1">
                <label for="" class="form-label -ml-px">Contraseña actual</label>
                <input class="form-control" type="text" name="" id="">
            </fieldset>
            <fieldset class="m-1">
                <label for="" class="form-label -ml-px">Contraseña actual</label>
                <input class="form-control" type="text" name="" id="">
            </fieldset>
            <fieldset class="my-1">
                <label for="" class="form-label -ml-px">Contraseña actual</label>
                <input class="form-control" type="text" name="" id="">
            </fieldset>

            <button class="btn btn-lg bg-primary text-white my-3">
                <i class="fas fa-fw fa-save"></i>
            </button>
        </form>
        <br>
        <form class="form form-control-lg card" action="">
            <legend>cambiar idioma</legend>
            <fieldset>
                <label for="" class="form-label -ml-px">Contraseña actual</label>
                <input class="form-control" type="text" name="" id="">
            </fieldset>
            <fieldset>
                <label for="" class="form-label -ml-px">Selecciona el idioma</label>
                <select class="form-select" type="text" name="" id="">
                    <option value="" disabled selected>Selecciona un idioma</option>
                    <option value="1"{{ Auth::user()->languaje == 1 ? 'selected' : '' }}>Español</option>
                    <option value="2" {{ Auth::user()->languaje == 2 ? 'selected' : '' }}>Inglés</option>
                </select>
            </fieldset>

            <button type="submit" class="btn btn-lg bg-primary text-white my-3">
                <i class="fas fa-fw fa-save"></i>
            </button>
        </form>

    </div>
    <div class="card-footer">
        <a class="btn btn-lg btn-secondary" href="">
            <i class="fas fa-fw fa-arrow-back"></i>
        </a>
    </div>
</div>


@endsection
