<div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addNewUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewUserLabel">Find New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label required">Recipient:</label>
                    <select id="recipient-user" data-placeholder="Select a person..." autocomplete="off">
                        @foreach ($selectedUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label required">Message:</label>
                    <textarea class="form-control" id="message-text"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal"><i
                        class="fa fa-times" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-outline-primary btn-sm sendMsg"><i class='fa fa-send'></i></button>
            </div>
        </div>
    </div>
</div>
