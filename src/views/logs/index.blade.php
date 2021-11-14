@component('panel.layouts.component', ['title' => 'گزارش ها'])

    @slot('style')
    @endslot

    @slot('subject')
        <h1><i class="fa fa-users"></i> گزارش ها </h1>
        <p>مدیریت لیست گزارش ها.</p>
    @endslot

    @slot('breadcrumb')
        <li class="breadcrumb-item">گزارش ها</li>
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
                        @component('components.collapse-card', ['id' => 'log-index', 'show' => 'show', 'title' => 'لیست گزارش ها'])
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
                                                            @if(request()->has('creator_id'))
                                                                <option value="{{ request('creator_id') }}" selected>{{ $user->first_name . ' ' . $user->last_name . ' - ' . decryptString($user->mobile) }}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="type">نوع گزارش</label>
                                                        <select name="type" id="type"
                                                                class="form-control select2">
                                                            <option value="">
                                                                انتخاب کنید...
                                                            </option>
                                                            <option value="login" {{ request('type') == 'login' ? 'selected' : '' }}>
                                                                ورود
                                                            </option>
                                                            <option value="registration" {{ request('type') == 'registration' ? 'selected' : '' }}>
                                                                ثبت نام
                                                            </option>
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
                                            <th>نوع گزارش</th>
                                            <th>آی پی</th>
                                            <th>توضیحات</th>
                                            <th>تاریخ</th>
                                        </tr>
                                    @endslot
                                    @slot('tbody')
                                        @forelse ($logs as $log)
                                            <tr>
                                                <td>
                                                    {{$log->getKey()}}
                                                </td>
                                                <td>
                                                    @if($log->user_id != 0)
                                                        <a href="{{ route('users.edit', $log->user->id) }}" target="_blank">{{ $log->user->id }}</a>
                                                    @else
                                                        نامشخص
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $log->type_label }}
                                                </td>
                                                <td>
                                                    {{ $log->ip }}
                                                </td>
                                                <td>
                                                    {{ $log->description }}
                                                </td>
                                                <td>
                                                    {{ digitsToEastern(jdate($log->created_at)->format('H:i:s - Y/m/d')) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">موردی برای نمایش وجود ندارد.</td>
                                            </tr>
                                        @endforelse
                                    @endslot
                                @endcomponent

                                {{ $logs->withQueryString()->links() }}
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
