<?php

namespace App\Http\Controllers;

use App\Exports\MessagesExport;
use App\Models\Message;
use App\Models\ScheduledTask;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class MessageController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $datetime_ini_local = Carbon::now(new DateTimeZone('America/Lima'))->isoFormat('YYYY-MM-DD 00:00:00');
        $datetime_end_local = Carbon::now(new DateTimeZone('America/Lima'))->isoFormat('YYYY-MM-DD 23:59:59');
        $datetime_ini =  Carbon::parse($datetime_ini_local, 'America/Lima')->setTimezone('UTC')->isoFormat('YYYY-MM-DD HH:mm:ss');
        $datetime_end =  Carbon::parse($datetime_end_local, 'America/Lima')->setTimezone('UTC')->isoFormat('YYYY-MM-DD HH:mm:ss');

        $messages = Message::where('sending_time','>=',$datetime_ini)
                            ->where('sending_time','<=',$datetime_end)
                            ->orderBy('created_at','DESC')
                            ->paginate(100);                  
        
        return Inertia::render('Dashboard', [
            'messages' => $this->transformMessages($messages),
            'datetime_ini_local' => str_replace('','T',$datetime_ini_local),
            'datetime_end_local' => str_replace('','T',$datetime_end_local)
        ]);
    }

    public function filter($message_date_ini, $message_date_end)
    {
        $datetime_ini =  Carbon::parse($message_date_ini, 'America/Lima')->setTimezone('UTC')->isoFormat('YYYY-MM-DD HH:mm:ss');
        $datetime_end =  Carbon::parse($message_date_end, 'America/Lima')->setTimezone('UTC')->isoFormat('YYYY-MM-DD HH:mm:ss');

        $messages = Message::where('sending_time','>=',$datetime_ini)
                            ->where('sending_time','<=',$datetime_end)
                            ->orderBy('created_at','DESC')
                            ->paginate(100);                  
        
        return Inertia::render('Dashboard', [
            'messages' => $this->transformMessages($messages),
            'datetime_ini_local' => str_replace('','T',$message_date_ini),
            'datetime_end_local' => str_replace('','T',$message_date_end)
        ]);
    }

    private function transformMessages($messages){
        $collect_messages = collect($messages->all());
        
        $messages_data = $collect_messages->transform(function($row, $key) {
            $array = [
                'id' => $row->id,
                'aduser_id' => $row->aduser_id,
                'aduser' => $row->aduser,
                'sending_time' => !is_null($row->sending_time) ? Carbon::parse($row->sending_time, 'UTC')->setTimezone('America/Lima')->isoFormat('DD/MM/YYYY HH:mm') : null,
                'days' => $row->days,
                //'fecha_creacion' => Carbon::parse($row->created_date, 'UTC')->setTimezone('America/Lima')->isoFormat('D/M/YYYY HH:mm'),
                //'fecha_creacion' => $row->fecha_creacion,
                //'fecha_de_solucion' => !is_null($row->solved_date) ? Carbon::parse($row->solved_date, 'UTC')->setTimezone('America/Lima')->isoFormat('D/M/YYYY HH:mm') : null,
                //'fecha_de_solucion' => $row->fecha_de_solucion,
            ];
            return $array;
        });
        $messages->data = $messages_data;       
        $transform_messages =  json_decode(json_encode($messages));
        $transform_messages->data = $messages_data;
        return $transform_messages;
    }


    public function export_excel($message_date_ini, $message_date_end)
    {
        $datetime_ini =  Carbon::parse($message_date_ini, 'America/Lima')->setTimezone('UTC')->isoFormat('YYYY-MM-DD HH:mm:ss');
        $datetime_end =  Carbon::parse($message_date_end, 'America/Lima')->setTimezone('UTC')->isoFormat('YYYY-MM-DD HH:mm:ss');


        $data  = Message::where('sending_time','>=',$datetime_ini)
            ->where('sending_time','<=',$datetime_end)
            ->orderBy('created_at','DESC')
            ->get();
        
        foreach($data as $row){
            $row->sending_time =  !is_null($row->sending_time) ? Carbon::parse($row->sending_time, 'UTC')->setTimezone('America/Lima')->isoFormat('DD/MM/YYYY HH:mm') : null;
        }

        $date_ini = Carbon::parse($message_date_ini, 'America/Lima')->isoFormat('DD/MM/YYYY'); 
        $date_end = Carbon::parse($message_date_end, 'America/Lima')->isoFormat('DD/MM/YYYY');

        //$today = Carbon::today('America/Lima')->isoFormat('DD/MM/YYYY');
        $report = new MessagesExport($data, $date_ini, $date_end);
        return Excel::download($report, 'reporte-notificaciones.xlsx');
    }
}
