<!-- Add Modal -->
<div class="modal fade" id="Add_Users_details" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return false" method="POST" id="UserForm" name="UserForm"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="hid" name="hid" value="">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">First Name</label>
                        <div class="col-lg-9">
                            <input type="text" id="firstname" name="firstname" class="form-control"
                                placeholder="Please enter firstname">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Last Name</label>
                        <div class="col-lg-9">
                            <input type="text" id="lastname" name="lastname" class="form-control"
                                placeholder="Please enter lastname">
                        </div>
                    </div>
                    <div class="form-group
                        row">
                        <label class="col-lg-3 col-form-label">Phone</label>
                        <div class="col-lg-9">
                            <input type="text" id="phone" name="phone" class="form-control"
                                placeholder="Please enter phone">
                        </div>
                    </div>
                    <div class="form-group
                        row">
                        <label class="col-lg-3 col-form-label">Email</label>
                        <div class="col-lg-9">
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Please enter email">
                        </div>
                    </div>
                    <div class="form-group
                        row  password-container">
                        <label class="col-lg-3 col-form-label">Password</label>
                        <div class="col-lg-9">
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Please enter password">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /ADD Modal -->
