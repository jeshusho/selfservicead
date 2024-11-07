<?php

namespace App\Http\Controllers;

use App\Exports\AdusersExport;
use App\Models\Aduser;
use App\Models\ScheduledTask;
use App\Models\SelfserviceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        Carbon::setLocale('es');
        $expiration_code = Carbon::now()->addMinutes(2);
        $expiration_code_datetime = $expiration_code->isoFormat('YYYY-MM-DD HH:mm:ss');
        //$registros =  json_decode(json_encode($request->all()));
        
        $data = [
            'username' => $request->username,
            'expiration_code' => $expiration_code_datetime,
            'active' => true
        ];

        SelfserviceRequest::create($data);
                
        $user = Aduser::where('username',$request->username)->first();

        return Inertia::render('Selfservice', ['user' => $user]);
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
    public function update(Request $request, SelfserviceRequest $data)
    {
        //Log::info('ID de registro a actualizar:', ['id' => $data->id]);

        $validatedData = $request->validate([
            'username' => 'string|max:255',
            'status' => 'integer',
            //'field1' => 'required|string|max:255',
            //'field2' => 'nullable|integer',
            //'field3' => 'required|email',
            // Agrega todas las validaciones necesarias para los campos que deseas actualizar
        ]);
    
        // Agrega un log para verificar los datos validados
        //Log::info('Datos validados para actualización:', $validatedData);

        // Actualizar el modelo con los datos validados
        //$data->username = $validatedData['username'] ?? $data->username;
        //$data->status = $validatedData['status'] ?? $data->status;
        //$data->save();
        $data->update($validatedData);
        //$data->save();
    
        // Devolver una respuesta exitosa
        return response()->json([
            'message' => 'Registro actualizado con éxito',
            'data' => $data->fresh()
        ], 200);
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

    public function list()
    {
        //return 'hola';
        $data = SelfserviceRequest::select('id','username')->where('status',0)->get();
        $number = SelfserviceRequest::select('username')->where('status',0)->count();

        return [
            'number' => $number,
            'data' => $data
        ];
    }

    
}
