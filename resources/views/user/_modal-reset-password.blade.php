<?php

use App\Http\Controllers\UserController;

/**
 * @var int $id_role
 **/

?>

<div class="modal fade" id="resetPasswordAllModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordAllModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route(UserController::ROUTE_PASSWORD_ALL) }}" method="post">
                @csrf
                <input type="hidden" name="id_role" value="{{ $id_role }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordAllModalLabel">Reset Password Semua User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="reset_password_all_input">Password Baru</label>
                        <input
                            type="text"
                            class="form-control"
                            id="reset_password_all_input"
                            name="password"
                        >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button
                        type="submit"
                        class="btn btn-danger"
                        onclick="return confirm('Yakin reset password semua user pada role ini?')"
                    >
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>