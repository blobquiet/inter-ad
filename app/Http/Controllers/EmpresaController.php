<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Empresa;
use App\Ciudad;

class EmpresaController extends Controller
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
         $empresas = DB::table('empresa')
        ->leftJoin('ciudad', 'empresa.ciudad_id', '=', 'ciudad.id')
        ->select('empresa.id', 'empresa.name', 'ciudad.name as ciudad_name', 'ciudad.id as ciudad_id')
        ->paginate(5);
        return view('system-mgmt/empresa/index', ['empresas' => $empresas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ciudades = ciudad::all();
        return view('system-mgmt/empresa/create', ['ciudades' => $ciudades]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ciudad::findOrFail($request['ciudad_id']);
        $this->validateInput($request);
         empresa::create([
            'name' => $request['name'],
            'ciudad_id' => $request['ciudad_id']
        ]);

        return redirect()->intended('system-management/empresa');
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
        $empresa = empresa::find($id);
        // Redirect to empresa list if updating empresa wasn't existed
        if ($empresa == null || count($empresa) == 0) {
            return redirect()->intended('/system-management/empresa');
        }

        $ciudades = ciudad::all();
        return view('system-mgmt/empresa/edit', ['empresa' => $empresa, 'ciudades' => $ciudades]);
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
        $empresa = empresa::findOrFail($id);
         $this->validate($request, [
        'name' => 'required|max:60'
        ]);
        $input = [
            'name' => $request['name'],
            'ciudad_id' => $request['ciudad_id']
        ];
        empresa::where('id', $id)
            ->update($input);

        return redirect()->intended('system-management/empresa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        empresa::where('id', $id)->delete();
         return redirect()->intended('system-management/empresa');
    }

    /**
     * Search empresa from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
            ];

       $empresas = $this->doSearchingQuery($constraints);
       return view('system-mgmt/empresa/index', ['empresas' => $empresas, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = empresa::query();
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
        'name' => 'required|max:60|unique:empresa'
    ]);
    }
}
