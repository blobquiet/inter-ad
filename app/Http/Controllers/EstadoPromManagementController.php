<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Estadoprom;
use App\Promocion;
use App\Cliente;

class EstadoPromManagementController extends Controller
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
        $estadoprom = DB::table('estadoprom')

        ->leftJoin('clientes', 'estadoprom.clientes_id', '=', 'clientes.id')
        ->leftJoin('promociones', 'estadoprom.promociones_id', '=', 'promociones.id')
        ->select('estadoprom.*', 'clientes.nombre as clientes_name', 'clientes.id as clientes_id', 'promociones.nombre as promociones_name', 'promociones.id as promociones_id')
        ->paginate(5);

        return view('estadoprom-mgmt/index', ['estadoprom' => $estadoprom]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::all();
        $promociones = promocion::all();
        return view('estadoprom-mgmt/create', ['clientes' => $clientes, 'promociones' => $promociones]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateInput($request);
        // Upload image

        $keys = ['estado', 'clientes_id', 'promociones_id'];
        $input = $this->createQueryInput($keys, $request);

        // Not implement yet
        //$input['company_id'] = 0;
        estadoprom::create($input);

        return redirect()->intended('/estadoprom-management');
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
        $estadoprom = estadoprom::find($id);
        // Redirect to state list if updating state wasn't existed
        if ($estadoprom == null || count($estadoprom) == 0) {
            return redirect()->intended('/estadoprom-management');
        }
        $clientes = cliente::all();
        $promociones = promocion::all();
        return view('estadoprom-mgmt/edit', ['estadoprom' => $estadoprom, 'clientes' => $clientes, 'promociones' => $promociones]);
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
        $estadoprom = estadoprom::findOrFail($id);
        $this->validateInput($request);
        // Upload image
        $keys = ['estado','clientes_id', 'promociones_id'];
        $input = $this->createQueryInput($keys, $request);


        estadoprom::where('id', $id)
            ->update($input);

        return redirect()->intended('/estadoprom-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         estadoprom::where('id', $id)->delete();
         return redirect()->intended('/estadoprom-management');
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
          'estado' => $request['estado'],
          'clientes.nombre' => $request['clientes_name']
            ];
        $estadoprom = $this->doSearchingQuery($constraints);

        $constraints['clientes_name'] = $request['clientes_name'];
        return view('estadoprom-mgmt/index', ['estadoprom' => $estadoprom, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('estadoprom')
        ->leftJoin('clientes', 'estadoprom.clientes_id', '=', 'clientes.id')
        ->leftJoin('promociones', 'estadoprom.promociones_id', '=', 'promociones.id')
          ->select('estadoprom.estado as estadoprom_name', 'estadoprom.*','clientes.nombre as clientes_name', 'clientes.id as clientes_id', 'promociones.nombre as promociones_name', 'promociones.id as promociones_id');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }

     /**
     * Load image resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */

    private function validateInput($request) {
        $this->validate($request, [
          'estado' => 'required|max:60',
          'clientes_id' => 'required',
          'promociones_id' => 'required'
        ]);
    }

    private function createQueryInput($keys, $request) {
        $queryInput = [];
        for($i = 0; $i < sizeof($keys); $i++) {
            $key = $keys[$i];
            $queryInput[$key] = $request[$key];
        }
        return $queryInput;
    }
}
