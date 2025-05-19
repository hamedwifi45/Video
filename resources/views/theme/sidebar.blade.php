    <!-- Sidebar -->
    <ul class="pr-0 navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <div class="sidebar-brand-icon">
        <svg width="40" height="40" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M58 16H6C3.79086 16 2 17.7909 2 20V44C2 46.2091 3.79086 48 6 48H58C60.2091 48 62 46.2091 62 44V20C62 17.7909 60.2091 16 58 16Z" fill="#FF0000"/>
            <path d="M25 32L39 40V24L25 32Z" fill="white"/>
        </svg>
    </div>
</a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ request()->is('admin')? 'active' : '' }}">
        <a class="nav-link text-right" href="{{ route('admin.index') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>الإحصائيات</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">


      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ request()->routeIs('channels.index')? 'active' : '' }}">
        <a class="nav-link text-right" href="{{ route('channels.index') }}">
        <i class="fas fa-user-lock"></i>
          <span>الصلاحيات</span>
        </a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ request()->routeIs('channels.block')? 'active' : '' }}">
        <a class="nav-link text-right" href="{{ route('channels.block') }}">
        <i class="fas fa-lock"></i>
          <span>القنوات المحظورة</span>
        </a>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item {{ request()->routeIs('channels')? 'active' : '' }}">
        <a class="nav-link text-right" href="{{ route('channels') }}">
        <i class="fas fa-film"></i>
          <span>القنوات</span>
        </a>
      </li>



      <!-- Nav Item - Charts -->
      <li class="nav-item {{ request()->routeIs('TopVideos')? 'active' : '' }}">
        <a class="nav-link text-right" href="{{ route('TopVideos') }}">
        <i class="fas fa-table"></i>
          <span>الفيديوهات الأكثر مشاهدة</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->