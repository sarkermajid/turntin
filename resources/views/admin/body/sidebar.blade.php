 <nav class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
          Admin<span> Panel</span>
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
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category">Turntin</li>

           <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#user" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="chevron-right"></i>
              <span class="link-title">User  </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="user">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ route('all.users') }}" class="nav-link">All Users</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('add.user') }}" class="nav-link">Add User</a>
                </li>
              </ul>
            </div>
          </li>


           <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#files" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="chevron-right"></i>
              <span class="link-title">Files  </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="files">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ route('all.files') }}" class="nav-link">All Files</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#pages" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="chevron-right"></i>
              <span class="link-title">Pages  </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="pages">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ route('all.pages') }}" class="nav-link">All Pages</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('add.page') }}" class="nav-link">Add Page</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#notice" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="chevron-right"></i>
              <span class="link-title">Notice Board </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="notice">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ route('notice') }}" class="nav-link">View</a>
                </li>
              </ul>
            </div>
          </li>

        </ul>
      </div>
    </nav>
