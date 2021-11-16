@component('panel.layouts.component', ['title' => 'گزارش پیامک ها'])

    @slot('style')
    @endslot

    @slot('subject')
        <h1><i class="fa fa-users"></i> گزارش پیامک ها </h1>
        <p>مدیریت لیست گزارش پیامک ها.</p>
    @endslot

    @slot('breadcrumb')
        <li class="breadcrumb-item">گزارش پیامک ها</li>
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
                        @component('components.collapse-card', ['id' => 'sms-log-index', 'show' => 'show', 'title' => 'لیست گزارش پیامک ها'])
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
                                            <th>فرستنده</th>
                                            <th>متن پیام</th>
                                            <th>متد ارسال</th>
                                            <th>وضعیت</th>
                                            <th>تاریخ</th>
                                        </tr>
                                    @endslot
                                    @slot('tbody')
                                        @forelse ($sms_logs as $sms_log)
                                            <tr>
                                                <td>
                                                    {{$sms_log->getKey()}}
                                                </td>
                                                <td>
                                                    @if($sms_log->user_id != 0 && !is_null($sms_log->user))
                                                        <a href="{{ route('users.edit', $sms_log->user->id) }}" target="_blank">{{ $sms_log->user->id }}</a>
                                                    @else
                                                        نامشخص
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $sms_log->driver }}
                                                </td>
                                                <td>
                                                    {{ $sms_log->sms_text }}
                                                </td>
                                                <td>
                                                    {{ $sms_log->method }}
                                                </td>
                                                <td>
                                                    {{ $sms_log->status == 1 ? "موفق" : "ناموفق" }}
                                                </td>
                                                <td>
                                                    {{ digitsToEastern(jdate($sms_log->created_at)->format('H:i:s - Y/m/d')) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">موردی برای نمایش وجود ندارد.</td>
                                            </tr>
                                        @endforelse
                                    @endslot
                                @endcomponent

                                {{ $sms_logs->withQueryString()->links() }}
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
