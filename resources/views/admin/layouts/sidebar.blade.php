<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">Stisla</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">

        <li class="menu-header">Dashboard</li>
        <li @if ($pageSlug == 'dashboard') class="active" @endif>
          <a class="nav-link" href="{{ route('home')}}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
        </li>

        <li class="menu-header">Akun</li>
        <li @if ($pageSlug == 'driver') class="active" @endif class="nav-item"> 
          <a href="{{route('admin.driver.index')}}" class="nav-link">
            <i class="fas fa-steering-wheel"></i> <span>Supir</span>
          </a>
        </li>
        <li @if ($pageSlug == 'customer') class="active" @endif class="nav-item"> 
          <a href="{{route('admin.customer.index')}}" class="nav-link">
            <i class="fas fa-user"></i> <span>Customer</span>
          </a>
        </li>
        <li @if ($pageSlug == 'createAccount') class="active" @endif class="nav-item">
          <a class="nav-link" href="{{route('admin.user.create')}}">
            <i class="fas fa-plus"></i> <span>Tambah Akun</span>
          </a>
        </li>

        <li class="menu-header">Pesanan</li>
        <li @if ($pageSlug == '' or $pageSlug == '') class="nav-item dropdown active" @endif class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-rv"></i></i> <span>Door to Door</span></a>
          <ul class="dropdown-menu">
            <li @if ($pageSlug == '') class="active" @endif>
              <a class="nav-link" href="{{route('admin.doorToDoor_order.index')}}">
                <i class="far fa-list-ul"></i> index
              </a>
            </li>
          </ul>
        </li>

        <li class="menu-header">Layanan</li>
        <li class="nav-item dropdown"> 
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-car"></i> <span>Sewa Mobil</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="">Coming Soon</a></li>
          </ul>
        </li>

        <li @if ($pageSlug == 'doorToDoor_service_create' or $pageSlug == 'doorToDoor_service_scheduled' or $pageSlug == 'doorToDoor_service') class="nav-item dropdown active" @endif class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-rv"></i></i> <span>Door to Door</span></a>
          <ul class="dropdown-menu">
            <li @if ($pageSlug == 'doorToDoor_service_scheduled') class="active" @endif>
              <a class="nav-link" href="{{route('admin.doorToDoor_service.scheduled_index')}}">
                <i class="far fa-calendar"></i> Jadwal
              </a>
            </li>
            <li>
              <a class="nav-link" href="">
                <i class="far fa-road"></i> Dalam Proses
              </a>
            </li>
            <li>
              <a class="nav-link" href="">
                <i class="far fa-check"></i> Selesai
              </a>
            </li>
            <li @if ($pageSlug == 'doorToDoor_service_create') class="active" @endif>
              <a class="nav-link" href="{{route('admin.doorToDoor_service.create')}}">
                <i class="far fa-plus"></i> Tambah Jadwal
              </a>
            </li>
          </ul>
        </li>
        
        <li class="menu-header">Aset</li>
        <li @if ($pageSlug == 'car') class="active" @endif>
          <a href="{{ route('admin.car.index') }}" class="nav-link"><i class="fas fa-warehouse"></i> <span>Mobil</span></a>
        </li>

        <li @if ($pageSlug == 'savingAccount') class="active" @endif>
          <a href="{{route('admin.saving_account.index')}}" class="nav-link"><i class="fas fa-money-check"></i> <span>Rekening Pembayaran</span></a>
        </li>

        <br><br>
      </ul>
  </aside>
</div>