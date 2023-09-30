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
                        'payment-types',
                        'users'
                    ];
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
            <a href="{{ url('sales-orders') }}" class="nav-link {{ $url_segment_1 == 'sales-orders' ? 'active':'' }}" target="_self">
                <i class="nav-icon fas fa-fw fa-shopping-cart "></i>
                <p>Sales Order </p>
            </a>
        </li>

        {{-- SALES INVOICE MENU: Sub menus are sorted alphabetically --}}
        <li class="nav-item {{ $url_segment_1 == 'sales-invoice' ? 'menu-open':'' }}">
            <a href="#" class="nav-link {{ $url_segment_1 == 'sales-invoice' ? 'active':'' }}" target="_self">
                <i class="nav-icon fas fa-fw fa-file-invoice "></i>
                <p>Sales Invoice<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('sales-invoice/for-invoice') }}" class="nav-link {{ $url_segment_2 == 'for-invoice' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>For Invoice</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('sales-invoice/released') }}" class="nav-link {{ $url_segment_2 == 'released' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Released</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('sales-invoice/for-validation') }}" class="nav-link {{ $url_segment_2 == 'for-validation' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>For Validation</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('sales-invoice/cancelled') }}" class="nav-link {{ $url_segment_2 == 'cancelled' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cancelled</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('sales-invoice/all') }}" class="nav-link {{ $url_segment_2 == 'all' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All</p>
                    </a>
                </li>
            </ul>
        </li>

        

        {{-- SUPPORT MODULES MENU: Sub menus are sorted alphabetically --}}
        <li class="nav-item {{ in_array($url_segment_1, $support_modules) ? 'menu-open':'' }}">
            <a href="#" class="nav-link {{ in_array($url_segment_1, $support_modules) ? 'active':'' }}" target="_self">
                <i class="nav-icon fas fa-fw fa-share"></i>
                <p>Support Modules<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('branches') }}" class="nav-link {{ $url_segment_1 == 'branches' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Branches</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('companies') }}" class="nav-link {{ $url_segment_1 == 'companies' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Companies</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('distributors') }}" class="nav-link {{ $url_segment_1 == 'distributors' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Distributors</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('items') }}" class="nav-link {{ $url_segment_1 == 'items' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Items</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('roles') }}" class="nav-link {{ $url_segment_1 == 'roles' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Roles</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('sales-invoice-assignment') }}" class="nav-link {{ $url_segment_1 == 'sales-invoice-assignment' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sales Invoice Assignment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('shipping-fee') }}" class="nav-link {{ $url_segment_1 == 'shipping-fee' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Shipping Fee</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{  url('transaction-types')  }}" class="nav-link {{ $url_segment_1 == 'transaction-types' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transaction Types</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('payment-types') }}" class="nav-link {{ $url_segment_1 == 'payment-types' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Payment Types</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('users') }}" class="nav-link {{ $url_segment_1 == 'users' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Users</p>
                    </a>
                </li>
            </ul>
        </li>


        {{-- REPORTS MENU: Sub menus are sorted alphabetically --}}
        <li class="nav-item {{ $url_segment_1 == 'reports' ? 'menu-open':'' }}">
            <a href="#" class="nav-link {{ $url_segment_1 == 'reports' ? 'active':'' }}" target="_self">
                <i class="nav-icon fas fa-fw fa-share"></i>

                <i class=" "></i>
                <p>Reports<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('reports/build-report') }}" class="nav-link {{ $url_segment_2 == 'build-report' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Build Report</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('reports/logs') }}" class="nav-link {{ $url_segment_2 == 'logs' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Logs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('reports/stock-card') }}" class="nav-link {{ $url_segment_2 == 'stock-card' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Stock Card</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('reports/transaction-listing') }}" class="nav-link {{ $url_segment_2 == 'transaction-listing' ? 'active':'' }}" target="_self">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transaction Listing</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-header">ACCOUNT SETTINGS</li>

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
        </li>
        
    </ul>
</nav>
    
