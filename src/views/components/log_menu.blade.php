@if(Auth()->user()->isAbleTo([Config::get('log-manager.permissions.menu.main')]))
    <li class="treeview {{ isActive( ['log.index'], 'is-expanded' ) }}">
        <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-history"></i>
            <span class="app-menu__label">گزارش ها</span>
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
        </ul>
    </li>
@endif
