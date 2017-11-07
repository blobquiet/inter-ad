<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Promocion;
use App\Evento;
use App\Empresa;

class PromocionManagementController extends Controller
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
        $promociones = DB::table('promociones')

        ->leftJoin('empresa', 'promociones.empresa_id', '=', 'empresa.id')
        ->leftJoin('evento', 'promociones.evento_id', '=', 'evento.id')
        ->select('promociones.*', 'empresa.name as empresa_name', 'empresa.id as empresa_id', 'evento.name as evento_name', 'evento.id as evento_id')
        ->paginate(5);

        return view('promociones-mgmt/index', ['promociones' => $promociones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresas = Empresa::all();
        $eventos = Evento::all();
        return view('promociones-mgmt/create', ['empresas' => $empresas, 'eventos' => $eventos]);
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
        $path = $request->file('picture')->store('avatars');
        $keys = ['nombre', 'porcentajeDescuento', 'precioReal', 'empresa_id', 'evento_id'];
        $input = $this->createQueryInput($keys, $request);
        $input['picture'] = $path;
        // Not implement yet
        //$input['company_id'] = 0;
        promocion::create($input);

        return redirect()->intended('/promocion-management');
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
        $promocion = Promocion::find($id);
        // Redirect to state list if updating state wasn't existed
        if ($promocion == null || count($promocion) == 0) {
            return redirect()->intended('/promocion-management');
        }
        $empresas = Empresa::all();
        $eventos = Evento::all();
        return view('promociones-mgmt/edit', ['promocion' => $promocion, 'empresas' => $empresas, 'eventos' => $eventos]);
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
        $promocion = promocion::findOrFail($id);
        $this->validateInput($request);
        // Upload image
        $keys = ['nombre', 'porcentajeDescuento', 'precioReal', 'empresa_id', 'evento_id'];
        $input = $this->createQueryInput($keys, $request);
        if ($request->file('picture')) {
            $path = $request->file('picture')->store('avatars');
            $input['picture'] = $path;
        }

        promocion::where('id', $id)
            ->update($input);

        return redirect()->intended('/promocion-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         promocion::where('id', $id)->delete();
         return redirect()->intended('/promocion-management');
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
          'nombre' => $request['nombre'],
          'empresa.name' => $request['empresa_name']
            ];
        $promociones = $this->doSearchingQuery($constraints);

        $constraints['empresa_name'] = $request['empresa_name'];
        return view('promociones-mgmt/index', ['promociones' => $promociones, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('promociones')
        ->leftJoin('empresa', 'promociones.empresa_id', '=', 'empresa.id')
        ->leftJoin('evento', 'promociones.evento_id', '=', 'evento.id')
        ->select('promociones.nombre as promociones.name', 'promociones.*','empresa.name as empresa_name', 'empresa.id as empresa_id', 'evento.name as evento_name', 'evento.id as evento_id');
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
    public function load($name) {
         $path = storage_path().'/app/avatars/'.$name;
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    private function validateInput($request) {
        $this->validate($request, [
          'nombre' => 'required|max:60',
          'porcentajeDescuento' => 'required',
          'precioReal' => 'required',
          'empresa_id' => 'required',
          'evento_id' => 'required'
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
