<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMessage;
use App\Mail\NotificationScheduledTask;
use App\Models\Aduser;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Schedule;
use App\Models\ScheduledTask;
use App\Models\Setting;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function send()
    {
        $now = Carbon::now();
        $now_local = Carbon::now(new DateTimeZone('America/Lima'))->isoFormat('HH:mm');
		//Log::info('Schedule execute in: ' . $now_local);
        $schedules = Schedule::get();
        foreach($schedules as $schedule)
        {
            $schedule_hours = str_pad($schedule->hours, 2, '0', STR_PAD_LEFT);
            $schedule_minutes = str_pad($schedule->minutes, 2, '0', STR_PAD_LEFT);
            $scheduled_time = $schedule_hours  . ':' . $schedule_minutes;
            if($now_local == $scheduled_time)
            {
                $last_st = ScheduledTask::orderBy('id','DESC')->first();
                if(!is_null($last_st)){
                    $last_exec = Carbon::createFromFormat('Y-m-d H:i:s',  $last_st->exec_datetime);
                    $diffmin = $last_exec->diffInMinutes($now);
                    $max_delay = intval(Setting::where('parameter','max_delay')->first()->value);
                    //return $diffmin;
                    if($diffmin <= $max_delay){
                        $parameters = [
                           // 'logo_url' => Setting::where('parameter','logo_url')->first()->value,
                            'principal_link_text' => Setting::where('parameter','principal_link_text')->first()->value,
                            'principal_link_url' => Setting::where('parameter','principal_link_url')->first()->value,
                            'mda_whatsapp_text' => Setting::where('parameter','mda_whatsapp_text')->first()->value,
                            'mda_whatsapp_url' => Setting::where('parameter','mda_whatsapp_url')->first()->value,
                            'mda_phone_text' => Setting::where('parameter','mda_phone_text')->first()->value,
                            'mda_phone_url' => Setting::where('parameter','mda_phone_url')->first()->value,
                            'mda_extension_text' => Setting::where('parameter','mda_extension_text')->first()->value,
                            'mda_portal_text' => Setting::where('parameter','mda_portal_text')->first()->value,
                            'mda_portal_url' => Setting::where('parameter','mda_portal_url')->first()->value,
                            'mda_mail_text' => Setting::where('parameter','mda_mail_text')->first()->value,
                            'mda_mail_url' => Setting::where('parameter','mda_mail_url')->first()->value,
                            'portal_text' => Setting::where('parameter','portal_text')->first()->value,
                            'portal_url' => Setting::where('parameter','portal_url')->first()->value,
                        ];
                
                        $notifications = Notification::get();
                        $expiration_days = [];
                        foreach($notifications as $n)
                        {
                            array_push($expiration_days,$n->days);
                        }
                        if(Aduser::where('active',true)->where('password_expired',false)->whereIn('expiration_days',$expiration_days)->count() > 0){
                            $adusers = Aduser::where('active',true)->where('password_expired',false)->whereIn('expiration_days',$expiration_days)->get();
                            $num_notif = 0;
    
                            foreach($adusers as $aduser)
                            {
                                Mail::to($aduser->mail)->send(new NotificationMessage($aduser,json_decode(json_encode($parameters))));
                                $last_notification = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
                                $message_data = [
                                    'aduser_id' => $aduser->id,
                                    'sending_time' => $last_notification,
                                    'days' => $aduser->expiration_days
                                ];
                                Message::create($message_data);
                                $aduser->last_notification = $last_notification;
                                $aduser->save();
                                $num_notif++;
                            }
                            Log::info('Se enviaron '. $num_notif . ' notificaciones.');
                        }
                    }
                    else{
                        $data = [
                            'dt_notification' => $now->setTimezone('America/Lima')->isoFormat('DD/MM/YYYY HH:mm'),
                            'dt_last_scheduled_task' => $last_exec->setTimezone('America/Lima')->isoFormat('DD/MM/YYYY HH:mm'),
                            'delay_minutes' => $max_delay
                        ];
                        $admin_email = Setting::where('parameter','admin_email')->first()->value;
                        Mail::to($admin_email)->send(new NotificationScheduledTask(json_decode(json_encode($data))));
                        Log::info('Última actualización de información no se ejecutó en el rango de ' . $max_delay . ' minutos.');
                    }
                }
                Log::info('Tarea ejecutada a las ' . $scheduled_time);
            }
        }
    }
    public function test(){
        $now = Carbon::now();
        $datetime_ini_local = Carbon::now(new DateTimeZone('America/Lima'))->isoFormat('DD-MM-YYYY 00:00:00');
        $datetime_end_local = Carbon::now(new DateTimeZone('America/Lima'))->isoFormat('DD-MM-YYYY 23:59:59');
        $datetime_ini =  Carbon::parse($datetime_ini_local, 'America/Lima')->setTimezone('UTC')->isoFormat('DD-MM-YYYY HH:mm:ss');
        $datetime_end =  Carbon::parse($datetime_end_local, 'America/Lima')->setTimezone('UTC')->isoFormat('DD-MM-YYYY HH:mm:ss');

        return [
            'now' => $now,
            'datetime_ini_local' => $datetime_ini_local,
            'datetime_end_local' => $datetime_end_local,
            'datetime_ini' => $datetime_ini,
            'datetime_end' => $datetime_end,
        ];
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                        'required',
                        'max:255',
                    ],
            'days' => [
                        'required',
                        Rule::unique(Notification::class)
                    ],
        ]);

        Notification::create($request->all());

        return redirect()->route('settings.index');
    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'name' => [
                        'required',
                        'max:255',
                    ],
            'days' => [
                        'required',
                        Rule::unique(Notification::class)->ignore($notification->id)
                    ],
        ]);

        $notification->update($request->all());

        return redirect()->route('settings.index');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('settings.index');
    }
}
