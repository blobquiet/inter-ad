@extends('layouts.app')

@section('content')
<div id="wrapper">
        <div class="overlay"></div>

        <!-- Sidebar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                       Bootstrap 3
                    </a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-folder"></i> Página 1</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-file-o"></i> Página 2</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-cog"></i> Página 3</a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> Dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">Cabecera</li>
                    <li><a href="#">Acción</a></li>
                    <li><a href="#">Otra acción</a></li>
                    <li><a href="#">Otra cosa aqui</a></li>
                    <li><a href="#">link separado</a></li>
                    <li><a href="#">otro link separado</a></li>
                  </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-bank"></i> Pagina 4</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-dropbox"></i> Pagina 5</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-twitter"></i> Ultima página</a>
                </li>
            </ul>
        </nav>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
          <button type="button" class="hamburger is-closed animated fadeInLeft" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
          </button>
@endsection
