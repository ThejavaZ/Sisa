
<div class="d-flex btn-group-lg justify-content-between mb-4">
    <a class="btn  btn-outline-danger" href="" target="_blank">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>
    <a class="btn btn-outline-primary" href="" target="_blank">
        <i class="fas fa-fw fa-file-word"></i>
    </a>
    <a class="btn btn-outline-success" href="" target="_blank">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>
    <a href="" class="btn btn-outline-info">
        <i class="fas fa-fw fa-envelope"></i>
    </a>
    <a class="btn btn-outline-warning" href="">
        <i class="fas fa-fw fa-edit"></i>
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-laptop me-2"></i> Información de la Computadora
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> </p>
        <p><strong>Foto:</strong>
        @if(asset('storage/s/' . $->id . '.png'))
            <div class="mt-3">
                <img src="{{ asset('storage/s/' . $->id . '.png') }}" alt="Foto del empleado" class="img-fluid rounded -ml-px w-25">
            </div>
        @else
            <div class="mt-3">
                <p class="text-muted">No hay foto disponible</p>
            </div>
        @endif
        </p>

    </div>
    <div class="card-footer text-end">
        <a href="" class="btn btn-lg btn-secondary">
            <i class="fas fa-fw fa-arrow-left"></i>
        </a>
    </div>
</div>
