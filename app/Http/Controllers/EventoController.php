<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Evento;
use Response;


class EventoController extends Controller
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
          $eventos = evento::paginate(5);

          return view('system-mgmt/evento/index', ['eventos' => $eventos]);
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
          return view('system-mgmt/evento/create');
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
           evento::create([
             'name' => $request['name'],
             'infoEv' => $request['infoEv'],
             'fechaEv' => $request['fechaEv'],
             'fechaFEv' => $request['fechaFEv']
          ]);

          return redirect()->intended('system-management/evento');
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
          $evento = evento::find($id);
          // Redirect to evento list if updating evento wasn't existed
          if ($evento == null || count($evento) == 0) {
              return redirect()->intended('/system-management/evento');
          }

          return view('system-mgmt/evento/edit', ['evento' => $evento]);
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
          $evento = evento::findOrFail($id);
          $this->validateInput($request);
          $input = [
              'name' => $request['name'],
              'infoEv' => $request['infoEv'],
              'fechaEv' => $request['fechaEv'],
              'fechaFEv' => $request['fechaFEv']
          ];
          evento::where('id', $id)
              ->update($input);

          return redirect()->intended('system-management/evento');
      }

      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function destroy($id)
      {
          evento::where('id', $id)->delete();
           return redirect()->intended('system-management/evento');
      }

      /**
       * Search evento from database base on some specific constraints
       *
       * @param  \Illuminate\Http\Request  $request
       *  @return \Illuminate\Http\Response
       */
      public function search(Request $request) {
          $constraints = [
              'name' => $request['name'],
              'infoEv' => $request['infoEv']
              ];

         $eventos = $this->doSearchingQuery($constraints);
         return view('system-mgmt/evento/index', ['eventos' => $eventos, 'searchingVals' => $constraints]);
      }

      private function doSearchingQuery($constraints) {
          $query = evento::query();
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
          'name' => 'required|max:60|unique:evento',
          'infoEv' => 'required|max:60|unique:evento',
          'fechaEv' => 'required',
          'fechaFEv' => 'required'
      ]);
      }
  }
