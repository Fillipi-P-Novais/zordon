<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function layoutDois()
    {
        return view('main_layout_2');
    }

    public function calcular(Request $request)
    {
        $valor_procedimento = $request->valor;
        $porcentagem = $request->porcentagem;

       // dd($porcentagem);

        $aux1 =  $valor_procedimento * 30 / 100;
        $auxiliar1 = number_format($aux1, 2, '.', '');

        // $aux2 =  $valor_procedimento * 20 / 100;
        // $auxiliar2 = number_format($aux2, 2, '.', '');

        $instr =  $valor_procedimento * 10 / 100;
        $instrumentador = number_format($instr, 2, '.', '');

        $anest =  $valor_procedimento * 40 / 100;
        $anestesista = number_format($anest, 2, '.', '');

        $conc = $valor_procedimento * 5 / 100;
        $concierge = number_format($conc, 2, '.', '');

        $total1 = $valor_procedimento + $auxiliar1 + $instrumentador + $anestesista + $concierge; // $auxiliar2 +
        $total_sem_acrescimo = number_format($total1, 2, '.', '');


        $aux1_com_acrescimo = $aux1 * $porcentagem / 100;
        $auxiliar1_com_acrescimo = number_format($aux1_com_acrescimo, 2, '.', '');

        // $aux2_com_acrescimo = $aux2 * $porcentagem / 100;
        // $auxiliar2_com_acrescimo = number_format($aux2_com_acrescimo, 2, '.', '');

        $instr_com_acrescimo = $instrumentador * $porcentagem / 100;
        $instrumentador_com_acrescimo = number_format($instr_com_acrescimo, 2, '.', '');

        $anest_com_acrescimo = $anestesista * $porcentagem / 100;
        $anestesista_com_acrescimo = number_format($anest_com_acrescimo, 2, '.', '');

        $conc_com_acrescimo = $concierge * $porcentagem / 100;
        $concierge_com_acrescimo = number_format($conc_com_acrescimo, 2, '.', '');

        $total2 = $total_sem_acrescimo + $auxiliar1_com_acrescimo + $instrumentador_com_acrescimo +  $anestesista_com_acrescimo + $concierge_com_acrescimo; //$auxiliar2_com_acrescimo + 
        $total_com_acrescimo = number_format($total2, 2, '.', '');
        
        $dados = ([
            ['auxiliar1' => $auxiliar1],
            // ['auxiliar2' => $auxiliar2],
            ['instrumentador' => $instrumentador],
            ['anestesista' => $anestesista],
            ['concierge' => $concierge],
            ['total_sem_acrescimo' => $total_sem_acrescimo],
            ['auxiliar1_com_acrescimo' => $auxiliar1_com_acrescimo],
            // ['auxiliar2_com_acrescimo' => $auxiliar2_com_acrescimo],
            ['instrumentador_com_acrescimo' => $instrumentador_com_acrescimo],
            ['anestesista_com_acrescimo' => $anestesista_com_acrescimo],
            ['concierge_com_acrescimo' => $concierge_com_acrescimo],
            ['total_com_acrescimo' => $total_com_acrescimo],
        ]);
        return response()->json(['dados' => $dados]);
    }
}
