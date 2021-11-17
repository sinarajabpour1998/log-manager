@component('panel.layouts.component', ['title' => 'گزارش خطاها'])

    @slot('style')
    @endslot

    @slot('subject')
        <h1><i class="fa fa-users"></i> گزارش خطاها </h1>
        <p>مدیریت لیست گزارش خطاها.</p>
    @endslot

    @slot('breadcrumb')
        <li class="breadcrumb-item">گزارش خطاها</li>
        <li class="breadcrumb-item">
            <a href="{{ route('panel') }}">
                <i class="fa fa-home fa-lg"></i>
            </a>
        </li>
    @endslot

    @slot('content')
        <div class="row">
            <div class="col-md-12">
                @component('components.accordion')
                    @slot('cards')
                        @component('components.collapse-card', ['id' => 'error-log-index', 'show' => 'show', 'title' => 'لیست گزارش خطاها'])
                            @slot('body')
                                @component('components.collapse-search', ['show' => $show_filter])
                                    @slot('form')
                                        <form class="clearfix">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="user_id">کاربر</label>
                                                        <select name="user_id" id="user_id"
                                                                class="form-control select2_search_users">
                                                            @if(request()->has('user_id'))
                                                                <option value="{{ request('creator_id') }}" selected>{{ $user->first_name . ' ' . $user->last_name . ' - ' . decryptString($user->mobile) }}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary float-left">جستجو</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endslot
                                @endcomponent

                                @component('components.table')
                                    @slot('thead')
                                        <tr>
                                            <th>شناسه</th>
                                            <th>شناسه کاربر</th>
                                            <th>کد خطا</th>
                                            <th>لاین</th>
                                            <th>پیام خطا</th>
                                            <th>آی پی</th>
                                            <th>سیستم عامل</th>
                                            <th>مرورگر</th>
                                            <th>تاریخ</th>
                                            <th>عملیات</th>
                                        </tr>
                                    @endslot
                                    @slot('tbody')
                                        @forelse ($error_logs as $error_log)
                                            <tr class="{{ $error_log->seen == 0 ? 'unseen-order-row' : '' }}">
                                                <td>
                                                    {{$error_log->getKey()}}
                                                </td>
                                                <td>
                                                    @if($error_log->user_id != 0 && !is_null($error_log->user))
                                                        <a href="{{ route('users.edit', $error_log->user->id) }}" target="_blank">{{ $error_log->user->id }}</a>
                                                    @else
                                                        نامشخص
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $error_log->error_code }}
                                                </td>
                                                <td>
                                                    {{ $error_log->target_line }}
                                                </td>
                                                <td>
                                                    {{ $error_log->error_message }}
                                                </td>
                                                <td>
                                                    {{ $error_log->ip }}
                                                </td>
                                                <td>
                                                    {{ $error_log->os }}
                                                </td>
                                                <td>
                                                    {{ $error_log->browser }}
                                                </td>
                                                <td>
                                                    {{ digitsToEastern(jdate($error_log->created_at)->format('H:i:s - Y/m/d')) }}
                                                </td>
                                                <td>
                                                    <a href="{{route('log-manager.error.log.show', $error_log)}}"
                                                       class="btn btn-sm btn-primary m-1">
                                                        مشاهده جزئیات
                                                    </a>
                                                    <a href="#" data-id="{{$error_log->id}}"
                                                       class="btn btn-sm btn-danger m-1 destroy_error_log">
                                                        حذف
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">موردی برای نمایش وجود ندارد.</td>
                                            </tr>
                                        @endforelse
                                    @endslot
                                @endcomponent

                                {{ $error_logs->withQueryString()->links() }}
                            @endslot
                        @endcomponent
                    @endslot
                @endcomponent
            </div>
        </div>
    @endslot
    @slot('script')
        <script>
            $('.select2').select2({
                'theme': 'bootstrap'
            });
            $(".select2_search_users").select2({
                theme: "bootstrap",
                minimumInputLength: 3,
                ajax: {
                    url: baseUrl + '/panel/search_log_users/',
                    dataType: 'json'
                }
            });
            $(".destroy_error_log").on('click', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: 'آیا برای حذف اطمینان دارید؟',
                    icon: 'warning',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-danger mx-2',
                        cancelButton: 'btn btn-light mx-2'
                    },
                    buttonsStyling: false,
                    confirmButtonText: 'حذف',
                    cancelButtonText: 'لغو',
                    showClass: {
                        popup: 'animated fadeInDown'
                    },
                    hideClass: {
                        popup: 'animated fadeOutUp'
                    }
                })
                    .then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'در حال اجرای درخواست',
                                icon: 'info',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                onOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            $.ajax({
                                type: "delete",
                                url: baseUrl + '/panel/error-log/delete/' + id,
                                dataType: 'json',
                                success: function (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'عملیات حذف با موفقیت انجام شد.',
                                        confirmButtonText:'تایید',
                                        customClass: {
                                            confirmButton: 'btn btn-success',
                                        },
                                        buttonsStyling: false,
                                        showClass: {
                                            popup: 'animated fadeInDown'
                                        },
                                        hideClass: {
                                            popup: 'animated fadeOutUp'
                                        }
                                    })
                                        .then((response) => {
                                            location.reload();
                                        });
                                }
                            });
                        }
                    });
            });
        </script>
    @endslot

@endcomponent
