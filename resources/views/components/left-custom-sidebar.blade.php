{{-- This is the custom left sidebar navigation --}}

@php
    /* Segment is part of every URL every after '/' symbol AFTER the domain name, ex:
    *  www.gl.unomain.net/sales-invoice/for-invoice/361ebfbb-5be5-43b8-bc7b-cb253c1254d5
    *                    |  segment 1  | segment 2 |            segment 3              |
    * Add whenever necessary
    */ 
    $url_segment_1 = Request::segment(1);
    $url_segment_2 = Request::segment(2);
    $url_segment_3 = Request::segment(3);

    // support modules are on segment 1, must be in array to set the css active
    $support_modules = [
                        'branch',
                        'customers',
                        'customer-categories',
                        'employees',
                        'suppliers',
                        'products',
                        'users',
                        'permissions',
                        'brands',
                    ];

    // SESSION: get the session key `navigation_ids` created from LoginController
    $navigation_ids = session('navigation_ids');

@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @if(Helper::MP(1,1))
            <li class="nav-item">
                <a href="{{ url('delivery-management') }}" class="nav-link {{ $url_segment_1 == 'delivery-management' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-shipping-fast "></i>
                    <p>Delivery Management </p>
                </a>
            </li>
        @endif
        {{-- @if(Helper::MP(2,1))
            <li class="nav-item">
                <a href="{{ url('purchase-orders') }}" class="nav-link {{ $url_segment_1 == 'purchase-orders' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-shipping-fast "></i>
                    <p>Purchase Order Management </p>
                </a>
            </li>
        @endif --}}

        {{-- SALES INVOICE MENU: Sub menus are sorted alphabetically --}}
        @if(Helper::MP(2,1) || Helper::MP(3,1) || Helper::MP(15,1) || Helper::MP(16,1) || Helper::MP(17,1))
            <li class="nav-item {{ $url_segment_1 == 'payments' ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ $url_segment_1 == 'payments' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-fw fa-file-invoice "></i>
                    <p>Sales Management<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @if(Helper::MP(3,1))
                        <li class="nav-item">
                            <a href="{{ url('payments/delivery') }}" class="nav-link {{ $url_segment_2 == 'delivery' ? 'active':'' }} pl-4" target="_self">
                                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                                <p>Delivery</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(16,1))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/for-validation') }}" class="nav-link {{ $url_segment_2 == 'for-validation' ? 'active':'' }} pl-4" target="_self">
                                <i class="fas fa-clipboard-check nav-icon"></i>
                                <p>Extract</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(17,1))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/for-posting') }}" class="nav-link {{ $url_segment_2 == 'for-posting' ? 'active':'' }} pl-4" target="_self">
                                <i class="fas fa-file-upload nav-icon"></i>
                                <p>Online Stores</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(18,1))
                        <li class="nav-item" style="border-bottom: 1px solid #4f5962;">
                            <a href="{{ url('sales-invoice/released') }}" class="nav-link {{ $url_segment_2 == 'released' ? 'active':'' }} pl-4" target="_self">
                                <i class="fas fa-external-link-alt nav-icon"></i>
                                <p>Physical Stores</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- @if(Helper::MP(4,1))
            <li class="nav-item">
                <a href="{{ url('inventory-management') }}" class="nav-link {{ $url_segment_1 == 'inventory-management' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-shipping-fast "></i>
                    <p>Inventory Management </p>
                </a>
            </li>
        @endif --}}


        {{-- SUPPORT MODULES MENU: Sub menus are sorted alphabetically --}}
        @if(Helper::MP(5,1) || Helper::MP(6,1) || Helper::MP(7,1) || Helper::MP(8,1) || Helper::MP(9,1) || Helper::MP(10,1) || Helper::MP(11,1) || Helper::MP(12,1) || Helper::MP(13,1) || Helper::MP(14,1))
            <li class="nav-item {{ in_array($url_segment_1, $support_modules) ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ in_array($url_segment_1, $support_modules) ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-project-diagram"></i>
                    <p>Support Modules<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @if(Helper::MP(5,1))
                        <li class="nav-item">
                            <a href="{{ url('branches') }}" class="nav-link {{ $url_segment_1 == 'branches' ? 'active':'' }}" target="_self">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Branch</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(12,1))
                        <li class="nav-item">
                            <a href="{{ url('brands') }}" class="nav-link {{ $url_segment_1 == 'brands' ? 'active':'' }}" target="_self">
                                <i class="fas fa-tags nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(6,1))
                        <li class="nav-item">
                            <a href="{{ url('customers') }}" class="nav-link {{ $url_segment_1 == 'customers' ? 'active':'' }}" target="_self">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(7,1))
                        <li class="nav-item">
                            <a href="{{ url('customer-categories') }}" class="nav-link {{ $url_segment_1 == 'customer-categories' ? 'active':'' }}" target="_self">
                                <i class="far fa-address-card nav-icon"></i>
                                <p>Customer Categories</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(13,1))
                        <li class="nav-item">
                            <a href="{{ url('departments') }}" class="nav-link {{ $url_segment_1 == 'departments' ? 'active':'' }}" target="_self">
                                <i class="far fa-building nav-icon"></i>
                                <p>Departments</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(8,1))
                        <li class="nav-item">
                            <a href="{{ url('employees') }}" class="nav-link {{ $url_segment_1 == 'employees' ? 'active':'' }}" target="_self">
                                <i class="fas fa-users-cog nav-icon"></i>
                                <p>Employee Management</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(9,1))
                        <li class="nav-item">
                            <a href="{{ url('products') }}" class="nav-link {{ $url_segment_1 == 'products' ? 'active':'' }}" target="_self">
                                <i class="nav-icon fas fa-cubes"></i>
                                <p>Products</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(14,1))
                        <li class="nav-item">
                            <a href="{{ url('roles') }}" class="nav-link {{ $url_segment_1 == 'roles' ? 'active':'' }}" target="_self">
                                <i class="fas fa-user-cog nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(10,1))
                        <li class="nav-item">
                            <a href="{{ url('suppliers') }}" class="nav-link {{ $url_segment_1 == 'suppliers' ? 'active':'' }}" target="_self">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(11,1))
                        <li class="nav-item"style="border-bottom: 1px solid #4f5962;">
                            <a href="{{ url('users') }}" class="nav-link {{ in_array($url_segment_1, ['users','permissions']) ? 'active':'' }}" target="_self">
                                <i class="fas fa-user-lock nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif


        {{-- REPORTS MENU: Sub menus are sorted alphabetically --}}
        @if(Helper::MP(15,1) || Helper::MP(16,1) || Helper::MP(17,1) || Helper::MP(18,1) || Helper::MP(24,1))
            <li class="nav-item {{ $url_segment_1 == 'reports' ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ $url_segment_1 == 'reports' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-registered"></i>
                    <p>Reports<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @if(Helper::MP(15,1))
                        <li class="nav-item">
                            <a href="{{ url('reports/dr-report') }}" class="nav-link {{ $url_segment_2 == 'build-report' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>DR Reports</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(16,1))
                        <li class="nav-item">
                            <a href="{{ url('reports/logs') }}" class="nav-link {{ $url_segment_2 == 'logs' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Logs</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(17,1))
                        <li class="nav-item">
                            <a href="{{ url('reports/stock-card') }}" class="nav-link {{ $url_segment_2 == 'stock-card' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Stock Card</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(18,1))
                        <li class="nav-item" style="border-bottom: 1px solid #4f5962;">
                            <a href="{{ url('reports/transaction-listing') }}" class="nav-link {{ $url_segment_2 == 'transaction-listing' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Transaction Listing</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- TOOLs MENU: For System Admin use only --}}
        {{-- @if(Auth::user()->role_id == 12)
            <li class="nav-item {{ $url_segment_1 == 'tools' ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ $url_segment_1 == 'tools' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-tools"></i>
                    <p>Tools<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('tools/maintained-members') }}" class="nav-link {{ $url_segment_2 == 'maintained-members' ? 'active':'' }}" target="_self">
                            <i class="fas fa-people-arrows nav-icon"></i>
                            <p>Maintained Members</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('tools/nuc') }}" class="nav-link {{ $url_segment_2 == 'nuc' ? 'active':'' }}" target="_self">
                            <i class="fas fa-stroopwafel nav-icon"></i>
                            <p>NUC</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('tools/origins') }}" class="nav-link {{ $url_segment_2 == 'origins' ? 'active':'' }}" target="_self">
                            <i class="fas fa-store nav-icon"></i>
                            <p>Origins</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('tools/payload') }}" class="nav-link {{ $url_segment_2 == 'payload' ? 'active':'' }}" target="_self">
                            <i class="fas fa-cloud-upload-alt nav-icon"></i>
                            <p>Payload</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif --}}
        
    </ul>
</nav>
    
