<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{route('dashboards.index')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-gear"></i>
                <span>Contacts</span>
            </a>
            </li>
        </ul>
      </li><!-- End Components Nav -->

      <!-- End Icons Nav -->

      <li class="nav-heading">Menus</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#page-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="page-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('components.index')}}">
                    <i class="bi bi-circle"></i>
                    <span>Components</span>
                </a>
            </li><!-- End Profile Page Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('units.index')}}">
                    <i class="bi bi-circle"></i>
                    <span>Units</span>
                </a>
            </li><!-- End Profile Page Nav -->
        </ul>
      </li>

      <li class="nav-heading">Marketing</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('customers.index')}}">
          <i class="bi bi-people-fill"></i>
          <span>Customer</span>
        </a>
      </li><!-- End Profile Page Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('leads.index')}}">
          <i class="bi bi-bookmark-check"></i>
          <span>Leads</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-heading">Analists</li>

      <li class="nav-heading">Productions</li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="">
          <i class="bi bi-person-add"></i>
          <span>Users</span>
        </a>
      </li><!-- End Profile Page Nav -->

<!-- End Dashboard Nav -->

    </ul>

  </aside>
