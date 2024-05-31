<!-- Modal -->
<div class="modal fade text-left static" id="add_edit_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Qo'shish</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" class="js_add_edit_form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $planId }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Video manzil (havola): </label>
                            <div class="form-group">
                                <input type="text" name="url" class="form-control js_url" />
                                <div class="invalid-feedback">Name fail!</div>
                            </div>
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <label>Video: </label>--}}
{{--                            <div class="custom-file">--}}
{{--                                <input type="file" id="video" name="video" class="custom-file-input js_video" />--}}
{{--                                <label for="video" class="custom-file-label">Video</label>--}}
{{--                                <div class="invalid-feedback">Video fail!</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-6">
                            <label>Rasm: </label>
                            <div class="custom-file">
                                <input type="file" id="photo" name="photo" class="custom-file-input js_photo" />
                                <label for="photo" class="custom-file-label">Photo</label>
                                <div class="invalid-feedback">Photo fail!</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="text">Text: </label>
                            <div class="form-group">
                                <textarea class="form-control js_text" name="text" id="text" rows="4"></textarea>
                                <div class="invalid-feedback">Text fail!</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                </div>
            </form>
        </div>
    </div>
</div>

