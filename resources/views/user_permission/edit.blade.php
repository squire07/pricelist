@extends('adminlte::page')

@section('title', 'User Permission')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>User Permission</h1>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-bold">
                {{ strtoupper($user->name) }}
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:5%;min-width:100px;max-width:120px;">Module Id</th>
                            <th class="text-center" width="45%">Module Name</th>
                            <th class="text-center" width="25%">Type</th>
                            <th class="text-center" width="25%" style="min-width:250px;">Permission</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th class="text-center">&nbsp;</th>
                            <th class="text-center">&nbsp;</th>
                            <th>
                                <span class="mx-2">Index</span>
                                <span class="mx-2">Create</span>
                                <span class="mx-2">View</span>
                                <span class="mx-2">Update</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modules as $key => $module)
                            <tr>
                                <td class="text-center">{{ $module->id }}</td>
                                <td>{{ $module->name }}</td>
                                <td class="text-center">
                                    {{ $module->type == 'Module' && ($module->id > 6 && $module->id != 23) ? 'Support ' . $module->type : $module->type }}
                                </td>
                                <td>
                                    @foreach(json_decode($user->permission->user_permission, true) as $parent_key => $module_permission)
                                        @if($module->id == $parent_key)
                                            @foreach($module_permission as $child_key => $permission)
                                                @php
                                                    $disable_create = (in_array($module->id, [2, 3, 4, 5, 6]) && $child_key == 2) ? 'disabled' : '';
                                                    $disable_update = (in_array($module->id, [3, 5, 6]) && $child_key == 4) ? 'disabled' : '';
                                                    $is_check = ($permission == 1 && !$disable_create && !$disable_update) ? 'checked' : '';
                                                @endphp

                                                <input type="checkbox" 
                                                    class="checkbox_permission" 
                                                    name="" 
                                                    value="{{ $user->id . '-' . $module->id . '-' . $child_key . '-' . $permission }}" 
                                                    style="margin: 0 20px;" 
                                                    {{ $is_check }} 
                                                    {{ $disable_create }} 
                                                    {{ $disable_update }} >
                                            @endforeach
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
            <div class="card-footer">
                <input type="button" value="Return to User's List" class="btn btn-sm btn-primary" id="btn-return-user">
                {{-- <a href="{{ url('users') }}" class="btn btn-sm btn-primary" id="btn-return-user" >Return to User's List</a> --}}
            </div>
        </div>
    </div>
@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $('.checkbox_permission').on('click', function() {
            // console.log(this.value);

            const data = {
                key: this.value,
            };

            // Create an options object for the Fetch API request
            const options = {
                method: 'POST', 
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            };

            // Send the POST request using Fetch
            fetch(window.location.origin + '/api/permission/', options)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Permission updated!'
                })

            })
            .catch(error => {
                console.log('Error updating permission: ', error);
            });
        });


        // Prevent from redirecting back to homepage when cancel button is clicked accidentally
        $('#btn-return-user').on('click', function() {

            // show the confirmation
            Swal.fire({
                title: 'Return to User List',
                text: "",
                icon: 'warning',
                allowEnterKey: false,
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "/users";
                }
            });
        });

    });
</script>
@endsection
