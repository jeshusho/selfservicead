<p>
    Las notificaciones programadas para ser enviadas el <b>{{ $dt_notification }}</b> no han sido enviadas, debido a que la última actualización de la información en la aplicación fue realizada el <b>{{ $dt_last_scheduled_task }}</b>.<br>
    Considerando que el tiempo entre la última actualización de la información y la hora del envío de notificaciones es mayor que los <b>{{ $delay_minutes }} minutos</b> definidos, se considera que la información no está actualizada en la aplicación web, por lo que no se enviaron las notificaciones para evitar posibles confusiones en los usuarios afectados.<br>
</p>
Se recomienda revisar la ejecución de la tarea programada que ejecuta el script que actualiza la información desde el servidor Windows hacia la aplicación web. Puede realizar los siguientes descartes:<br>
<ul>
    <li>Revisar el horario de ejecución de la tarea programada.</li>
    <li>Verificar en el historial de la tarea programada, si se está ejecutando o no la misma.</li>
    <li>En caso no se está ejecutando, revisar si la contraseña del usuario que ejecuta la tarea programada ha cambiado recientemente, en ese caso se deberá actualizar también en la tarea programada.</li>
    <Li>En caso si se haya ejecutado en el horario esperado, pero aún así la aplicación muestra que la información se ha actualizado en una fecha/hora anterior, se deberá ejecutar manualmente el script del Power Shell, utilizando el programa "Power Shell ISE" para poder visualizar que error se está generando al momento de ejecutar el script.</Li>
</ul>

