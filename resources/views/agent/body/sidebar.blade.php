<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        Agent<span> Panel</span>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="{{ route('agent.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item nav-category">Turntin</li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#files" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="chevron-right"></i>
              <span class="link-title">Files  </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="files">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ route('agent.all.files') }}" class="nav-link">All Files</a>
                </li>
              </ul>
            </div>
          </li>

         <li class="nav-item">
          <a class="nav-link" href="{{ route('agent.logout') }}">
            <span class="link-title">Logout</span>
          </a>
        </li>

      </ul>
    </div>
  </nav>
