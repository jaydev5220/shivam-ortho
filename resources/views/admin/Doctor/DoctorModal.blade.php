<!-- Add Modal -->
<div class="modal fade" id="Add_doctors_details" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Add Doctor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return false" method="POST" id="DoctorForm" name="DoctorForm"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="hid" name="hid" value="">
                    <input type="hidden" name="old_image" id="old_image">

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Name</label>
                        <div class="col-lg-9">
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Please enter name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Specialization</label>
                        <div class="col-lg-9">
                            <input type="text" id="specialization" name="specialization" class="form-control"
                                placeholder="Please enter specialization">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Image</label>
                        <div class="col-lg-9">
                            <input type="file" id="image" name="image" class="form-control">
                            <div id="image_preview" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Description</label>
                        <div class="col-lg-9">
                            <textarea id="description" name="description" class="form-control" placeholder="Enter description"></textarea>
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
