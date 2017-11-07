@extends('estadoprom-mgmt.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar estado de promoción</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('estadoprom-management.update', ['id' => $estadoprom->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }}">
                            <label for="estado" class="col-md-4 control-label">estadoprom estado</label>

                            <div class="col-md-6">
                                <input id="estado" type="text" class="form-control" name="estado" value="{{ $estadoprom->estado }}" required autofocus>

                                @if ($errors->has('estado'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                          <label class="col-md-4 control-label">Cliente</label>
                          <div class="col-md-6">
                              <select class="form-control" name="clientes_id">
                                  @foreach ($clientes as $cliente)
                                      <option {{$cliente->id == $estadoprom->cliente_id ? 'selected' : ''}}>{{$cliente->nombre}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Promoción</label>
                            <div class="col-md-6">
                                <select class="form-control" name="promocion_id">
                                    @foreach ($promociones as $promocion)
                                        <option {{$promocion->promocion_id == $promocion->id ? 'selected' : ''}} value="{{$promocion->id}}">{{$promocion->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
