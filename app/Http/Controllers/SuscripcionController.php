<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Plan;
use App\Models\Suscripcion;
use Stripe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

// Number: 4242 4242 4242 4242

class SuscripcionController extends Controller
{
    public function plan(){
        $plan = Plan::all();
        return view('plan/index', compact('plan'));
    }

    // public function pago($precio) {
    //     $plan = Plan::all();
    //     if (Auth::id()) {
    //         return view('pago/inicio', compact('plan', 'precio'));
    //     } else {
    //         return redirect()->route('singin'); // Redirige a la ruta del formulario de login
    //     } 
    // }
    

    public function stripe($precio){  
        if (Auth::id()) { 
            return view('stripe.inicio', compact('precio'));
        } else {
            return redirect()->route('singin'); // Redirige a la ruta del formulario de login
        }
    }

    public function stripePost(Request $request, $precio)
    {
        
            // Configurar Stripe
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Crear el cargo
            Stripe\Charge::create([
                "amount" => $precio * 100, // Stripe maneja cantidades en centavos
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "GRACIAS POR TU SUSCRIPCIÓN"
            ]);

            // Obtener el usuario actual
            $usuario = Auth::user();

            // Obtener el plan correspondiente
            $plan = Plan::where('precio', $precio)->first();           

            // Crear la suscripción
            $suscripcion = new Suscripcion();
            $suscripcion->consumidor_id = $usuario->id;
            $suscripcion->plan_id = $plan->id;
            $suscripcion->fecha_inicio = Carbon::now();
            $suscripcion->fecha_fin = Carbon::now()->addMonths($plan->dias); // Duración del plan
            $suscripcion->estado = true;
            $suscripcion->save();

            // Mensaje de éxito
            Session::flash('success', '¡PAGO CON ÉXITO!');
            return redirect()->route('courses.index')->with('success', 'pago exitosamente');

       
        
    }

    



}
