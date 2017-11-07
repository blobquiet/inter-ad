  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset("/bower_components/AdminLTE/dist/img/photo.jpg") }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name}}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Conexión segura</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="/">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</i> <span>Inicio</span></a></li>
        <li><a href="{{ url('cliente-management') }}"><i class="fa fa-link"></i> <span>Gestor de cliente</span></a></li>
        <li><a href="{{ url('promocion-management') }}"><i class="fa fa-link"></i> <span>Gestor de promoción</span></a></li>

        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Gestor del sistema</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


            <li><a href="{{ url('estadoprom-management') }}">Estado Prom</a></li>
            <li><a href="{{ url('system-management/pais') }}">Pais</a></li>
            <li><a href="{{ url('system-management/departamento') }}">Departamento</a></li>
            <li><a href="{{ url('system-management/ciudad') }}">Ciudad</a></li>
            <li><a href="{{ url('system-management/empresa') }}">Empresa</a></li>
            <li><a href="{{ url('system-management/evento') }}">Evento</a></li>

          </ul>
        </li>
        <li><a href="{{ route('user-management.index') }}"><i class="fa fa-link"></i> <span>Gestor de usuarios</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
