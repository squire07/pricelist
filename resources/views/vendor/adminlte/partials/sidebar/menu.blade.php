@if(Auth::user()->role == 'SUPERADMIN')
 1
 2
 3
 4
 5

@elseif(Auth::user()->role == 'CASHIER')
  7 8 9