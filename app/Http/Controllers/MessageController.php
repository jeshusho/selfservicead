<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;


class MessageController extends Controller
{
    public function index()
    {
        // $messages = Message::select('')
        // $tickets = Ticket::select('id','ticket_id','tipo','asunto','categorias','empresa','tipo_de_usuario','modo_de_ingreso_ticket','prioridad','group','asignado','fecha_creacion','fecha_de_solucion')
        //             ->where('editable',true)
        //             ->orderBy('created_date','DESC')
        //             ->paginate(250);
                    
        
        // return Inertia::render('Tickets/All', [
        //     'tickets' => $this->transformTickets($tickets),
        //     'priorities' => ZendeskPriority::get(),
        //     'groups' => ZendeskGroup::get(),
        //     'tickettypes' => ZendeskTickettype::get(),
        //     'categories' => ZendeskCategory::get(),
        //     'companies' => ZendeskCompany::get(),
        //     'usertypes' => ZendeskUsertype::get(),
        //     'technicians' => ZendeskUser::where('role','agent')->orderBy('name')->get(),
        //     'ticketentrymodes' => ZendeskTicketentrymode::get(),
        // ]);
    }

    private function transformTickets($tickets){
        $collect_tickets = collect($tickets->all());
        
        $tickets_data = $collect_tickets->transform(function($row, $key) {
            $array = [
                'id' => $row->id,
                'ticket_id' => $row->ticket_id,
                'tipo' => $row->tipo,
                'asunto' => $row->asunto,
                'categorias' => $row->categorias,
                'empresa' => $row->empresa,
                'tipo_de_usuario' => $row->tipo_de_usuario,
                'modo_de_ingreso_ticket' => $row->modo_de_ingreso_ticket,
                'prioridad' => $row->prioridad,
                'group' => $row->group,
                'asignado' => $row->asignado,
                'checked' => false,
                //'fecha_creacion' => Carbon::parse($row->created_date, 'UTC')->setTimezone('America/Lima')->isoFormat('D/M/YYYY HH:mm'),
                'fecha_creacion' => $row->fecha_creacion,
                //'fecha_de_solucion' => !is_null($row->solved_date) ? Carbon::parse($row->solved_date, 'UTC')->setTimezone('America/Lima')->isoFormat('D/M/YYYY HH:mm') : null,
                'fecha_de_solucion' => $row->fecha_de_solucion,
            ];
            return $array;
        });
        $tickets->data = $tickets_data;       
        $transform_tickets =  json_decode(json_encode($tickets));
        $transform_tickets->data = $tickets_data;
        return $transform_tickets;
    }
}
