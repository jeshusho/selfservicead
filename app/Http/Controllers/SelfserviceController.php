<?php

namespace App\Http\Controllers;

use App\Exports\AdusersExport;
use App\Models\Aduser;
use App\Models\ScheduledTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Stringable;

class SelfserviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Selfservice', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        Aduser::where('active',true)->update(['active' => false]);
        Carbon::setLocale('es');
        $now = Carbon::now();
        $today = Carbon::today('America/Lima')->isoFormat('YYYY-M-D');
        $now_datetime = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $registros =  json_decode(json_encode($request->all()));
                
        foreach($registros as $r){
            //$texto_convert = strtr(utf8_decode($texto), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
            $expiration_timestamp = null;
            $expiration_days = null;
            $expiration = null;
            if(!is_null($r->ExpirationDate)){
                $expiration_timestamp = intval(str_replace(")/","",str_replace("/Date(", "", $r->ExpirationDate->value)));
                $expiration = Carbon::createFromTimestampMs($expiration_timestamp);
                $expiration1 = Carbon::createFromTimestampMs($expiration_timestamp);
                //$expiration_days = ceil($now->diffInHours($expiration)/24);
                $expiration_days = $now->midDay()->diffInDays($expiration1->midDay());
                if($r->PasswordExpired) $expiration_days = $expiration_days * (-1);
            }
            $add = true;
            if(isset($r->distinguishedName) && str_contains($r->distinguishedName,"OU=IDAT")) $add=false;
            if($add){
                $data = [
                    'username' => $r->SamAccountName,
                    'display_name' => strtoupper($r->Displayname),
                    'given_name' => strtoupper($r->givenName),
                    'mail' => $r->mail,
                    'department' => $r->department,
                    'password_expired' => $r->PasswordExpired,
                    //'expiration_str' => !is_null($r->ExpirationDate) ? $r->ExpirationDate->DateTime : null,
                    //'expiration_str' => !is_null($r->ExpirationDate) ? Carbon::createFromIsoFormat('dddd, MMMM D, YYYY h:mm:ss A', $r->ExpirationDate->DateTime, null, 'es')->isoFormat('llll') : null,
                    'expiration_date' =>  !is_null($expiration) ? $expiration->isoFormat('YYYY-MM-DD HH:mm:ss'): null,
                    'expiration_str' => !is_null($expiration) ? $expiration->setTimezone('America/Lima')->isoFormat("dddd DD \\d\\e MMMM \\d\\e YYYY, hh:mm A"): null,
                    'expiration_days' => $expiration_days,
                    'active' => true
                ];
                if(Aduser::where('username',$r->SamAccountName)->count() == 0) Aduser::create($data);
                else Aduser::where('username',$r->SamAccountName)->update($data);
            }
        }

        $run = ScheduledTask::where('exec_date',$today)->count() + 1;
        ScheduledTask::create(['run' => $run,'exec_date'=> $today, 'exec_datetime' => $now_datetime]);

        return [
            'total' => Aduser::where('active',true)->count()
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aduser  $aduser
     * @return \Illuminate\Http\Response
     */
    public function show(Aduser $aduser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aduser  $aduser
     * @return \Illuminate\Http\Response
     */
    public function edit(Aduser $aduser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aduser  $aduser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aduser $aduser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aduser  $aduser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aduser $aduser)
    {
        //
    }

    public function export_excel()
    {
        $data  = Aduser::select('id','username','display_name','given_name','mail','department','password_expired','expiration_date','expiration_str','expiration_days')
                ->where('active',true)
                ->orderBy('username','ASC')
                ->get();
        $last_schedule_task = ScheduledTask::orderBy('id','DESC')->first();
        $today = Carbon::createFromIsoFormat('YYYY-MM-DD HH:mm:ss', $last_schedule_task->created_at, 'UTC')->setTimezone('America/Lima')->isoFormat('DD/MM/YYYY');
        //$today = Carbon::today('America/Lima')->isoFormat('DD/MM/YYYY');
        $report = new AdusersExport($data, $today);
        return Excel::download($report, 'reporte-usuariosad.xlsx');
    }
}
