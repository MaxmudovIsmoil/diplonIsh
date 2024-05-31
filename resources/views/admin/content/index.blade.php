@extends('layout.app')


@section('content')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body position-relative">
            <div class="form-modal-ex add-bnt d-flex">
                <!-- add btn click show modal -->
                <a href="{{ route('admin.plan.index', $planId) }}" class="btn btn-outline-secondary mr-2">
                    <i class="fas fa-arrow-left"></i>&nbsp; Orqaga
                </a>
                <a href="javascript:void(0);" data-store_url="{{ route('admin.content.store') }}"
                   class="btn btn-outline-primary js_add_btn">
                    <i data-feather="plus"></i>&nbsp; Qo'shish
                </a>
                <h3 class="text-center ml-5" style="margin-top: 5px;">Reja: {{ \App\Models\Plan::findOrFail($planId)->title }}</h3>
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
                                        <th>Video</th>
                                        <th>Text</th>
                                        <th>Photo</th>
                                        <th class="text-right">Harakat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contents as $content)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if(!empty($content['url']))
                                                        <div class="video-player">
                                                            <iframe src="{{ $content['url'] }}" allowfullscreen allow="autoplay"></iframe>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{!! $content['text'] !!}</td>
                                                <td>
                                                    <img src="{{ asset('storage/upload/photo/'.$content['photo']) }}" alt="Photo" style="width: 40px;">
                                                </td>
                                                <td>
                                                    <div class="text-right">
                                                        <a href="javascript:void(0);" class="text-primary js_edit_btn mr-3"
                                                           data-update_url="{{ route('admin.content.update', $content['id']) }}"
                                                           data-one_data_url="{{ route('admin.content.getOne', $content['id'])}}"
                                                           title="Tahrirlash">
                                                            <i class="fas fa-pen mr-50"></i>
                                                        </a>
                                                        <a class="text-danger js_delete_btn" href="javascript:void(0);"
                                                           data-toggle="modal"
                                                           data-target="#deleteModal"
                                                           data-name="{{$content['text']}}"
                                                           data-url="{{ route('admin.content.destroy', $content['id']) }}" title="O\'chitish">
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
            @include('admin.content.add_edit_modal')
        </div>
    </div>
@endsection

@section('script')
    <script>
        function form_clear(form) {
            form.find('.js_url').val('');
            form.find('.js_photo').val('');
            form.find('.js_video').val('');
            form.find('.js_text').val('');
        }

        $(document).ready(function () {
            var modal = $(document).find('#add_edit_modal');
            var deleteModal = $('#deleteModal')
            var form = modal.find('.js_add_edit_form');

            $('#datatable').DataTable({
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
                modal.find('.modal-title').html("Qo'shish");
                form_clear(form);
                let url = $(this).data('store_url');
                form.attr('action', url);
                form.find('input[name="_method"]').remove();
                modal.modal('show');
            });

            $(document).on('click', '.js_edit_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html('Taxrirlash');
                let url = $(this).data('one_data_url');
                let update_url = $(this).data('update_url');
                form.attr('action', update_url)
                form_clear(form);
                console.log('123')
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: (response) => {
                        console.log('error: ',response);
                        form.prepend("<input type='hidden' name='_method' value='PUT'>");
                        if (response.success) {
                            form.find('.js_text').val(response.data.text);
                            form.find('.js_url').val(response.data.url);
                            modal.modal('show');
                        }

                    },
                    error: (response) => {
                        console.log('error: ',response);
                    }
                });
            })

            $(document).on('submit', '.js_add_edit_form', function (e) {
                e.preventDefault();
                let instance = form.find('.js_instance');
                let text = form.find('.js_text');
                let photo = form.find('.js_photo');
                let video = form.find('.js_video');
                let url = form.find('.js_url');

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: new FormData(this),
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        console.log(response)
                        if (response.success) {
                            modal.modal('hide')
                            form_clear(form)
                            window.location.reload();
                        }
                    },
                    error: (response) => {
                        console.log('error: ', response);
                        // if (typeof response.responseJSON.errors !== 'undefined') {
                        //     if (response.responseJSON.errors.text) {
                        //         text.addClass('is-invalid');
                        //         text.siblings('.invalid-feedback').html(response.responseJSON.errors.text[0]);
                        //     }
                        //     if (response.responseJSON.errors.video) {
                        //         video.addClass('is-invalid');
                        //         video.siblings('.invalid-feedback').html(response.responseJSON.errors.video[0]);
                        //     }
                        //     if (response.responseJSON.errors.photo) {
                        //         photo.addClass('is-invalid');
                        //         photo.siblings('.invalid-feedback').html(response.responseJSON.errors.photo[0]);
                        //     }
                        //     if (response.responseJSON.errors.url) {
                        //         url.addClass('is-invalid');
                        //         url.siblings('.invalid-feedback').html(response.responseJSON.errors.url[0]);
                        //     }
                        // }

                    }
                });
            });


            $(document).on("click", ".js_delete_btn", function () {
                let name = $(this).data('name')
                let url = $(this).data('url')

                deleteModal.find('.modal-title').html(name);

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
                            deleteModal.find('.js_message').addClass('d-none')
                            deleteModal.find('.js_danger').html(response.error)
                        }
                        console.log('res', response)
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
