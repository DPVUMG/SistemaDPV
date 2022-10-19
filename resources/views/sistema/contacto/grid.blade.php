<div class="card">
    <div class="card-header card-header-info">
        <h4 class="card-title ">
            <img src="{{ asset('image/ico_libreta.png') }}" title="Libreta" width="50px" height="50px" alt="Libreta">
            {{ $titulo }}
        </h4>
    </div>
    <div class="card-body">
        <table class="dataTableExport display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center align-middle">Nombre</th>
                    <th class="text-center align-middle">Teléfono</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td class="text-left align-middle">{{ $item->nombre }}</td>
                    <td class="text-center align-middle">{{ $item->telefono }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>