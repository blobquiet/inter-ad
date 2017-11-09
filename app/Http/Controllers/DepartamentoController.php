<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Departamento;
use App\Pais;

class DepartamentoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $departamentos = DB::table('departamento')
        ->join('pais', 'departamento.pais_id', '=', 'pais.id')
        ->select('departamento.id', 'departamento.name', 'pais.name as pais_name', 'pais.id as pais_id')
        ->paginate(5);
        return view('system-mgmt/departamento/index', ['departamentos' => $departamentos]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises = Pais::all();
        return view('system-mgmt/departamento/create', ['paises' => $paises]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Pais::findOrFail($request['pais_id']);
        $this->validateInput($request);
         Departamento::create([
            'name' => $request['name'],
            'pais_id' => $request['pais_id']
        ]);

        return redirect()->intended('system-management/departamento');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $departamento = Departamento::find($id);
        // Redirect to departamento list if updating departamento wasn't existed
        if ($departamento == null || count($departamento) == 0) {
            return redirect()->intended('/system-management/departamento');
        }

        $paises = Pais::all();
        return view('system-mgmt/departamento/edit', ['departamento' => $departamento, 'paises' => $paises]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);
         $this->validate($request, [
        'name' => 'required|max:60'
        ]);
        $input = [
            'name' => $request['name'],
            'pais_id' => $request['pais_id']
        ];
        Departamento::where('id', $id)
            ->update($input);

        return redirect()->intended('system-management/departamento');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Departamento::where('id', $id)->delete();
         return redirect()->intended('system-management/departamento');
    }

    /**
     * Search departamento from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
            ];

       $departamentos = $this->doSearchingQuery($constraints);
       return view('system-mgmt/departamento/index', ['departamentos' => $departamentos, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Departamento::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
    private function validateInput($request) {
        $this->validate($request, [
        'name' => 'required|max:60|unique:departamento'
    ]);
    }
}
