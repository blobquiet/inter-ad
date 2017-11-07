@extends('estadoprom-mgmt.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">Lista de promoción</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-success" href="{{ route('estadoprom-management.create') }}">Agregar estado promoción</a>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('estadoprom-management.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Buscar'])
          @component('layouts.two-cols-search-row', ['items' => ['estado', 'clientes_name'],
          'oldVals' => [isset($searchingVals) ? $searchingVals['estado'] : '', isset($searchingVals) ? $searchingVals['clientes_name'] : '']])
          @endcomponent
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width="10%" clss="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">Estado</th>

                <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Division: activate to sort column ascending">Nombre cliente</th>

                <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="promociones: activate to sort column ascending">Nombre Promoción</th>
                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Acción</th>
              </tr>
            </thead>
            <tbody>

@foreach ($estadoprom as $estadoproms)
    <tr role="row" class="odd">

      <td class="sorting_1">{{ $estadoproms->estado }}</td>


      <td class="hidden-xs">{{ $estadoproms->clientes_name }}</td>
      <td class="hidden-xs">{{ $estadoproms->promociones_name }}</td>
      <td>
        <form class="row" method="POST" action="{{ route('estadoprom-management.destroy', ['id' => $estadoproms->id]) }}" onsubmit = "return confirm('Are you sure?')">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

             <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
              Borrar
            </button>
        </form>
      </td>
  </tr>
@endforeach
</tbody>
<tfoot>
  <tr>
    <tr role="row">
      <th width="10%" clss="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">Estado</th>

      <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Division: activate to sort column ascending">Nombre cliente</th>

      <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="estadopromes: activate to sort column ascending">Nombre promoción</th>
      <th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Acción</th>
  </tr>
  </tr>
</tfoot>
</table>
</div>
</div>
<div class="row">
<div class="col-sm-5">
<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Mostrando a {{count($estadoprom)}} de {{count($estadoprom)}} entradas</div>
</div>
<div class="col-sm-7">
<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
{{ $estadoprom->links() }}
</div>
</div>
</div>
</div>
</div>
<!-- /.box-body -->
</div>
</section>
<!-- /.content -->
</div>
@endsection
