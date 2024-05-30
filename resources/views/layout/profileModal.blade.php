<!-- Modal -->
<div class="modal fade text-left static" id="profile_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("admin.User profile")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route("user.profile") }}" method="post" class="js_profile_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name2">{{__("admin.Name")}}: </label>
                            <div class="form-group">
                                <input type="text" id="name2" name="name" class="form-control js_name" value="{{ auth()->user()->name }}" />
                                <div class="invalid-feedback">name fail!</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone2">{{__("admin.Phone")}}: </label>
                            <div class="form-group">
                                <input type="number" id="phone2" name="phone" class="form-control js_phone" value="{{ auth()->user()->phone }}" placeholder="901004050"/>
                                <div class="invalid-feedback">phone fail!</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>{{__("admin.Photo")}}: </label>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" id="photo2" name="photo" class="custom-file-input js_photo" />
                                    <label for="photo2" class="custom-file-label">{{__("admin.file")}}</label>
                                    <div class="invalid-feedback">Photo fail!</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="username2">{{__("admin.Username")}}: </label>
                            <div class="form-group">
                                <input type="text" name="username" id="username2" readonly class="form-control js_username" value="{{ auth()->user()->username }}" />
                                <div class="invalid-feedback">Username fail!</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="passwd2">{{__("admin.Password")}}: </label>
                            <div class="form-group">
                                <input type="password" id="passwd2" name="password" class="form-control js_password" value=""/>
                                <div class="invalid-feedback">Password fail!</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{__("admin.Save")}}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("admin.Close")}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

