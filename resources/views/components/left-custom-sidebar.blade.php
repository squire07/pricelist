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
                        'branches',
                        'companies',
                        'distributors',
                        'items',
                        'roles',
                        'sales-invoice-assignment',
                        'shipping-fee',
                        'transaction-types',
                        'payment-methods',
                        'users',
                        'permissions',
                        'income-expense-accounts'
                    ];

    // SESSION: get the session key `navigation_ids` created from LoginController
    $navigation_ids = session('navigation_ids');

@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @if(Helper::MP(1,1))
            <li class="nav-item">
                <a href="{{ url('sales-orders') }}" class="nav-link {{ $url_segment_1 == 'sales-orders' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-fw fa-shopping-cart "></i>
                    <p>Sales Order </p>
                </a>
            </li>
        @endif

        {{-- SALES INVOICE MENU: Sub menus are sorted alphabetically --}}
        @if(Helper::MP(2,1) || Helper::MP(3,1) || Helper::MP(4,1) || Helper::MP(5,1) || Helper::MP(6,1))
            <li class="nav-item {{ $url_segment_1 == 'sales-invoice' ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ $url_segment_1 == 'sales-invoice' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-fw fa-file-invoice "></i>
                    <p>Sales Invoice<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @if(Helper::MP(2,1))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/for-invoice') }}" class="nav-link {{ $url_segment_2 == 'for-invoice' ? 'active':'' }}" target="_self">
                                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                                <p>For Invoice</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(4,1))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/for-validation') }}" class="nav-link {{ $url_segment_2 == 'for-validation' ? 'active':'' }}" target="_self">
                                <i class="fas fa-clipboard-check nav-icon"></i>
                                <p>For Validation</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(23,1))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/for-posting') }}" class="nav-link {{ $url_segment_2 == 'for-posting' ? 'active':'' }}" target="_self">
                                <i class="fas fa-file-upload nav-icon"></i>
                                <p>For Posting</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(3,1))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/released') }}" class="nav-link {{ $url_segment_2 == 'released' ? 'active':'' }}" target="_self">
                                <i class="fas fa-external-link-alt nav-icon"></i>
                                <p>Released</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(5,1))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/cancelled') }}" class="nav-link {{ $url_segment_2 == 'cancelled' ? 'active':'' }}" target="_self">
                                <i class="fas fa-window-close nav-icon"></i>
                                <p>Cancelled</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(6,1))
                        <li class="nav-item" style="border-bottom: 1px solid #4f5962;">
                            <a href="{{ url('sales-invoice/all') }}" class="nav-link {{ $url_segment_2 == 'all' ? 'active':'' }}" target="_self">
                                <i class="far fa-list-alt nav-icon"></i>
                                <p>All</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        

        {{-- SUPPORT MODULES MENU: Sub menus are sorted alphabetically --}}
        @if(Helper::MP(7,1) || Helper::MP(8,1) || Helper::MP(9,1) || Helper::MP(10,1) || Helper::MP(14,1) || Helper::MP(11,1) || Helper::MP(12,1) || Helper::MP(21,1) || Helper::MP(13,1) || Helper::MP(15,1))
            <li class="nav-item {{ in_array($url_segment_1, $support_modules) ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ in_array($url_segment_1, $support_modules) ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-project-diagram"></i>
                    <p>Support Modules<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @if(Helper::MP(7,1))
                        <li class="nav-item">
                            <a href="{{ url('branches') }}" class="nav-link {{ $url_segment_1 == 'branches' ? 'active':'' }}" target="_self">
                                <i class="fas fa-sitemap nav-icon"></i>
                                <p>Branches</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(8,1))
                        <li class="nav-item">
                            <a href="{{ url('companies') }}" class="nav-link {{ $url_segment_1 == 'companies' ? 'active':'' }}" target="_self">
                                <i class="far fa-building nav-icon"></i>
                                <p>Companies</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(9,1))
                        <li class="nav-item">
                            <a href="{{ url('distributors') }}" class="nav-link {{ $url_segment_1 == 'distributors' ? 'active':'' }}" target="_self">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p>Distributors</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(10,1))
                        <li class="nav-item">
                            <a href="{{ url('items') }}" class="nav-link {{ $url_segment_1 == 'items' ? 'active':'' }}" target="_self">
                                <i class="fas fa-cubes nav-icon"></i>
                                <p>Items</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(14,1))
                        <li class="nav-item">
                            <a href="{{ url('payment-methods') }}" class="nav-link {{ $url_segment_1 == 'payment-methods' ? 'active':'' }}" target="_self">
                                <i class="far fa-credit-card nav-icon"></i>
                                <p>Payment Methods</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(11,1))
                        <li class="nav-item">
                            <a href="{{ url('roles') }}" class="nav-link {{ $url_segment_1 == 'roles' ? 'active':'' }}" target="_self">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(12,1))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice-assignment') }}" class="nav-link {{ $url_segment_1 == 'sales-invoice-assignment' ? 'active':'' }}" target="_self">
                                <i class="far fa-address-card nav-icon"></i>
                                <p>Sales Invoice Assignment</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(21,1))
                        <li class="nav-item">
                            <a href="{{ url('shipping-fee') }}" class="nav-link {{ $url_segment_1 == 'shipping-fee' ? 'active':'' }}" target="_self">
                                <i class="fas fa-shipping-fast nav-icon"></i>
                                <p>Shipping Fee</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(13,1))
                        <li class="nav-item">
                            <a href="{{  url('transaction-types')  }}" class="nav-link {{ $url_segment_1 == 'transaction-types' || $url_segment_1 == 'income-expense-accounts' ? 'active':'' }}" target="_self">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>Transaction Types</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(15,1))
                        <li class="nav-item" style="border-bottom: 1px solid #4f5962;">
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
        @if(Helper::MP(17,1) || Helper::MP(18,1) || Helper::MP(19,1) || Helper::MP(20,1))
            <li class="nav-item {{ $url_segment_1 == 'reports' ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ $url_segment_1 == 'reports' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-registered"></i>
                    <p>Reports<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @if(Helper::MP(17,1))
                        <li class="nav-item">
                            <a href="{{ url('reports/build-report') }}" class="nav-link {{ $url_segment_2 == 'build-report' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Build Report</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(18,1))
                        <li class="nav-item">
                            <a href="{{ url('reports/logs') }}" class="nav-link {{ $url_segment_2 == 'logs' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Logs</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(19,1))
                        <li class="nav-item">
                            <a href="{{ url('reports/stock-card') }}" class="nav-link {{ $url_segment_2 == 'stock-card' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Stock Card</p>
                            </a>
                        </li>
                    @endif
                    @if(Helper::MP(20,1))
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
        @if(Auth::user()->role_id == 12)
            <li class="nav-item {{ $url_segment_1 == 'tools' ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ $url_segment_1 == 'tools' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-tools"></i>
                    <p>Tools<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('tools/nuc') }}" class="nav-link {{ $url_segment_2 == 'nuc' ? 'active':'' }}" target="_self">
                            <i class="fas fa-stroopwafel nav-icon"></i>
                            <p>NUC</p>
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
        @endif
        
    </ul>
</nav>
    
