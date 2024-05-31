@extends('layout.app')

@section('content')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body position-relative">
            <div class="form-modal-ex add-bnt d-flex">
                <!-- add btn click show modal -->
                <a href="{{ route('admin.course.index') }}" class="btn btn-outline-secondary mr-2">
                    <i class="fas fa-arrow-left"></i>&nbsp; Orqaga
                </a>
                <a href="javascript:void(0);" data-store_url="{{ route('admin.plan.store') }}"
                   class="btn btn-outline-primary js_add_btn">
                    <i data-feather="plus"></i>&nbsp; Reja qo'shish
                </a>
                <h3 class="text-center ml-5" style="margin-top: 5px;">Kurs: {{ \App\Models\Course::findOrFail($courseId)->name }}</h3>
            </div>
            <!-- Multilingual -->
            <section id="multilingual-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-datatable">
                                <table class="table" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Kurs</th>
                                            <th>Reja nomi</th>
                                            <th>Content</th>
                                            <th>Status</th>
                                            <th class="text-right">Harakat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($plans as $plan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $plan['title'] }}</td>
                                                <td>{{ $plan['text'] }}</td>
                                                <td>
                                                    <a href="{{ route('admin.content.index', $plan['id']) }}" class="btn btn-outline-primary">Content</a>
                                                </td>
                                                <td>@if($plan['status'] == 1) Faol @else No faol @endif</td>
                                                <td>
                                                    <div class="text-right">
                                                        <a href="javascript:void(0);" class="text-primary js_edit_btn mr-3"
                                                           data-update_url="{{ route('admin.plan.update', $plan['id']) }}"
                                                           data-one_data_url="{{ route('admin.plan.getOne', $plan['id'])}}"
                                                           title="Tahrirlash">
                                                            <i class="fas fa-pen mr-50"></i>
                                                        </a>
                                                        <a class="text-danger js_delete_btn" href="javascript:void(0);"
                                                           data-toggle="modal"
                                                           data-target="#deleteModal"
                                                           data-name="{{$plan['title']}}"
                                                           data-url="{{ route('admin.plan.destroy', $plan['id']) }}" title="O\'chitish">
                                                            <i class="far fa-trash-alt mr-50"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Multilingual -->
            @include('admin.plan.add_edit_modal')
        </div>
    </div>
@endsection

@section('script')
    <script>
        function form_clear(form) {
            form.find('.js_name').val('')

            let status = form.find('.js_status option');
            $.each(status, function (i, item) {
                $(item).removeAttr('selected');
            });
            let courseId = form.find('.js_course_id option');
            $.each(courseId, function (i, item) {
                $(item).removeAttr('selected');
            });
        }

        $(document).ready(function () {
            var modal = $(document).find('#add_edit_modal');
            var deleteModal = $('#deleteModal')
            var form = modal.find('.js_add_edit_form');

            var table = $('#datatable').DataTable({
                paging: true,
                pageLength: 20,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                language: {
                    search: "",
                    searchPlaceholder: " Izlash...",
                    sLengthMenu: "Кўриш _MENU_ тадан",
                    sInfo: "_TOTAL_ ta yozuvdan _START_ dan _END_ gacha koʻrsatilmoqda",
                    emptyTable: "Ma'lumot mavjud emas",
                    sInfoFiltered: "(_MAX_ ta yozuvdan filtrlangan)",
                    sZeroRecords: "Hech qanday ma'lumot topilmadi",
                    oPaginate: {
                        sNext: "Keyingi",
                        sPrevious: "Oldingi",
                    },
                },
                processing: false,
                serverSide: false,
            });

            $(document).on('click', '.js_add_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html("Reja qo'shish");
                form_clear(form);
                let url = $(this).data('store_url');
                form.attr('action', url);
                form.find('input[name="_method"]').remove();
                modal.modal('show');
            });

            $(document).on('click', '.js_edit_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html('Reja taxrirlash')
                let status = form.find('.js_status option')
                let url = $(this).data('one_data_url')
                let update_url = $(this).data('update_url')
                form.attr('action', update_url)
                form_clear(form);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: (response) => {
                        form.prepend("<input type='hidden' name='_method' value='PUT'>");
                        if (response.success) {

                            form.find('.js_title').val(response.data.title)
                            form.find('.js_text').val(response.data.text)
                            $.each(status, function (i, item) {
                                if (response.data.status === $(item).val()) {
                                    $(item).attr('selected', true);
                                }
                            })
                            modal.modal('show')
                        }
                    },
                    error: (response) => {
                        // console.log('error: ',response)
                    }
                });
            })

            $(document).on('submit', '.js_add_edit_form', function (e) {
                e.preventDefault();
                let name = form.find('.js_title');
                let text = form.find('.js_text');

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: new FormData(this),
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        // console.log(response)
                        if (response.success) {
                            modal.modal('hide')
                            form_clear(form)
                            window.location.reload();
                        }
                    },
                    error: (response) => {

                        if (typeof response.responseJSON.errors !== 'undefined') {
                            if (response.responseJSON.errors.title) {
                                title.addClass('is-invalid');
                                title.siblings('.invalid-feedback').html(response.responseJSON.errors.title[0]);
                            }
                            if (response.responseJSON.errors.text) {
                                text.addClass('is-invalid');
                                text.siblings('.invalid-feedback').html(response.responseJSON.errors.text[0]);
                            }
                        }
                        console.log('error: ', response);
                    }
                });
            });


            $(document).on("click", ".js_delete_btn", function () {
                let name = $(this).data('name')
                let url = $(this).data('url')

                deleteModal.find('.modal-title').html(name)

                let form = deleteModal.find('#js_modal_delete_form')
                form.attr('action', url)
                deleteModal.modal('show');
            });

            $(document).on('submit', '#js_modal_delete_form', function (e) {
                e.preventDefault()
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: (response) => {
                        if(!response.success) {
                            console.log('res', response);
                        }
                        if(response.success) {
                            window.location.reload();
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
