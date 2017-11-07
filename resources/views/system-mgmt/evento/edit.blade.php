@extends('system-mgmt.evento.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Actualizar evento</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('evento.update', ['id' => $evento->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $evento->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                          </div>

                          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                              <label for="infoEv" class="col-md-4 control-label">Información</label>
                              <div class="col-md-6">
                                  <input id="infoEv" type="text" class="form-control" name="infoEv" value="{{ $evento->infoEv }}" required autofocus>

                                  @if ($errors->has('infoEv'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('infoEv') }}</strong>
                                      </span>
                                  @endif
                              </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Fecha inicio evento</label>
                                <div class="col-md-6">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" value="{{ $evento->fechaEv }}" name="fechaEv" class="form-control pull-right" id="fechaEv" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Fecha final evento</label>
                                <div class="col-md-6">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" value="{{ $evento->fechaFEv }}" name="fechaFEv" class="form-control pull-right" id="fechaFEv" required>
                                    </div>
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
