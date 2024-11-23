<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Plan;
use App\Models\Suscripcion;
use Stripe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Bitacora;



class SuscripcionController extends Controller
{
    public function plan(){
        $plan = Plan::all();
        return view('suscripciones/plan', compact('plan'));
    } 

    public function stripe($precio){
        try {
            if (Auth::id()) {

                return view('suscripciones.stripe', compact('precio'));

            } else {
                return redirect()->route('singin'); // Redirige a la ruta del formulario de login
            }
        } catch (\Exception $e) {
            // Manejo del error, por ejemplo, registrar el error y redirigir al usuario a una página de error
            \Log::error('Error en la autenticación: ' . $e->getMessage());
            return redirect()->route('error')->with('error', 'Ha ocurrido un problema. Intente nuevamente.');
        }
    }

    // Number: 4242 4242 4242 4242

    public function stripePost(Request $request, $precio)
    {
        try {
            // Configurar Stripe
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Crear el cargo
            \Stripe\Charge::create([
                "amount" => $precio * 100, // Stripe maneja cantidades en centavos
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "GRACIAS POR TU SUSCRIPCIÓN"
            ]);

            // Obtener el usuario actual
            $usuario = Auth::User();

            // Verificar si el usuario tiene una suscripción activa
            $suscripcionActiva = Suscripcion::where('consumidor_id', $usuario->id)
                ->where('fecha_fin', '>', Carbon::now()) // Verificar si no ha expirado
                ->where('estado', true) // Verificar que esté activa
                ->first();

            if ($suscripcionActiva) {
                return redirect()->route('courses.index')->with('error', 'Ya tienes una suscripción activa. Espera a que expire antes de crear una nueva.');
            }

            // Obtener el plan correspondiente
            $plan = Plan::where('precio', $precio)->first();

            if (!$plan) {
                return redirect()->route('courses.index')->with('error', 'El plan no existe.');
            }

            // Crear la nueva suscripción
            $suscripcion = new Suscripcion();
            $suscripcion->consumidor_id = $usuario->id;
            $suscripcion->plan_id = $plan->id;
            $suscripcion->fecha_inicio = Carbon::now();
            $suscripcion->fecha_fin = Carbon::now()->addDays($plan->dias); // Duración del plan
            $suscripcion->estado = true;
            $suscripcion->save();

            $bitacora = new Bitacora();
            $bitacora->descripcion = "Creación de Suscripcion exitosa";
            $bitacora->usuario_id = $usuario->id;
            $bitacora->usuario = $usuario->nombre;
            $bitacora->direccion_ip = $request->ip();
            $bitacora->navegador = $request->header( 'user-agent');
            $bitacora->tabla = "Suscripcions";
            $bitacora->registro_id = $suscripcion->id;
            $bitacora->fecha_hora = $suscripcion->fecha_inicio;
            $bitacora->save();

            // Mensaje de éxito
            Session::flash('success', '¡PAGO CON ÉXITO!');
            return redirect()->route('courses.index')->with('success', 'Pago realizado exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores
            Session::flash('error', 'Error en el pago: ' . $e->getMessage());
            return back();
        }
    }


    public function bitacora()
    {
        $bitacora = Bitacora::all();
        $suscripcion = Suscripcion::all();
        return view('suscripciones.bitacora', compact('bitacora', 'suscripcion'));
    }


}
