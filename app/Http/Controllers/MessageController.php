<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Inertia\Inertia;


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

        // $messages = Message::orderBy('created_at','DESC')
        //                     ->paginate(100);
        // $messages = Message::select('')
        // $tickets = Ticket::select('id','ticket_id','tipo','asunto','categorias','empresa','tipo_de_usuario','modo_de_ingreso_ticket','prioridad','group','asignado','fecha_creacion','fecha_de_solucion')
        //             ->where('editable',true)
        //             ->orderBy('created_date','DESC')
        //             ->paginate(250);
                    
        
        return Inertia::render('Messages', [
            'messages' => $this->transformMessages($messages)
        ]);
    }

    private function transformMessages($messages){
        $collect_messages = collect($messages->all());
        
        $messages_data = $collect_messages->transform(function($row, $key) {
            $array = [
                'id' => $row->id,
                'aduser_id' => $row->aduser_id,
                'sending_time' => !is_null($row->sending_time) ? Carbon::parse($row->sending_time, 'UTC')->setTimezone('America/Lima')->isoFormat('D/M/YYYY HH:mm') : null,
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
}
