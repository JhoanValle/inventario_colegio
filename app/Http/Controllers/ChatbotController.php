<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Diagnostico;
use App\Models\Equipo;
use App\Models\Movimiento;
use App\Helpers\BrowserHelper;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function preguntar(Request $request)
    {
        $request->validate([
            'mensaje' => 'required',
            'equipo_id' => 'required|exists:equipos,id'
        ]);

        $mensaje = trim($request->mensaje);
        $mensaje = str_ireplace('anticlick', 'botón del mouse', $mensaje);

        $equipo = Equipo::find($request->equipo_id);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [

            "model" => "llama-3.1-8b-instant",

            "messages" => [
                [
                    "role" => "system",
                    "content" => "Eres un técnico profesional en hardware.

Responde SOLO en JSON válido:

{
  \"causas\": [\"...\"],
  \"soluciones\": [\"...\"],
  \"recomendaciones\": [\"...\"],
  \"riesgo\": \"Bajo | Medio | Alto\"
}

Reglas:
- Máximo 4 causas
- Máximo 4 soluciones
- Máximo 3 recomendaciones
- NO escribir texto fuera del JSON
- Si hay caída o golpe → riesgo ALTO
- Analiza SOLO el equipo indicado"
                ],
                [
                    "role" => "user",
                    "content" => "Equipo: {$equipo->nombre}\nProblema: {$mensaje}"
                ]
            ]
        ]);

        $data = $response->json();

        if (!isset($data['choices'][0]['message']['content'])) {
            return response()->json([
                'error' => 'Error al obtener respuesta de la IA'
            ], 500);
        }

        $respuestaIA = $data['choices'][0]['message']['content'];

        $respuestaIA = str_replace(['```json', '```'], '', $respuestaIA);

        $json = json_decode($respuestaIA, true);

        if (!$json) {
            return response()->json([
                'error' => 'La IA no devolvió JSON válido',
                'raw' => $respuestaIA
            ], 500);
        }

        if (preg_match('/caida|cayo|golpe|impacto/i', $mensaje)) {
            $json['riesgo'] = 'Alto';
        }

        $diagnostico = Diagnostico::create([
            'equipo_id' => $request->equipo_id,
            'problema' => $mensaje,
            'causa' => implode("\n", $json['causas'] ?? []),
            'solucion' => implode("\n", $json['soluciones'] ?? []),
            'recomendacion' => implode("\n", $json['recomendaciones'] ?? []),
            'riesgo' => $json['riesgo'] ?? 'No definido',
        ]);

        // Registro en movimientos
        Movimiento::create([
            'equipo_id' => $request->equipo_id,
            'user_id' => Auth::id(),
            'modulo' => 'Diagnósticos',
            'accion' => 'Crear',
            'descripcion' => 'Se generó un diagnóstico para el equipo: ' . $equipo->nombre,
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return response()->json($json);
    }
}