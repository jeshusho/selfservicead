<table>
    <thead>
    <tr>
        <th colspan="4" >
            NOTIFICACIONES ENVIADAS
        </th>
    </tr>
    <tr>
        <th colspan="4" >
            del {{ $date_ini }} al {{ $date_end }}
        </th>
    </tr>
    <tr>
        <th>Username</th>
        <th>Mail</th>
        <th>Fecha/Hora envío</th>
        <th>Días para expirar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($messages as $message)
        <tr>
            <td>{{ $message->aduser->username }}</td>
            <td>{{ $message->aduser->mail }}</td>
            <td>{{ $message->sending_time }}</td>
            <td>{{ $message->days }}</td>
            {{-- <td>{{ $message->days }} @if (abs($message->days)>1) días @else día @endif</td> --}}
        </tr>
    @endforeach
    </tbody>
</table>