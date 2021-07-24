<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SutranController extends Controller
{
    public function index(){
        return view('reportes.sutran');
    }
    public function reporte(Request $request){
            $data=DB::table('dispositivo as d')
            ->join('sutran as s','s.placa','d.placa')
            ->select('s.id','d.imei','d.placa','s.latitud','s.longitud','s.velocidad','s.rumbo','s.evento','s.estado','s.fecha')->where('d.id',$request->dispositivo)->whereBetween('fecha',[$request->fechainicio,$request->fechafinal])->get();
            return $data;
    }
}
