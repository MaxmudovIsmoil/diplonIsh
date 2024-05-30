@extends('layout.app')

@section('content')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <!-- Multilingual -->
            <section id="default-avatar-sizes">
                <div class="row match-height">
                    @isset($userInstances)
                        @foreach($userInstances as $userInstance)
                            <div class="col-xl-12 col-lg-12">
                                <div class="card js_one_div" data-get_instance_url="{{ route('user-plan.getInstances', $userInstance->instance_id) }}">
                                    <div class="card-header d-flex justify-content-between">
                                        <h4 class="card-title">{{ $userInstance->instance->name_uz }}</h4>
                                        <a href=""
                                           data-stage-count="{{ count($userInstance->user_plan) }}"
                                           data-store_url="{{ route('user-plan.store') }}"
                                           data-user-instance-id="{{ $userInstance->instance_id }}"
                                           class="btn btn-outline-primary btn-sm js_add_btn"><i class="fas fa-plus"></i></a>
                                    </div>
                                    <div class="card-body">
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th width="2%">№</th>
                                                   <th width="60%">{{__("Admin.Position")}}</th>
                                                   <th>{{__("Admin.Name")}}</th>
                                                   <th width="15%" class="text-right">{{__("Admin.Action")}}</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                                @foreach($userInstance->user_plan as $user_plan)
                                                    <tr data-userPlanId="{{ $user_plan->id }}">
                                                        <td class="js_stage">{{ $user_plan->stage }}</td>
                                                        <td>{{ $user_plan->instance->name_uz }}</td>
                                                        <td>
                                                            @foreach($user_plan->another_instance as $user)
                                                                {{ $user->name }},&nbsp;
                                                            @endforeach
                                                        </td>
                                                        <td class="text-right">
                                                            <a data-update_url="{{ route('user-plan.update', $user_plan->id) }}"
                                                               data-one_data_url="{{ route('user-plan.getOne', $user_plan->instance_id) }}"
                                                               class="text-primary js_edit_btn"><i class="fas fa-pen"></i></a>

                                                            <a href="javascript:void(0);"
                                                                data-url="{{ route('user-plan.destroy', $user_plan->id) }}"
                                                               class="text-danger ml-1 js_delete_btn"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                           </tbody>
                                       </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                    <!-- Avatar Sizes Ends -->
                </div>
            </section>
            <!--/ Multilingual -->
            @include('user-plan.add_edit_modal')
        </div>
    </div>
@endsection

@section('script')
    <script>
        function form_clear(form) {
            let status = form.find('.js_instance option');
            $.each(status, function(i, item) {
                $(item).removeAttr('selected');
            });
        }
        function selectDraw(url, form, instance_id = null) {
            let select = form.find('.js_instance');
            let options = '';
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: (response) => {
                    if(response.success) {
                        response.data.forEach((item) => {
                            if ((typeof instance_id !== 'undefined') && (instance_id === item.id)) {
                                options += '<option value="' + item.id + '" selected>' + item.name_uz + '</option>';
                            }
                            else {
                                options += '<option value="' + item.id + '">' + item.name_uz + '</option>';
                            }
                        })
                        select.html(options)
                    }
                },
                error: (response) => {
                    console.log('error:', response)
                }
            });
        }

        $(document).ready(function() {
            var modal = $(document).find('#add_edit_modal');
            var form = modal.find('.js_add_edit_form');


            $(document).on('click', '.js_add_btn', function(e) {
                e.preventDefault();
                modal.find('.modal-title').html('{{ __('admin.Add Instance') }}')
                form_clear(form);
                let url = $(this).data('store_url');
                let userInstanceId = $(this).data('userInstanceId');
                let stageCount = $(this).data('stageCount');
                form.find('.js_user_instance_id').val(userInstanceId);
                form.find('.js_stage').val(stageCount);
                let get_instance_url = $(this).closest('.js_one_div').data('get_instance_url');
                selectDraw(get_instance_url, form)
                form.find('input[name="_method"]').remove();

                form.attr('action', url);
                modal.modal('show');
            });

            $(document).on('click', '.js_edit_btn', function(e) {
                e.preventDefault();
                modal.find('.modal-title').html('{{ __("admin.Edit Instance") }}')
                let get_instance_url = $(this).closest('.js_one_div').data('get_instance_url');

                let url = $(this).data('one_data_url')
                let update_url = $(this).data('update_url')
                form.attr('action', update_url)
                form_clear(form);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: (response) => {
                        form.append("<input type='hidden' name='_method' value='PUT'>");
                        if(response.success) {
                            selectDraw(get_instance_url, form, response.data.id);
                            modal.modal('show')
                        }
                    },
                    error: (response) => {
                        console.log('error: ',response)
                    }
                });
            })

            $(document).on('submit', '.js_add_edit_form', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: (response) => {
                        console.log(response)
                        if(response.success) {
                            modal.modal('hide')
                            form_clear(form)
                            window.location.reload()
                        }
                    },
                    error: (response) => {
                        console.log('error: ', response)
                    }
                });
            });

            $(document).on('submit', '#js_modal_delete_form', function (e) {
                e.preventDefault()
                let form = $(this);
                let delete_modal = $(this).closest('#deleteModal');
                $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: (response) => {
                        if(!response.success) {
                            delete_modal.find('.js_message').addClass('d-none')
                            delete_modal.find('.js_danger').html(response.error)
                        }
                        console.log('res', response)
                        if(response.success) {
                            window.location.reload();
                            delete_modal.modal('hide')
                        }
                    },
                    error: (response) => {
                        console.log('error:', response);
                    }
                });
            });
        });
    </script>
@endsection
