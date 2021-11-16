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
                                            <th>آی پی</th>
                                            <th>سیستم عامل</th>
                                            <th>مرورگر</th>
                                            <th>تاریخ</th>
                                            <th>عملیات</th>
                                        </tr>
                                    @endslot
                                    @slot('tbody')
                                        @forelse ($error_logs as $error_log)
                                            <tr>
                                                <td>
                                                    {{$error_log->getKey()}}
                                                </td>
                                                <td>
                                                    @if($error_log->user_id != 0)
                                                        <a href="{{ route('users.edit', $error_log->user->id) }}" target="_blank">{{ $error_log->user->id }}</a>
                                                    @else
                                                        نامشخص
                                                    @endif
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
                                                       class="btn btn-sm btn-danger m-1 destroy_product">
                                                        حذف
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">موردی برای نمایش وجود ندارد.</td>
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
        </script>
    @endslot

@endcomponent