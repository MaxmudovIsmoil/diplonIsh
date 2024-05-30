<!-- Modal -->
<div class="modal fade text-left static" id="add_edit_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("admin.Instance")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" class="js_add_edit_form">
                @csrf
                <input type="hidden" name="user_instance_id" class="js_user_instance_id" value=""/>
                <input type="hidden" name="stage" class="js_stage" value=""/>
                <div class="modal-body">
                    <label>{{__("admin.Instance")}}: </label>
                    <div class="form-group">
                        <select name="instance_id" class="form-control js_instance"></select>
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

