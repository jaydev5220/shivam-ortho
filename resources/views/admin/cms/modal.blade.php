<div class="modal fade" id="Add_cms_details" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CMS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="return false" method="POST" id="cmsForm" name="cmsForm"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="hid" name="hid" value="">
                    <div class="row mb-3">
                        <label class="col-sm-2 mt-2 mb-2 col-form-label" for="basic-default-name">Title</label>
                        <div class="col-sm-10 mt-2 mb-2">
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Title..." />
                        </div>

                        <label class="col-sm-2 mt-2 mb-2 col-form-label" for="basic-default-name">Slug</label>
                        <div class="col-sm-10 mt-2 mb-2">
                            <input type="text" class="form-control" id="url" name="url"
                                placeholder="Slug..." readonly />
                        </div>

                        <label class="col-sm-2 mt-2 mb-2 col-form-label" for="basic-default-name">Description</label>
                        <div class="col-sm-10 mt-2 mb-2" id="btnContainer">
                            <textarea name="description" id="description" rows="4" ckeditor="true" placeholder="Description...">
                            </textarea>
                        </div>

                        <label class="col-sm-2 mt-2 mb-2 col-form-label" for="basic-default-name">Meta title</label>
                        <div class="col-sm-10 mt-2 mb-2">
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                placeholder="Meta Title..." />
                        </div>

                        <label class="col-sm-2 mt-2 mb-2 col-form-label" for="basic-default-name">Meta Keyword</label>
                        <div class="col-sm-10 mt-2 mb-2">
                            <input type="text" class="form-control" id="meta_keyword" name="meta_keyword"
                                placeholder="Meta Keyword..." />
                        </div>

                        <label class="col-sm-2 mt-2 mb-2 col-form-label" for="meta_description" class="form-label">Meta
                            Description</label>
                        <div class="col-sm-10 mt-2 mb-2">
                            <textarea class="form-control" name="meta_description" id="meta_description" rows="3"></textarea>
                        </div>

                        <label class="col-sm-2 mt-2 col-form-label" for="basic-default-name">Status</label>
                        <div class="form-group row col-sm-10 mt-2">
                            <div class="col-lg-9">
                                <select class="select" id="status" name="status">
                                    <option selected value="" disabled>Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-sm-2 mb-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
