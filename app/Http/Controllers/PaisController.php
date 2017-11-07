<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pais;

class PaisController extends Controller
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
        $paises = Pais::paginate(5);

        return view('system-mgmt/pais/index', ['paises' => $paises]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system-mgmt/pais/create');
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
         Pais::create([
            'name' => $request['name'],
            'pais_code' => $request['pais_code']
        ]);

        return redirect()->intended('system-management/pais');
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
        $pais = Pais::find($id);
        // Redirect to pais list if updating pais wasn't existed
        if ($pais == null || count($pais) == 0) {
            return redirect()->intended('/system-management/pais');
        }

        return view('system-mgmt/pais/edit', ['pais' => $pais]);
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
        $pais = Pais::findOrFail($id);
        $input = [
            'name' => $request['name'],
            'pais_code' => $request['pais_code']
        ];
        $this->validate($request, [
        'name' => 'required|max:60'
        ]);
        Pais::where('id', $id)
            ->update($input);

        return redirect()->intended('system-management/pais');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pais::where('id', $id)->delete();
         return redirect()->intended('system-management/pais');
    }

    /**
     * Search pais from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name'],
            'pais_code' => $request['pais_code']
            ];

       $paises = $this->doSearchingQuery($constraints);
       return view('system-mgmt/pais/index', ['paises' => $paises, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = pais::query();
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
        'name' => 'required|max:60|unique:pais',
        'pais_code' => 'required|max:3|unique:pais'
    ]);
    }
}
