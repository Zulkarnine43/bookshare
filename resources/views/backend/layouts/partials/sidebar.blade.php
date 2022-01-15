  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.index') }}">
          <div class="sidebar-brand-icon rotate-n-15">
              <i class="fas fa-file"></i>
          </div>
          <div class="sidebar-brand-text mx-3">Admin Panel</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
          <a class="nav-link" href="{{ route('admin.index') }}">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
              aria-controls="collapseTwo">
              <i class="fas fa-fw fa-file"></i>
              <span>Books</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Manage Books & All</h6>
                  <a class="collapse-item" href="{{ route('admin.books.index') }}">Books</a>
                  <a class="collapse-item" href="{{ route('admin.books.unapprove') }}">
                    Unapproved Book List
                    <span class="badge badge-warning">
                        {{ count( App\Book::where('is_approved', 0)->get()) }}
                    </span>
                </a>

                <a class="collapse-item" href="{{ route('admin.books.approved') }}" >
                    Approved Book List
                    <span class="badge badge-success">
                        {{ count( App\Book::where('is_approved', 1)->get()) }}
                    </span>
                </a>

                  <a class="collapse-item" href="{{ route('admin.categories.index') }}">Categories</a>
                  <a class="collapse-item" href="{{ route('admin.authors.index') }}">Authors</a>
                  <a class="collapse-item" href="{{ route('admin.publishers.index') }}">Publishers</a>


              </div>
          </div>
      </li>

     

      <!-- Nav Item - Charts -->
      <li class="nav-item">
          <a class="nav-link" href="charts.html">
              <i class="fas fa-fw fa-sign-out"></i>
              <span>Logout</span></a>
      </li>

      {{-- <!-- Nav Item - Tables -->
      <li class="nav-item">
          <a class="nav-link" href="tables.html">
              <i class="fas fa-fw fa-table"></i>
              <span>Tables</span></a>
      </li> --}}

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      {{-- <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div> --}}

      <!-- Sidebar Message -->
      {{-- <div class="sidebar-card d-none d-lg-flex">
          <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
          <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components,
              and more!</p>
          <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to
              Pro!</a>
      </div> --}}

  </ul>
  <!-- End of Sidebar -->
