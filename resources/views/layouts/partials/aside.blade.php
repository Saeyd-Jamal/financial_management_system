<style>
    aside{
        font-size: 15px;
        font-weight: 500;
    }
</style>
<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar style="background-color: rgb(153 252 255 / 23%) !important; box-shadow: 0px 0px 7px rgba(0, 0, 0, 0.3) !important;">
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3"
        data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.png') }}" style="max-width: 50%">
                <h1 class="h3 mt-2">{{ config('app.name') }}</h1>
            </a>
        </div>

        @can('view','App\\Models\Salary')
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>المالية</span>
        </p>
        @endcan
        <ul class="navbar-nav flex-fill w-100 mb-2">
            @can('view','App\\Models\Salary')
            <li class="nav-item w-100">
                <a class="nav-link" href="{{route('salaries.index')}}">
                    <span style="width: 16px;height: 16px">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                    </span>
                    <span class="ml-3 item-text">الرواتب</span>
                </a>
            </li>
            @endcan
            @can('report.view')
            <li class="nav-item w-100">
                <a class="nav-link" href="{{route('report.index')}}">
                    <i class="fe fe-file fe-16"></i>
                    <span class="ml-3 item-text">التقارير</span>
                </a>
            </li>
            @endcan
        </ul>
        @can('view','App\\Models\FixedEntries')
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>ثوابت المالية</span>
        </p>
        @endcan
        <ul class="navbar-nav flex-fill w-100 mb-2">
            @can('view','App\\Models\ReceivablesLoans')
            <li class="nav-item w-100">
                <a class="nav-link" href="{{route('totals.index')}}">
                    <i class="fe fe-trello fe-16"></i>
                    <span class="ml-3 item-text">المستحقات والقروض</span>
                </a>
            </li>
            @endcan
            @can('view','App\\Models\FixedEntries')
            <li class="nav-item dropdown">
                <a href="#fixed_entries" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle nav-link">
                    <i class="fe fe-lock fe-16"></i>
                    <span class="ml-3 item-text">التعديلات</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="fixed_entries">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{route('fixed_entries.index')}}">
                            <i class="fe fe-users fe-16"></i>
                            <span class="ml-1 item-text">الموظفين</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{route('specific_salaries.ratio')}}">
                            <i class="fe fe-percent fe-16"></i>
                            <span class="ml-1 item-text">النسبة</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{route('specific_salaries.private')}}">
                            <i class="fe fe-box fe-16"></i>
                            <span
                                class="ml-1 item-text">خاص</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{route('specific_salaries.riyadh')}}">
                            <i class="fe fe-list fe-16"></i>
                            <span
                                class="ml-1 item-text">رياض</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{route('specific_salaries.fasle')}}">
                            <i class="fe fe-calendar fe-16"></i>
                            <span
                                class="ml-1 item-text">فصلي</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{route('specific_salaries.daily')}}">
                            <i class="fe fe-inbox fe-16"></i>
                            <span
                                class="ml-1 item-text">يومي</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{route('specific_salaries.interim')}}">
                            <i class="fe fe-watch fe-16"></i>
                            <span class="ml-1 item-text">مؤقت</span></a>
                    </li>
                </ul>
            </li>
            @endcan
        </ul>
        @can('view','App\\Models\Employee')
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>البيانات</span>
        </p>
        @endcan
        <ul class="navbar-nav flex-fill w-100 mb-2">
            @can('view','App\\Models\Employee')
                <li class="nav-item w-100">
                    <a class="nav-link" href="{{route('employees.index')}}">
                        <i class="fe fe-users fe-16"></i>
                        <span class="ml-3 item-text">الموظفين</span>
                    </a>
                </li>
            @endcan
            @can('view','App\\Models\Bank')
            <li class="nav-item w-100">
                <a class="nav-link" href="{{route('banks.index')}}">
                    <i class="fe fe-briefcase fe-16"></i>
                    <span class="ml-3 item-text">البنوك</span>
                </a>
            </li>
            @endcan
            @can('view','App\\Models\BanksEmployees')
            <li class="nav-item w-100">
                <a class="nav-link" href="{{route('banks_employees.index')}}">
                    <i class="fe fe-credit-card fe-16"></i>
                    <span class="ml-3 item-text">حسابات الموظفين</span>
                </a>
            </li>
            @endcan
            @can('view','App\\Models\SalaryScale')
            <li class="nav-item w-100">
                <a class="nav-link" href="{{route('salary_scales.index')}}">
                    <i class="fe fe-bar-chart-2 fe-16"></i>
                    <span class="ml-3 item-text">سلم الرواتب</span>
                </a>
            </li>
            @endcan
        </ul>
        @can('view','App\\Models\User')
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>إدارة النظام</span>
        </p>
        @endcan
        <ul class="navbar-nav flex-fill w-100 mb-2">
            @can('view','App\\Models\User')
            <li class="nav-item w-100">
                <a class="nav-link" href="{{route('users.index')}}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">المستخدمين</span>
                    <span class="badge badge-pill badge-primary">
                        <i class="fe fe-arrow-left fe-16"></i>
                    </span>
                </a>
            </li>
            @endcan
            @can('view','App\\Models\Constant')
            <li class="nav-item w-100">
                <a class="nav-link" href="{{route('constants.index')}}">
                    <i class="fe fe-layers fe-16"></i>
                    <span class="ml-3 item-text">ثوابت النظام</span>
                    <span class="badge badge-pill badge-primary">
                        <i class="fe fe-arrow-left fe-16"></i>
                    </span>
                </a>
            </li>
            @endcan
            @can('view','App\\Models\Currency')
            <li class="nav-item w-100">
                <a class="nav-link" href="{{route('currencies.index')}}">
                    <i class="fe fe-dollar-sign fe-16"></i>
                    <span class="ml-3 item-text">العملات</span>
                    <span class="badge badge-pill badge-primary">
                        <i class="fe fe-arrow-left fe-16"></i>
                    </span>
                </a>
            </li>
            @endcan

        </ul>
        {{-- for Example --}}
        {{-- <p class="text-muted nav-heading mt-4 mb-1">
            <span>Components</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="widgets.html">
                    <i class="fe fe-layers fe-16"></i>
                    <span class="ml-3 item-text">Widgets</span>
                    <span class="badge badge-pill badge-primary">New</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#forms" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle nav-link">
                    <i class="fe fe-credit-card fe-16"></i>
                    <span class="ml-3 item-text">Forms</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="forms">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./form_elements.html"><span
                                class="ml-1 item-text">Basic Elements</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./form_advanced.html"><span
                                class="ml-1 item-text">Advanced Elements</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./form_validation.html"><span
                                class="ml-1 item-text">Validation</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./form_wizard.html"><span
                                class="ml-1 item-text">Wizard</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./form_layouts.html"><span
                                class="ml-1 item-text">Layouts</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./form_upload.html"><span class="ml-1 item-text">File
                                upload</span></a>
                    </li>
                </ul>
            </li>
        </ul> --}}
        <div class="btn-box w-100 mt-3 mb-1">
            <p class="text-muted font-weight-bold h6">© تم الإنشاء بواسطة <a href="https://saeyd-jamal.github.io/My_Portfolio/" target="_blank">م.السيد الأخرس</a></p>
        </div>
    </nav>
</aside>
