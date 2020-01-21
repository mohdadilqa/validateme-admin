<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.dashboard.index") }}" class="nav-link {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                    </i>
                    {{ trans('cruds.dashboard.title') }}
                </a>
            </li>
            @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    {{ trans('cruds.role.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                        @endcan

                        @can('company_user_access')
                        
                            @if ((Auth::user()->roles->first()->toArray()['title'] ==='company admin'))
                                <li class="nav-item">
                                    <a href="{{ route("admin.company-user.index") }}" class="nav-link {{ request()->is('admin/company-user') || request()->is('admin/company-user/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-user nav-icon">

                                        </i>
                                        {{ trans('cruds.company_user.title') }}
                                    </a>
                                </li>
                            @endif
                        @endcan
                        
                    </ul>
                </li>


                @can('doctype_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.docTypeManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('doctype_field_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.doctype-field.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.doctype_field.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('doctype_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.doctype.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    {{ trans('cruds.doctype.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('log_index')
                    @if ((Auth::user()->roles->first()->toArray()['title'] ==='superadmin') || (Auth::user()->roles->first()->toArray()['title'] ==='support staff'))
                    <li class="nav-item">
                        <a href="{{ route("admin.log.index") }}" class="nav-link {{ request()->is('admin/log') || request()->is('admin/log/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('cruds.log.title') }}
                        </a>
                    </li>
                    @endif
                @endcan
            @endcan
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>