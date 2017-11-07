@extends('promociones-mgmt.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar promocion</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('promocion-management.update', ['id' => $promocion->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $promocion->nombre }}" required autofocus>

                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('porcentajeDescuento') ? ' has-error' : '' }}">
                            <label for="porcentajeDescuento" class="col-md-4 control-label">% Descuento</label>

                            <div class="col-md-6">
                                <input id="porcentajeDescuento" type="text" class="form-control" name="porcentajeDescuento" value="{{ $promocion->porcentajeDescuento }}" required>

                                @if ($errors->has('porcentajeDescuento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('porcentajeDescuento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('precioReal') ? ' has-error' : '' }}">
                            <label for="precioReal" class="col-md-4 control-label">Precio real</label>

                            <div class="col-md-6">
                                <input id="precioReal" type="text" class="form-control" name="precioReal" value="{{ $promocion->precioReal }}" required>

                                @if ($errors->has('precioReal'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('precioReal') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Empresa</label>
                            <div class="col-md-6">
                                <select class="form-control" name="empresa_id">
                                    @foreach ($empresas as $empresa)
                                        <option {{$promocion->empresa_id == $empresa->id ? 'selected' : ''}} value="{{$empresa->id}}">{{$empresa->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Evento</label>
                            <div class="col-md-6">
                                <select class="form-control" name="evento_id">
                                    @foreach ($eventos as $evento)
                                        <option {{$promocion->evento_id == $evento->id ? 'selected' : ''}} value="{{$evento->id}}">{{$evento->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="avatar" class="col-md-4 control-label" >Foto</label>
                            <div class="col-md-6">
                                <img src="../../{{$promocion->picture }}" width="50px" height="50px"/>
                                <input type="file" id="picture" name="picture" />
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
