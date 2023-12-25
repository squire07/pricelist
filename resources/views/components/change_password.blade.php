@if(Hash::check('12345678',Auth::user()->password))
<div class="modal fade" id="modal_change_password">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" action="{{ route('update-password') }}" method="POST" id="update_password" autocomplete="off">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_password" class="col-form-label">New Password</label>
                        <input type="password" class="form-control form-control-sm" name="new_password" id="new_password" placeholder="must be at least 6 characters" minlength="6" maxlength="16">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="col-form-label">Confirm Password</label>
                        <input type="password" class="form-control form-control-sm" name="confirm_password" id="confirm_password" placeholder="must be at least 6 characters" minlength="6" maxlength="16">
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="error d-none text-sm text-red password-mismatch">New and Confirm Password does not match!</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="btn-update-password" disabled>Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif