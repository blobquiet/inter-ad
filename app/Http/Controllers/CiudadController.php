<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ciudad;
use App\Departamento;

class CiudadController extends Controller
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
         $ciudades = DB::table('ciudad')
        ->join('departamento', 'ciudad.departamento_id', '=', 'departamento.id')
        ->select('ciudad.id', 'ciudad.name', 'departamento.name as departamento_name', 'departamento.id as departamento_id')
        ->paginate(5);
        return view('system-mgmt/ciudad/index', ['ciudades' => $ciudades]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = Departamento::all();
        return view('system-mgmt/ciudad/create', ['departamentos' => $departamentos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Departamento::findOrFail($request['departamento_id']);
        $this->validateInput($request);
         ciudad::create([
            'name' => $request['name'],
            'departamento_id' => $request['departamento_id']
        ]);

        return redirect()->intended('system-management/ciudad');
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
        $ciudad = ciudad::find($id);
        // Redirect to ciudad list if updating ciudad wasn't existed
        if ($ciudad == null || count($ciudad) == 0) {
            return redirect()->intended('/system-management/ciudad');
        }

        $departamentos = Departamento::all();
        return view('system-mgmt/ciudad/edit', ['ciudad' => $ciudad, 'departamentos' => $departamentos]);
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
        $ciudad = Ciudad::findOrFail($id);
         $this->validate($request, [
        'name' => 'required|max:60'
        ]);
        $input = [
            'name' => $request['name'],
            'departamento_id' => $request['departamento_id']
        ];
        Ciudad::where('id', $id)
            ->update($input);

        return redirect()->intended('system-management/ciudad');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ciudad::where('id', $id)->delete();
         return redirect()->intended('system-management/ciudad');
    }

    /**
     * Search ciudad from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
            ];

       $ciudades = $this->doSearchingQuery($constraints);
       return view('system-mgmt/ciudad/index', ['ciudades' => $ciudades, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Ciudad::query();
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
        'name' => 'required|max:60|unique:ciudad'
    ]);
    }
}
