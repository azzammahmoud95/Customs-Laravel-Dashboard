<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2  text-white min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <h3 class="fs-5 d-none text-white d-sm-inline">Costumes Menu</h3>
                </a>
                <!-- <li> -->

                <ul class="list-unstyled w-100 flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                    id="menu">
                    
                    <li class="nav-item">
                    <a href="{{ route('home') }}"
                            class="nav-link w-100 d-inline-block align-middle px-10 text-white @if(Request::is('/')) bg-success text-white font-weight-bold @endif">
                            <i class="bi bi-speedometer2"></i><span class="ms-1 d-none d-sm-inline ml-1">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories') }}"
                            class="nav-link w-100 d-inline-block align-middle px-10 text-white @if(Request::is('categories*')) bg-success text-white font-weight-bold @endif">
                            <i class="bi bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Category</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('taxes') }}" data-bs-toggle="collapse"
                            class="nav-link w-100 d-inline-block align-middle px-10 text-white @if(Request::is('taxes*')) bg-success text-white font-weight-bold @endif">
                            <i class="bi bi-tags"></i> <span class="ms-1 d-none d-sm-inline">Taxes</span>
                        </a>
                        <!-- <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1 </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2 </a>
                            </li>
                        </ul> -->
                        <!--***********  SubMenu -->
                    </li>
                    <li>
                        <a href="{{ route('roles') }}"
                            class="nav-link w-100 d-inline-block align-middle px-10 text-white @if(Request::is('roles*')) bg-success text-white font-weight-bold @endif">
                            <i class="bi bi-person-lines-fill"></i> <span
                                class="ms-1 d-none d-sm-inline">Roles</span></a>
                    </li>

                    <li>
                        <a href="{{ route('products') }}" data-bs-toggle="collapse"
                            class="nav-link w-100 d-inline-block align-middle px-10 text-white @if(Request::is('products*')) bg-success text-white font-weight-bold @endif">
                            <i class="bi bi-box-seam"></i> <span class="ms-1 d-none d-sm-inline">Products</span> </a>

                    <li>
                        <a href="{{ route('informations') }}"
                            class="nav-link w-100 d-inline-block align-middle px-10 text-white @if(Request::is('informations*')) bg-success text-white font-weight-bold @endif">
                            <i class="bi bi-info-circle"></i> <span class="ms-1 d-none d-sm-inline">Informations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contacts') }}"
                            class="nav-link w-100 d-inline-block align-middle px-10 text-white @if(Request::is('contacts*')) bg-success text-white font-weight-bold @endif">
                            <i class="bi bi-envelope"></i> <span class="ms-1 d-none d-sm-inline">Contacts</span> </a>
                    </li>
                </ul>
                <!-- <hr> -->
                <!-- <div class="dropdown pb-4"> -->
                <!-- <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30"
                            class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">loser</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul> -->
                <!-- </div> -->
            </div>
        </div>
        <div class="col py-3 bg-light">
            <div id="content">
                <!-- Your main content goes here -->
                @yield('content')
            </div>
        </div>
    </div>
</div>