@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<!-- ========== Left Sidebar Start ========== -->
<div class="topbar-menu">
    <div class="container-fluid">
        <!--- Sidemenu -->
        <div id="navigation">
            <ul class="navigation-menu">
{{--                @cannot('companies_manage', 'departments_manage', 'users_manage', 'usersettings_manage')--}}
                <li>
                    <a href="{{ url('/admin/home') }}">
                        <i class="fe-home"></i>
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.goals.index') }}">
                        <i class="fe-send"></i> @lang('global.goal.title')
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/contacts') }}">
                        <i class="fe-message-circle"></i> @lang('global.contact.title')
                    </a>
                </li>
                <li class="has-submenu">
                    <a href="#">
                        <i class="fe-book"></i>
                        @lang('document.menu_title')
                        <div class="arrow-down"></div>
                    </a>
                    <ul class="submenu">
                        @can('documents_manage')
                        <li>
                            <a href="{{ route('category.index') }}">@lang('document.category.title')</a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('document.index') }}">@lang('document.title')</a>
                        </li>
                        @can('documents_manage')
                        <li>
                            <a href="{{ route('download.index') }}">@lang('document.download.title')</a>
                        </li>
                        <li>
                            <a href="{{ url('/acknowledgment/adminview') }}">Acknowledgment Status</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                <li>
                    <a href="{{ route('organisations.index') }}">
                        <i class="fe-bar-chart"></i> @lang('global.organisation.title')
                    </a>
                </li>
                <li>
                    <a href="{{ url('galleries/event') }}">
                        <i class="fe-image"></i> @lang('global.gallery.title')
                    </a>
                </li>
                <li>
                    @php
                        $url = \App\Models\Setting::first()->hr_link;
                        if($url == "") $url = "#";
                    @endphp
                    <a href="{{ $url }}" target="_blank">
                        <i class="fe-cloud"></i> HR
                    </a>
                </li>
                <li class="has-submenu">
                    <a href="#">
                        <i class="fe-box"></i> @lang('global.embed.title')
                        <div class="arrow-down"></div></a>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ url('/embeds') }}">
                                @lang('global.embed.title')
                            </a>
                        </li>
                        @can('documents_manage')
                        <li>
                            <a href="{{ route('embeds.history', 1) }}">
                                Acknowledgment Status
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @can('documents_manage')
                <li class="has-submenu">
                    <a href="#">
                        <i class="fe-users"></i>
                        @lang('templates.user control')
                        <div class="arrow-down"></div></a>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('admin.companies.index') }}">@lang('user_control.company.title')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.departments.index') }}">@lang('user_control.department.title')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}">@lang('templates.users')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.usersetting') }}">@lang('user_control.usersetting.title')</a>
                        </li>
                    </ul>
                </li>
                @endcan
{{--                @endcannot--}}
                @can('documents_manage')
                <li class="has-submenu">
                    <a href="#">
                        <i class="fe-settings"></i>
                        @lang('global.setting.title')
                        <div class="arrow-down"></div>
                    </a>
                    <ul class="submenu">
                        <li>
                            @can('settings_manage')
                            <a href="{{ url('admin/setting/logo') }}">
                                @lang('global.setting.title')
                            </a>
                            @endcan
                        </li>
{{--                        <li>--}}
{{--                            <a href="{{ route('calendar.index') }}">--}}
{{--                                @lang('global.cal setting.title')--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li>
                            <a href="{{ route('memos.index') }}">
                                @lang('dashboard.memo.title')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.messages.index') }}">
                                @lang('dashboard.message.title')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.events.index') }}">
                                @lang('global.event.title')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.galleries.index') }}">
                                @lang('global.gallery.title')
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
    <button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}
