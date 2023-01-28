{{-- 

/**
*
* Created a new component <x-menu.vertical-menu/>.
* 
*/

--}}

    
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="{{getRouterValue();}}/aluno/my">
                                <img src="{{Vite::asset('resources/images/logo.svg')}}" class="navbar-logo logo-dark" alt="logo">
                                <img src="{{Vite::asset('resources/images/logo2.svg')}}" class="navbar-logo logo-light" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{getRouterValue();}}/aluno/my" class="nav-link"> Admin </a>
                        </div>
                        
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">

                    <li class="menu {{ Request::is('*/aluno/*') ? "active" : "" }}">
                        <a href="#aluno" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/aluno/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>aluno</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/aluno/*') ? "show" : "" }}" id="aluno" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('aluno.my') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/aluno/my"> Início </a>
                             </li>{{--
                            <li class="{{ Request::routeIs('aluno.pagamento') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/aluno/pagamento"> Pagamento </a>
                            </li>
                            <li class="{{ Request::routeIs('config') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/aluno/config"> Configurações </a>
                            </li> --}}
                        </ul>
                    </li>
                    <li class="menu {{ Request::is('*/app/ecommerce/*') ? "active" : "" }}">
                        <a href="#ecommerce" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/app/ecommerce/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                <span>Ecommerce</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/app/ecommerce/*') ? "show" : "" }}" id="ecommerce" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('ecommerce-shop') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/shop"> Shop </a>
                            </li>
                            <li class="{{ Request::routeIs('ecommerce-detail') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/detail"> Product </a>
                            </li>
                            <li class="{{ Request::routeIs('ecommerce-list') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/list"> List </a>
                            </li>
                            <li class="{{ Request::routeIs('ecommerce-add') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/add"> Create </a>
                            </li>                            
                            <li class="{{ Request::routeIs('ecommerce-edit') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/edit"> Edit </a>
                            </li>                            
                        </ul>
                    </li>
                    
                  {{--   
                    <li class="menu {{ Request::is('*/dashboard/*') ? "active" : "" }}">
                        <a href="#dashboard" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/dashboard/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/dashboard/*') ? "show" : "" }}" id="dashboard" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('analytics') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/dashboard/analytics"> Alunos </a>
                            </li>
                            <li class="{{ Request::routeIs('sales') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/dashboard/sales"> Vendas </a>
                            </li>
                            <li class="{{ Request::routeIs('test') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/dashboard/test"> Test </a>
                            </li>
                        </ul>
                    </li>
                    --}}
                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>APPLICATIONS</span></div>
                    </li>
                    
                    


                    <li class="menu {{ Request::is('*/app/user/*') ? "active" : "" }}">
                        <a href="#user" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/app/user/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span>Alunos</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/app/user/*') ? "show" : "" }}" id="user" data-bs-parent="#accordionExample">
                            
                            
                            


                            <li class="{{ Request::routeIs('user-list') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/user/list"> Lista </a>
                            </li>
                            {{-- 
                            <li class="{{ Request::routeIs('user-resp') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/user/resp"> Responsável </a>
                            </li>
                            <li class="{{ Request::routeIs('user-create') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/user/create"> Novo </a>
                            </li> --}}
                            
                            <li class="{{ Request::routeIs('user-lote') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/user/lote"> Cademi </a>
                            </li>         
                            <li class="{{ Request::routeIs('user-get-charge') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/user/charge"> Carregar Lista </a>
                            </li>      
                            <li class="{{ Request::routeIs('user-reset') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/user/reset"> Resetar Senha </a>
                            </li>                   
                        </ul>
                    </li>

                    
                </ul>
                
            </nav>

        </div>