<?php

namespace App\Http\Controllers;

use App\Models\diario;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDados()
    {
        $dados = (new diario())::get()->all();
        return response()->json($dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res = 0; 
        try{
            if($request->id == 0) { // Cadastra
                $_diario = new diario();
            }
            else { // Altera
                $_diario = diario::where('id', $request->id)->first();
            }
            $_diario->title = $request->titulo;
            $_diario->content = $request->conteudo;
            $_diario->save();
            $res = 1;
        }
        catch(Exception $e) {
            $e->getMessage();
        }
        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\diario  $diario
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $dados = diario::where('id', $request->id)->first();
        return response()->json($dados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\diario  $diario
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $dados = diario::where('id', $request->id)->first();
        return response()->json($dados);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\diario  $diario
     * @return \Illuminate\Http\Response
     */
    public function excluir(Request $request)
    {
        $res = 0;
        try{
            $result = diario::where('id', $request->id)->firstorfail()->delete();
            if($result) {
                $res = 1;
            }
        }
        catch(Exception $e) {
            $e->getMessage();
            //$res = $e->getMessage();
        }
        return response()->json($res);
    }

    public function gerarPdf($id) {
        $dados =  diario::where('id', $id)->first();
        $pdf = PDF::loadView('diario-pdf', ['dados' => $dados])->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
