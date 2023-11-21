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

        @if(count(array_intersect([1], $navigation_ids)) > 0)
            <li class="nav-item">
                <a href="{{ url('sales-orders') }}" class="nav-link {{ $url_segment_1 == 'sales-orders' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-fw fa-shopping-cart "></i>
                    <p>Sales Order </p>
                </a>
            </li>
        @endif

        {{-- SALES INVOICE MENU: Sub menus are sorted alphabetically --}}
        @if(count(array_intersect([2,3,4,5,6], $navigation_ids)) > 0)
            <li class="nav-item {{ $url_segment_1 == 'sales-invoice' ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ $url_segment_1 == 'sales-invoice' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-fw fa-file-invoice "></i>
                    <p>Sales Invoice<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @if(in_array(2, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/for-invoice') }}" class="nav-link {{ $url_segment_2 == 'for-invoice' ? 'active':'' }}" target="_self">
                                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                                <p>For Invoice</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(3, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/released') }}" class="nav-link {{ $url_segment_2 == 'released' ? 'active':'' }}" target="_self">
                                <i class="fas fa-external-link-alt nav-icon"></i>
                                <p>Released</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(4, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/for-validation') }}" class="nav-link {{ $url_segment_2 == 'for-validation' ? 'active':'' }}" target="_self">
                                <i class="fas fa-clipboard-check nav-icon"></i>
                                <p>For Validation</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(5, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice/cancelled') }}" class="nav-link {{ $url_segment_2 == 'cancelled' ? 'active':'' }}" target="_self">
                                <i class="fas fa-window-close nav-icon"></i>
                                <p>Cancelled</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(6, $navigation_ids))
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
        @if(count(array_intersect([7,8,9,10,11,12,13,14,15,16,21], $navigation_ids)) > 0)
            <li class="nav-item {{ in_array($url_segment_1, $support_modules) ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ in_array($url_segment_1, $support_modules) ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-project-diagram"></i>
                    <p>Support Modules<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @if(in_array(7, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('branches') }}" class="nav-link {{ $url_segment_1 == 'branches' ? 'active':'' }}" target="_self">
                                <i class="fas fa-sitemap nav-icon"></i>
                                <p>Branches</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(8, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('companies') }}" class="nav-link {{ $url_segment_1 == 'companies' ? 'active':'' }}" target="_self">
                                <i class="far fa-building nav-icon"></i>
                                <p>Companies</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(9, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('distributors') }}" class="nav-link {{ $url_segment_1 == 'distributors' ? 'active':'' }}" target="_self">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p>Distributors</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(10, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('items') }}" class="nav-link {{ $url_segment_1 == 'items' ? 'active':'' }}" target="_self">
                                <i class="fas fa-cubes nav-icon"></i>
                                <p>Items</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(11, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('roles') }}" class="nav-link {{ $url_segment_1 == 'roles' ? 'active':'' }}" target="_self">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(12, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('sales-invoice-assignment') }}" class="nav-link {{ $url_segment_1 == 'sales-invoice-assignment' ? 'active':'' }}" target="_self">
                                <i class="far fa-address-card nav-icon"></i>
                                <p>Sales Invoice Assignment</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(21, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('shipping-fee') }}" class="nav-link {{ $url_segment_1 == 'shipping-fee' ? 'active':'' }}" target="_self">
                                <i class="fas fa-shipping-fast nav-icon"></i>
                                <p>Shipping Fee</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(13, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{  url('transaction-types')  }}" class="nav-link {{ $url_segment_1 == 'transaction-types' || $url_segment_1 == 'income-expense-accounts' ? 'active':'' }}" target="_self">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>Transaction Types</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(14, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('payment-methods') }}" class="nav-link {{ $url_segment_1 == 'payment-methods' ? 'active':'' }}" target="_self">
                                <i class="far fa-credit-card nav-icon"></i>
                                <p>Payment Methods</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(15, $navigation_ids))
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
        @if(count(array_intersect([17,18,19,20], $navigation_ids)) > 0)
            <li class="nav-item {{ $url_segment_1 == 'reports' ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ $url_segment_1 == 'reports' ? 'active':'' }}" target="_self">
                    <i class="nav-icon fas fa-registered"></i>
                    <p>Reports<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @if(in_array(17, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('reports/build-report') }}" class="nav-link {{ $url_segment_2 == 'build-report' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Build Report</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(18, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('reports/logs') }}" class="nav-link {{ $url_segment_2 == 'logs' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Logs</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(19, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('reports/stock-card') }}" class="nav-link {{ $url_segment_2 == 'stock-card' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Stock Card</p>
                            </a>
                        </li>
                    @endif
                    @if(in_array(20, $navigation_ids))
                        <li class="nav-item">
                            <a href="{{ url('reports/transaction-listing') }}" class="nav-link {{ $url_segment_2 == 'transaction-listing' ? 'active':'' }}" target="_self">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Transaction Listing</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- <li class="nav-header">ACCOUNT SETTINGS</li>

        <li class="nav-item">
            <a href="#" class="nav-link" target="_self">
                <i class="nav-icon fas fa-fw fa-user "></i>
                <p>Profile</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" target="_self">
                <i class="nav-icon fas fa-fw fa-lock "></i>
                <p>Change Password</p>
            </a>
        </li> --}}
        
    </ul>
</nav>
    
