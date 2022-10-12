<table>
    <thead>
    <tr>
        <th colspan="6" >
            REPORTE DE USUARIOS - EXPIRACIÓN DE CONTRASEÑAS
        </th>
    </tr>
    <tr>
        <th colspan="6" >
            Actualizado al: {{ $today }}
        </th>
    </tr>
    <tr>
        <th>Username</th>
        <th>Nombre completo</th>
        <th>Mail</th>
        <th>Fecha de expiración</th>
        <th>Contaseña<br>expirada</th>
        <th>Expira en</th>
    </tr>
    </thead>
    <tbody>
    @foreach($adusers as $aduser)
        <tr>
            <td>{{ $aduser->username }}</td>
            <td>{{ $aduser->display_name }}</td>
            <td>{{ $aduser->mail }}</td>
            <td>{{ $aduser->expiration_str }}</td>
            <td>@if ($aduser->password_expired) SI @else NO @endif</td>
            <td>
                @if(!is_null($aduser->expiration_days))
                    {{ $aduser->expiration_days }} @if (abs($aduser->expiration_days)>1) días @else día @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>