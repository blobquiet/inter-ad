@extends('estadoprom-mgmt.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Agregar estado de promoción</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('estadoprom-management.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }}">
                            <label for="estado" class="col-md-4 control-label">Estado</label>

                            <div class="col-md-6">
                                <input id="estado" type="text" class="form-control" name="estado" value="{{ old('estado') }}" required autofocus>

                                @if ($errors->has('estado'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Clientes</label>
                            <div class="col-md-6">
                                <select class="form-control" name="clientes_id">
                                    @foreach ($clientes as $clientes)
                                        <option value="{{$clientes->id}}">{{$clientes->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Promociones</label>
                            <div class="col-md-6">
                                <select class="form-control" name="promociones_id">
                                    @foreach ($promociones as $promociones)
                                        <option value="{{$promociones->id}}">{{$promociones->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear
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
