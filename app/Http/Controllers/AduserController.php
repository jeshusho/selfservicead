<?php

namespace App\Http\Controllers;

use App\Models\Aduser;
use App\Models\ScheduledTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stringable;

class AduserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Aduser::where('active',true)->update(['active' => false]);
        $now = Carbon::now();
        $today = Carbon::today('America/Lima')->isoFormat('YYYY-M-D');
        $registros =  json_decode(json_encode($request->all()));
        
        return $registros;
        foreach($registros as $r){
            //$texto_convert = strtr(utf8_decode($texto), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
            $expiration_timestamp = null;
            $expiration_days = null;
            $expiration = null;
            if(!is_null($r->ExpirationDate)){
                $expiration_timestamp = intval(str_replace(")/","",str_replace("/Date(", "", $r->ExpirationDate->value)));
                $expiration = Carbon::createFromTimestampMs($expiration_timestamp);
                $expiration_days = ceil($now->diffInHours($expiration)/24);
            }

            $data = [
                'username' => $r->SamAccountName,
                'display_name' => strtoupper($r->Displayname),
                'given_name' => strtoupper($r->givenName),
                'mail' => $r->mail,
                'department' => $r->department,
                'password_expired' => $r->PasswordExpired,
                'expiration_str' => !is_null($r->ExpirationDate) ? $r->ExpirationDate->DateTime : null,
                'expiration_date' =>  !is_null($expiration) ? $expiration->isoFormat('YYYY-MM-DD HH:mm:ss'): null,
                'expiration_days' => $expiration_days,
                'active' => true
            ];
            if(Aduser::where('username',$r->SamAccountName)->count() == 0) Aduser::create($data);
            else Aduser::where('username',$r->SamAccountName)->update($data);
        }

        $run = ScheduledTask::where('exec_date',$today)->count() + 1;
        ScheduledTask::create(['run' => $run,'exec_date'=> $today]);

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
}
