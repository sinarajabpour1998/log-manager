@if(Auth()->user()->isAbleTo([Config::get('log-manager.permissions.menu.main')]))
    <li class="treeview {{ isActive( ['log-manager.index', "log-manager.error.log.index", "log-manager.error.log.show", "log-manager.sms.log.index"], 'is-expanded' ) }}">
        <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-history"></i>
            <span class="app-menu__label">گزارش ها</span>
            <x-log-menu type="error-log-counter"></x-log-menu>
            <i class="treeview-indicator fa fa-angle-left"></i>
        </a>
        <ul class="treeview-menu">
            @if(Auth()->user()->isAbleTo([Config::get('log-manager.permissions.menu.all-logs')]))
                <li>
                    <a class="treeview-item pl-3 {{ isActive('log-manager.index') }}" href="{{ route('log-manager.index') }}">
                        <i class="icon fa fa-circle-o"></i>همه گزارش ها
                    </a>
                </li>
            @endif
            @if(Config::get('log-manager.sms_logs') == "enable")
                @if(Auth()->user()->isAbleTo([Config::get('log-manager.permissions.menu.sms-logs')]))
                    <li>
                        <a class="treeview-item pl-3 {{ isActive(["log-manager.sms.log.index"]) }}" href="{{ route('log-manager.sms.log.index') }}">
                        <span>
                            <i class="icon fa fa-circle-o"></i>
                            گزارش پیامک ها
                        </span>
                            <span class="error-log-child-badge">
                            </span>
                        </a>
                    </li>
                @endif
            @endif
            @if(Auth()->user()->isAbleTo([Config::get('log-manager.permissions.menu.error-logs')]))
                <li>
                    <a class="treeview-item pl-3 {{ isActive(['log-manager.error.log.index', "log-manager.error.log.show"]) }}" href="{{ route('log-manager.error.log.index') }}">
                        <span>
                            <i class="icon fa fa-circle-o"></i>
                            گزارش خطاها
                        </span>
                        <span class="error-log-child-badge">
                            <x-log-menu type="error-log-counter"></x-log-menu>
                        </span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif
