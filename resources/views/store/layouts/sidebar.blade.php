<?php 
$user = auth()->guard('store')->user();
$currentRoute = Route::currentRouteName();
?>

<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('store.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('store.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user" src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">{{ auth()->guard('store')->user()->name ?? '' }}</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <h6 class="dropdown-header">Welcome {{ auth()->guard('store')->user()->name ?? '' }}!</h6>
            <a class="dropdown-item" href="{{ route('store.logout') }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
        </div>
    </div>
    
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $currentRoute == 'store.dashboard' ? 'active' : '' }}" href="{{ route('store.dashboard') }}">
                       <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill-rule="evenodd" d="M14.652 3.873a2 2 0 0 1 2.697 0l10.013 9.1A2.04 2.04 0 0 1 28 14.42V26a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V14.421a2.04 2.04 0 0 1 .638-1.448zM6.003 14.44 16 5.333l9.997 9.106L26 26H6z" clip-rule="evenodd"></path></svg> 
                       <span data-key="t-dashboards">Home</span>
                    </a>                            
                </li> 
                
                <!-- Calendar -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $currentRoute == 'store.page.calender' ? 'active' : '' }}" href="{{ route('store.page.calender') }}">
                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill-rule="evenodd" d="M10 2a1 1 0 0 1 1 1v1h10V3a1 1 0 1 1 2 0v1h3a2 2 0 0 1 2 2v20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h3V3a1 1 0 0 1 1-1M9 6H6v4h20V6h-3v1a1 1 0 1 1-2 0V6H11v1a1 1 0 1 1-2 0zm17 6H6v14h20z" clip-rule="evenodd"></path></svg> 
                        <span data-key="t-services">Calender</span>
                    </a>                            
                </li> 
                
                <!-- Sales Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ str_contains($currentRoute, 'store.page.daily.sales') || str_contains($currentRoute, 'store.appointments.index') || str_contains($currentRoute, 'store.page.sales.list') || str_contains($currentRoute, 'store.page.payment.transactions') || str_contains($currentRoute, 'store.page.gift.cards') || str_contains($currentRoute, 'store.page.paid.plans') ? 'active' : '' }}" 
                       href="#salesbar" 
                       data-bs-toggle="collapse" 
                       role="button" 
                       aria-expanded="{{ str_contains($currentRoute, 'store.page.daily.sales') || str_contains($currentRoute, 'store.appointments.index') || str_contains($currentRoute, 'store.page.sales.list') || str_contains($currentRoute, 'store.page.payment.transactions') || str_contains($currentRoute, 'store.page.gift.cards') || str_contains($currentRoute, 'store.page.paid.plans') ? 'true' : 'false' }}" 
                       aria-controls="salesbar">
                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill-rule="evenodd" d="M15.145 2.256a2 2 0 0 1 1.8.55l13.046 13.046a1.99 1.99 0 0 1 0 2.834L18.686 29.99a1.99 1.99 0 0 1-2.834 0L2.806 16.945a2 2 0 0 1-.55-1.8v-.003L4.27 5.054a1 1 0 0 1 .785-.785l10.088-2.012zm.385 1.963L6.1 6.1 4.22 15.53l13.05 13.05 11.31-11.311z" clip-rule="evenodd"></path><path d="M10.5 12a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"></path></svg> 
                        <span data-key="t-charts">Sales</span>
                    </a>
                    <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.page.daily.sales') || str_contains($currentRoute, 'store.appointments.index') || str_contains($currentRoute, 'store.page.sales.list') || str_contains($currentRoute, 'store.page.payment.transactions') || str_contains($currentRoute, 'store.page.gift.cards') || str_contains($currentRoute, 'store.page.paid.plans') ? 'show' : '' }}" id="salesbar">
                        <ul class="nav nav-sm flex-column">
                            
                             <li class="nav-item">
                                <a href="{{ route('store.appointments.index') }}" class="nav-link {{ $currentRoute == 'store.appointments.index' ? 'active' : '' }}" data-key="daily-sales"> Appointment </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{ route('store.page.daily.sales') }}" class="nav-link {{ $currentRoute == 'store.page.daily.sales' ? 'active' : '' }}" data-key="daily-sales"> Daily Sales Summary </a>
                            </li>
<!--                            <li class="nav-item">
                                <a href="{{ route('store.page.appointments.list') }}" class="nav-link {{ $currentRoute == 'store.page.appointments.list' ? 'active' : '' }}" data-key="appointment"> Appointment </a>
                            </li>-->
                            <li class="nav-item">
                                <a href="{{ route('store.page.sales.list') }}" class="nav-link {{ $currentRoute == 'store.page.sales.list' ? 'active' : '' }}" data-key="sales"> Sales </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('store.page.payment.transactions') }}" class="nav-link {{ $currentRoute == 'store.page.payment.transactions' ? 'active' : '' }}" data-key="payments"> Payments </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('store.page.gift.cards') }}" class="nav-link {{ $currentRoute == 'store.page.gift.cards' ? 'active' : '' }}" data-key="gift-card"> Gift card sold </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('store.page.paid.plans') }}" class="nav-link {{ $currentRoute == 'store.page.paid.plans' ? 'active' : '' }}" data-key="memberships-sold"> Memberships sold </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Client Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ str_contains($currentRoute, 'store.clients.') || str_contains($currentRoute, 'store.page.client.loyalty') ? 'active' : '' }}" 
                       href="#clientbar" 
                       data-bs-toggle="collapse" 
                       role="button" 
                       aria-expanded="{{ str_contains($currentRoute, 'store.clients.') || str_contains($currentRoute, 'store.page.client.loyalty') ? 'true' : 'false' }}" 
                       aria-controls="clientbar">
                       <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M11.5 15a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M20.5 15a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"></path><path fill-rule="evenodd" d="M16 5C9.925 5 5 9.925 5 16s4.925 11 11 11 11-4.925 11-11S22.075 5 16 5M3 16C3 8.82 8.82 3 16 3s13 5.82 13 13-5.82 13-13 13S3 23.18 3 16m7.298 2.135a1 1 0 0 1 1.367.363 5.01 5.01 0 0 0 8.67 0 1 1 0 0 1 1.73 1.004 7.013 7.013 0 0 1-12.13 0 1 1 0 0 1 .363-1.367" clip-rule="evenodd"></path></svg> 
                       <span data-key="t-charts">Client</span>
                    </a>
                    <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.clients.') || str_contains($currentRoute, 'store.page.client.loyalty') ? 'show' : '' }}" id="clientbar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('store.clients.index') }}" class="nav-link {{ str_contains($currentRoute, 'store.clients.')  ? 'active' : '' }}" data-key="Clients-List"> Clients List </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('store.page.client.loyalty') }}" class="nav-link {{ $currentRoute == 'store.page.client.loyalty' ? 'active' : '' }}" data-key="Client-Loyalty"> Client Loyalty </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Catalog Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ str_contains($currentRoute, 'store.products.') ||  str_contains($currentRoute, 'store.suppliers.') || str_contains($currentRoute, 'store.memberships.') || str_contains($currentRoute, 'store.services.') || str_contains($currentRoute, 'store.page.catalogue.') ? 'active' : '' }}" 
                       href="#CatalogbarCharts" 
                       data-bs-toggle="collapse" 
                       role="button" 
                       aria-expanded="{{ str_contains($currentRoute, 'store.products.') || str_contains($currentRoute, 'store.suppliers.') || str_contains($currentRoute, 'store.memberships.') || str_contains($currentRoute, 'store.services.') || str_contains($currentRoute, 'store.page.catalogue.') ? 'true' : 'false' }}" 
                       aria-controls="CatalogbarCharts">
                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill-rule="evenodd" d="M2.586 6.586A2 2 0 0 1 4 6h8a5 5 0 0 1 4 2q.212-.282.465-.536A5 5 0 0 1 20 6h8a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2h-8a3 3 0 0 0-3 3 1 1 0 1 1-2 0 3 3 0 0 0-3-3H4a2 2 0 0 1-2-2V8a2 2 0 0 1 .586-1.414M15 25a5 5 0 0 0-3-1H4V8h8a3 3 0 0 1 3 3zm2 0a5 5 0 0 1 3-1h8V8h-8a3 3 0 0 0-3 3z" clip-rule="evenodd"></path></svg> 
                        <span data-key="t-charts">Catalog</span>
                    </a>
                    <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.products.') || str_contains($currentRoute, 'store.suppliers.') || str_contains($currentRoute, 'store.memberships.') || str_contains($currentRoute, 'store.services.') || str_contains($currentRoute, 'store.page.catalogue.') ? 'show' : '' }}" id="CatalogbarCharts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarCatalog" class="nav-link {{ str_contains($currentRoute, 'store.services.') || str_contains($currentRoute, 'store.page.catalogue.services') || str_contains($currentRoute, 'store.memberships.') || str_contains($currentRoute, 'store.products.') ? 'active' : '' }}" 
                                   data-bs-toggle="collapse" 
                                   role="button" 
                                   aria-expanded="{{ str_contains($currentRoute, 'store.services.') || str_contains($currentRoute, 'store.page.catalogue.services') || str_contains($currentRoute, 'store.memberships.') || str_contains($currentRoute, 'store.products.') ? 'true' : 'false' }}" 
                                   aria-controls="sidebarCatalog">
                                    Catalog
                                </a>
                                <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.services.') || str_contains($currentRoute, 'store.page.catalogue.services') || str_contains($currentRoute, 'store.memberships.') || str_contains($currentRoute, 'store.products.') ? 'show' : '' }}" id="sidebarCatalog">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('store.services.index') }}" class="nav-link {{ str_contains($currentRoute, 'store.services.') ? 'active' : '' }}"> 
                                                Service menu
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('store.memberships.index') }}" class="nav-link {{ $currentRoute == 'store.memberships.' ? 'active' : '' }}"> 
                                                Memberships
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('store.products.index') }}" class="nav-link {{ $currentRoute == 'store.products' ? 'active' : '' }}">
                                                Products 
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                            <li class="nav-item">
                                <a href="#sidebarInventory" class="nav-link {{ str_contains($currentRoute, 'store.page.catalogue.stocktakes') || str_contains($currentRoute, 'store.page.catalogue.orders') || str_contains($currentRoute, 'store.suppliers.') ? 'active' : '' }}" 
                                   data-bs-toggle="collapse" 
                                   role="button" 
                                   aria-expanded="{{ str_contains($currentRoute, 'store.page.catalogue.stocktakes') || str_contains($currentRoute, 'store.page.catalogue.orders') || str_contains($currentRoute, 'store.suppliers.') ? 'true' : 'false' }}" 
                                   aria-controls="sidebarInventory">
                                    Inventory
                                </a>
                                <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.page.catalogue.stocktakes') || str_contains($currentRoute, 'store.page.catalogue.orders') || str_contains($currentRoute, 'store.suppliers.') ? 'show' : '' }}" id="sidebarInventory">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('store.page.catalogue.stocktakes') }}" class="nav-link {{ $currentRoute == 'store.page.catalogue.stocktakes' ? 'active' : '' }}"> 
                                                Stocktakes
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('store.page.catalogue.orders') }}" class="nav-link {{ $currentRoute == 'store.page.catalogue.orders' ? 'active' : '' }}"> 
                                                Stock Orders
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('store.suppliers.index') }}" class="nav-link {{ $currentRoute == 'store.suppliers.' ? 'active' : '' }}">
                                                Suppliers 
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Online Booking Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ str_contains($currentRoute, 'store.page.onlinebooking.') ? 'active' : '' }}" 
                       href="#onlinebooking" 
                       data-bs-toggle="collapse" 
                       role="button" 
                       aria-expanded="{{ str_contains($currentRoute, 'store.page.onlinebooking.') ? 'true' : 'false' }}" 
                       aria-controls="onlinebooking">
                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill-rule="evenodd" d="M2.667 6a2 2 0 0 1 2-2h22.666a2 2 0 0 1 2 2v20a2 2 0 0 1-2 2H4.667a2 2 0 0 1-2-2zm24.666 0H4.667v20h22.666zM16 12a3 3 0 1 0 0 6 3 3 0 0 0 0-6m3.43 6.638a5 5 0 1 0-6.86 0 8 8 0 0 0-.893.423c-1.253.696-2.22 1.719-2.627 2.961a1 1 0 1 0 1.9.622c.214-.65.77-1.32 1.698-1.834.925-.514 2.107-.81 3.352-.81s2.427.296 3.352.81c.928.515 1.485 1.183 1.698 1.834a1 1 0 0 0 1.9-.622c-.406-1.242-1.374-2.265-2.627-2.96a8 8 0 0 0-.893-.424" clip-rule="evenodd"></path></svg> 
                        <span data-key="t-charts">Online booking</span>
                    </a>
                    <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.page.onlinebooking.') ? 'show' : '' }}" id="onlinebooking">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('store.page.onlinebooking.locations') }}" class="nav-link {{ $currentRoute == 'store.page.onlinebooking.locations' ? 'active' : '' }}"> Marketplace profile </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link"> Reserve with Google </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link"> Facebook and Instagram bookings </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('store.page.onlinebooking.buttons.links') }}" class="nav-link {{ $currentRoute == 'store.page.onlinebooking.buttons.links' ? 'active' : '' }}"> Link Builder </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Marketing Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ str_contains($currentRoute, 'store.page.marketing.') ? 'active' : '' }}" 
                       href="#MarketingbarCharts" 
                       data-bs-toggle="collapse" 
                       role="button" 
                       aria-expanded="{{ str_contains($currentRoute, 'store.page.marketing.') ? 'true' : 'false' }}" 
                       aria-controls="MarketingbarCharts">
                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill-rule="evenodd" d="M28.344 3.187a2 2 0 0 0-2.119.272 23.1 23.1 0 0 1-8.763 4.607c-2.412.656-3.753.643-3.71.642l-5.252.01a6 6 0 0 0-.795 11.946l1.475 5.922a2 2 0 0 0 3.05 1.175l1.37-.908a1.99 1.99 0 0 0 .9-1.677V20.79l.052.006a20 20 0 0 1 2.91.572 23.1 23.1 0 0 1 8.763 4.607A2 2 0 0 0 29.5 24.45V4.984a2 2 0 0 0-1.156-1.797M9.78 20.717l1.34 5.38 1.38-.915v-4.465zm-1.28-2h4v-8h-4a4 4 0 1 0 0 8m6-8.062v8.124l.282.03c.784.091 1.89.271 3.206.63a25.1 25.1 0 0 1 9.512 4.995V5a25.1 25.1 0 0 1-9.513 4.996 22 22 0 0 1-3.487.659" clip-rule="evenodd"></path></svg> 
                        <span data-key="t-charts">Marketing</span>
                    </a>
                    <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.page.marketing.') ? 'show' : '' }}" id="MarketingbarCharts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarMessaging" class="nav-link {{ str_contains($currentRoute, 'store.page.marketing.blast.campaigns') || str_contains($currentRoute, 'store.page.marketing.automated.messages') || str_contains($currentRoute, 'store.page.marketing.notifications') ? 'active' : '' }}" 
                                   data-bs-toggle="collapse" 
                                   role="button" 
                                   aria-expanded="{{ str_contains($currentRoute, 'store.page.marketing.blast.campaigns') || str_contains($currentRoute, 'store.page.marketing.automated.messages') || str_contains($currentRoute, 'store.page.marketing.notifications') ? 'true' : 'false' }}" 
                                   aria-controls="sidebarMessaging">
                                    Messaging
                                </a>
                                <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.page.marketing.blast.campaigns') || str_contains($currentRoute, 'store.page.marketing.automated.messages') || str_contains($currentRoute, 'store.page.marketing.notifications') ? 'show' : '' }}" id="sidebarMessaging">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('store.page.marketing.blast.campaigns') }}" class="nav-link {{ $currentRoute == 'store.page.marketing.blast.campaigns' ? 'active' : '' }}"> 
                                                Blast campaigns
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('store.page.marketing.automated.messages') }}" class="nav-link {{ $currentRoute == 'store.page.marketing.automated.messages' ? 'active' : '' }}"> 
                                                Automations
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('store.page.marketing.notifications') }}" class="nav-link {{ $currentRoute == 'store.page.marketing.notifications' ? 'active' : '' }}">
                                                Messages history 
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                            <li class="nav-item">
                                <a href="#sidebarPromotion" class="nav-link {{ str_contains($currentRoute, 'store.page.marketing.deals') || str_contains($currentRoute, 'store.page.marketing.peak.pricing') ? 'active' : '' }}" 
                                   data-bs-toggle="collapse" 
                                   role="button" 
                                   aria-expanded="{{ str_contains($currentRoute, 'store.page.marketing.deals') || str_contains($currentRoute, 'store.page.marketing.peak.pricing') ? 'true' : 'false' }}" 
                                   aria-controls="sidebarPromotion">
                                    Promotion
                                </a>
                                <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.page.marketing.deals') || str_contains($currentRoute, 'store.page.marketing.peak.pricing') ? 'show' : '' }}" id="sidebarPromotion">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('store.page.marketing.deals') }}" class="nav-link {{ $currentRoute == 'store.page.marketing.deals' ? 'active' : '' }}"> 
                                                Deals
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('store.page.marketing.peak.pricing') }}" class="nav-link {{ $currentRoute == 'store.page.marketing.peak.pricing' ? 'active' : '' }}"> 
                                                Smart pricing
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                            <li class="nav-item">
                                <a href="#sidebarEngage" class="nav-link {{ str_contains($currentRoute, 'store.page.marketing.reviews') ? 'active' : '' }}" 
                                   data-bs-toggle="collapse" 
                                   role="button" 
                                   aria-expanded="{{ str_contains($currentRoute, 'store.page.marketing.reviews') ? 'true' : 'false' }}" 
                                   aria-controls="sidebarEngage">
                                    Engage
                                </a>
                                <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.page.marketing.reviews') ? 'show' : '' }}" id="sidebarEngage">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('store.page.marketing.reviews') }}" class="nav-link {{ $currentRoute == 'store.page.marketing.reviews' ? 'active' : '' }}"> 
                                                Reviews
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Team Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ str_contains($currentRoute, 'store.team-members.') || str_contains($currentRoute, 'store.page.team.') || str_contains($currentRoute, 'store.scheduled-shifts.') ? 'active' : '' }}" 
                       href="#teamside" 
                       data-bs-toggle="collapse" 
                       role="button" 
                       aria-expanded="{{ str_contains($currentRoute, 'store.team-members.') || str_contains($currentRoute, 'store.page.team.') || str_contains($currentRoute, 'store.scheduled-shifts.') ? 'true' : 'false' }}" 
                       aria-controls="teamside">
                       <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M30.6 18.8a1 1 0 0 1-1.4-.2A6.45 6.45 0 0 0 24 16a1 1 0 0 1 0-2 3 3 0 1 0-2.905-3.75 1 1 0 0 1-1.937-.5 5 5 0 1 1 8.217 4.939 8.5 8.5 0 0 1 3.429 2.71A1 1 0 0 1 30.6 18.8m-6.735 7.7a1 1 0 1 1-1.73 1 7.125 7.125 0 0 0-12.27 0 1 1 0 1 1-1.73-1 9 9 0 0 1 4.217-3.74 6 6 0 1 1 7.296 0 9 9 0 0 1 4.217 3.74M16 22a4 4 0 1 0 0-8 4 4 0 0 0 0 8m-7-7a1 1 0 0 0-1-1 3 3 0 1 1 2.905-3.75 1 1 0 0 0 1.938-.5 5 5 0 1 0-8.218 4.939 8.5 8.5 0 0 0-3.425 2.71A1 1 0 1 0 2.8 18.6 6.45 6.45 0 0 1 8 16a1 1 0 0 0 1-1"></path></svg> 
                       <span data-key="t-charts">Team</span>
                    </a>
                    <div class="collapse menu-dropdown {{ str_contains($currentRoute, 'store.team-members.') || str_contains($currentRoute, 'store.page.team.') || str_contains($currentRoute, 'store.scheduled-shifts.')  ? 'show' : '' }}" id="teamside">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('store.team-members.index') }}" class="nav-link {{ str_contains($currentRoute, 'store.team-members.') ? 'active' : '' }}"> Team members </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('store.scheduled-shifts.index') }}" class="nav-link {{ $currentRoute == 'store.scheduled-shifts.index' ? 'active' : '' }}"> Scheduled shifts </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('store.page.team.timesheets') }}" class="nav-link {{ $currentRoute == 'store.page.team.timesheets' ? 'active' : '' }}"> Timesheets </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('store.page.team.payrun') }}" class="nav-link {{ $currentRoute == 'store.page.team.payrun' ? 'active' : '' }}"> Pay runs </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Reports -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $currentRoute == 'store.page.report.group' ? 'active' : '' }}" href="{{ route('store.page.report.group') }}">
                       <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill-rule="evenodd" d="M4 5a1 1 0 0 1 1 1v13.586l6.293-6.293a1 1 0 0 1 1.414 0L16 16.586 23.586 9H21a1 1 0 1 1 0-2h5a1 1 0 0 1 1 1v5a1 1 0 1 1-2 0v-2.586l-8.293 8.293a1 1 0 0 1-1.414 0L12 15.414l-7 7V25h23a1 1 0 1 1 0 2H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1" clip-rule="evenodd"></path></svg> 
                       <span data-key="t-dashboards">Reports</span>
                    </a>                            
                </li> 

                <!-- Add-ons -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $currentRoute == 'store.page.setting.addon' ? 'active' : '' }}" href="{{ route('store.page.setting.addon') }}">
                       <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill-rule="evenodd" d="M5 7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2zm8 0H7v6h6zm4 0a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2h-6a2 2 0 0 1-2-2zm8 0h-6v6h6zM5 19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2zm8 0H7v6h6zm9-2a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3h-3a1 1 0 1 1 0-2h3v-3a1 1 0 0 1 1-1" clip-rule="evenodd"></path></svg> 
                       <span data-key="t-dashboards">Add-ons</span>
                    </a>                            
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $currentRoute == 'store.page.setting' ? 'active' : '' }}" href="{{ route('store.page.setting') }}">
                       <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M16 10a6 6 0 1 0 6 6 6.006 6.006 0 0 0-6-6m0 10a4 4 0 1 1 0-8 4 4 0 0 1 0 8m13.743-6.599a1 1 0 0 0-.487-.675l-3.729-2.125-.015-4.202a1 1 0 0 0-.353-.76 14 14 0 0 0-4.59-2.584 1 1 0 0 0-.808.074L16 5.23l-3.765-2.106a1 1 0 0 0-.809-.075 14 14 0 0 0-4.585 2.594 1 1 0 0 0-.354.759l-.018 4.206-3.729 2.125a1 1 0 0 0-.486.675 13.3 13.3 0 0 0 0 5.195 1 1 0 0 0 .486.675l3.729 2.125.015 4.202a1 1 0 0 0 .353.76 14 14 0 0 0 4.59 2.584 1 1 0 0 0 .808-.074L16 26.77l3.765 2.106a1.008 1.008 0 0 0 .809.073 14 14 0 0 0 4.585-2.592 1 1 0 0 0 .354-.759l.018-4.206 3.729-2.125a1 1 0 0 0 .486-.675c.34-1.713.338-3.477-.003-5.19m-1.875 4.364-3.572 2.031a1 1 0 0 0-.375.375c-.072.125-.148.258-.226.383a1 1 0 0 0-.152.526l-.02 4.031c-.96.754-2.029 1.357-3.17 1.788L16.75 24.89a1 1 0 0 0-.489-.125h-.478a1 1 0 0 0-.513.125l-3.605 2.013a12 12 0 0 1-3.18-1.779L8.471 21.1a1 1 0 0 0-.152-.527 7 7 0 0 1-.225-.383 1 1 0 0 0-.375-.383l-3.575-2.036a11.3 11.3 0 0 1 0-3.532l3.565-2.035a1 1 0 0 0 .375-.375c.072-.125.148-.258.226-.383.1-.157.152-.34.152-.526l.02-4.031c.96-.754 2.029-1.357 3.17-1.788L15.25 7.11a1 1 0 0 0 .512.125h.456a1 1 0 0 0 .512-.125l3.605-2.013a12 12 0 0 1 3.18 1.779l.014 4.025c0 .187.053.37.152.527.078.126.154.25.225.383.089.159.218.291.375.383l3.575 2.036a11.3 11.3 0 0 1 .006 3.536z"></path></svg> 
                       <span data-key="t-dashboards">Settings</span>
                    </a>                            
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('store.logout') }}">
                         <i class="mdi mdi-logout  fs-16 align-middle me-1"></i> <span data-key="t-logout">Logout</span>
                    </a>                            
                </li> 
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>