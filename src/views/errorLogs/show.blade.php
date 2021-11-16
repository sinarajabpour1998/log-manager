@component('panel.layouts.component', ['title' => 'مشاهده گزارش خطا' . '#' . digitsToEastern($errorLog->id)])

    @slot('style')
    @endslot

    @slot('subject')
        <h1><i class="fa fa-users"></i> مشاهده گزارش خطا {{ digitsToEastern($errorLog->id) . '#' }}</h1>
        <p>این بخش برای مشاهده گزارش خطا است.</p>
    @endslot

    @slot('breadcrumb')
        <li class="breadcrumb-item"> مشاهده گزارش خطا</li>
        <li class="breadcrumb-item">
            <a href="{{ route('log-manager.error.log.index') }}">لیست گزارش خطا</a>
        </li>
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
                        @component('components.collapse-card', ['id' => 'show_order_information', 'show' => 'show', 'title' => 'اطلاعات خطا ‌' . digitsToEastern($errorLog->id) . '#'])
                            @slot('body')
                                @component('components.table')
                                    @slot('thead')
                                        <tr>
                                            <th colspan="3" class="text-center">اطلاعات خطا</th>
                                        </tr>
                                    @endslot
                                    @slot('tbody')
                                        <tr>
                                            <td>شماره خطا</td>
                                            <td class="text-right ltr-direction">
                                                {{ digitsToEastern($errorLog->id) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ</td>
                                            <td class="text-right ltr-direction">
                                                {{ digitsToEastern(jdate($errorLog->created_at)->format('H:i:s - Y/m/d')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>کاربر</td>
                                            <td class="text-right ltr-direction">
                                                @if($errorLog->user_id != 0 && !is_null($errorLog->user))
                                                    <a href="{{ route('users.edit', $errorLog->user->id) }}" target="_blank">
                                                        {{ decryptString( $errorLog->user->mobile) }}
                                                    </a>
                                                @else
                                                    Unknown
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>آی پی</td>
                                            <td class="text-right ltr-direction">
                                                {{ $errorLog->ip }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>سیستم عامل</td>
                                            <td class="text-right ltr-direction">
                                                {{ $errorLog->os }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>مرورگر</td>
                                            <td class="text-right ltr-direction">
                                                {{ $errorLog->browser }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>کد خطا</td>
                                            <td class="text-right ltr-direction">
                                                {{ $errorLog->error_code }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>پیام خطا</td>
                                            <td class="text-right ltr-direction">
                                                {{ $errorLog->error_message }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>آدرس فایل خطا</td>
                                            <td class="text-right ltr-direction">
                                                {{ $errorLog->target_file }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>آدرس لاین خطا</td>
                                            <td class="text-right ltr-direction">
                                                {{ $errorLog->target_line }}
                                            </td>
                                        </tr>
                                    @endslot
                                @endcomponent
                            @endslot
                        @endcomponent
                    @endslot
                @endcomponent
            </div>
        </div>
    @endslot
    @slot('script')

    @endslot

@endcomponent
