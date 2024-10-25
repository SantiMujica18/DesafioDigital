<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\City;


class ClimaController extends Controller
{

    public function index()
    {
        $cities = City::all();

        return view('index', compact('cities'));
    }

    public function respuesta(Request $request)
    {
        $city = $request->city;

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$city}&APPID=f801eb72c8a0a2202d986b894091d14a");

        if ($response->successful()) {
            $datosClima = $response->json();
        } else {
            return response()->json(['error' => 'Error en la respuesta de la API del clima'], 500);
        }

        $response2 = Http::get("https://api.exchangerate-api.com/v4/latest/COP");

        if ($response2->successful()) {
            $datosCambio = $response2->json();
        } else {
            return response()->json(['error' => 'Error en la respuesta de la API de tipo de cambio'], 500);
        }

        $result = [
            'clima' => $datosClima,
            'tasa_cambio' => $datosCambio
        ];

        return response()->json($result);
    }
}
