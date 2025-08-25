<!-- Add Modal -->
<div class="modal fade" id="Add_courses_details" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Add Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return false" method="POST" id="CourseForm" name="CourseForm"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="hid" name="hid" value="">
                    <input type="hidden" name="old_thumbnail" id="old_thumbnail">
                    <input type="hidden" name="old_video" id="old_video">

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Title</label>
                        <div class="col-lg-9">
                            <input type="text" id="title" name="title" class="form-control"
                                placeholder="Please enter title">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Short Description</label>
                        <div class="col-lg-9">
                            <textarea id="short_description" name="short_description" class="form-control" placeholder="Enter short description"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Thumbnail</label>
                        <div class="col-lg-9">
                            <input type="file" id="thumbnail" name="thumbnail" class="form-control">
                            <div id="thumbnail_preview" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Description</label>
                        <div class="col-lg-9">
                            {{-- <textarea id="description" name="description" class="form-control" placeholder="Enter course description"></textarea> --}}
                            <textarea name="description" id="description" rows="4" ckeditor="true" placeholder="Description...">
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Video</label>
                        <div class="col-lg-9">
                            <input type="file" id="video" name="video" class="form-control" accept="video/*">
                            <div id="video_preview" class="mt-2"></div>
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
