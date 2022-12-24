 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{ asset('image/logo-mts.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link @yield('active-dashboard')">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header">MASTER</li>
        
          <li class="nav-item">
            <a href="#" class="nav-link @yield('active-data-master')">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Master
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/kategori') }}" class="nav-link  @yield('active-kategori')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/rak') }}" class="nav-link  @yield('active-rak')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rak</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/penerbit') }}" class="nav-link  @yield('active-penerbit')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penerbit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/buku') }}" class="nav-link  @yield('active-buku')">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ url('/siswa') }}" class="nav-link @yield('active-siswa')">
              <i class="fas fa-user mr-1"></i>
              <p>
                Siswa
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('/transaksi') }}" class="nav-link @yield('active-transaksi')">
              <i class="fas fa-hands mr-1"></i>
              <p>
                Transaksi
              </p>
            </a>
          </li>

          <!-- <li class="nav-item">
            <a href="/chart" class="nav-link @yield('active-chart')">
              <i class="fas fa-chart-bar"></i>
              <p>
                Chart
              </p>
            </a>
          </li> -->
         
          @role('admin')
              <li class="nav-header">ADMIN</li>

              <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link @yield('active-user')">
                  <i class="fas fa-users mr-1"></i>
                  <p>
                    User
                  </p>
                </a>
              </li>

              <li class="nav-header">Laporan</li>

              <li class="nav-item">
                <a href="{{ url('/laporan/peminjaman') }}" class="nav-link @yield('active-laporan-peminjaman')">
                  <i class="fas fa-file-pdf mr-1"></i>
                  <p>
                    Peminjaman
                  </p>
                </a>
              </li>
          @endrole
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>