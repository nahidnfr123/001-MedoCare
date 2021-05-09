{{--@if(!isset($title)) {{$title=''}} @endif
@if(!isset($subTitle)) {{$subTitle=''}} @endif--}}

<nav class="navbar-default navbar-static-side">
    <!-- role="navigation" -->
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="{{ Auth::user()->avatar }}" height="80px" width="80px" style="object-fit: cover; object-position: center; border: 3px solid white;"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                        <span class="text-muted text-xs block">Admin<b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs" style="color: #4e555b;">
                        <li><a class="dropdown-item" href="{{ route('admin.admin-profile') }}"><i class="fa fa-user"></i> Profile</a></li>
                        {{--<li><a class="dropdown-item" href=""><i class="fa fa-phone"></i> Contacts</a></li>
                        <li><a class="dropdown-item" href=""><i class="fa fa-envelope"></i> Mail-box</a></li>--}}
                        <li class="dropdown-divider"></li>
                        {{--<li><a class="dropdown-item" href="logout.php">Logout</a></li>--}}

                        <li><a href="{{ route('logout') }}" class="dropdown-item"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    Medo
                </div>
            </li>

            <li @if($title === 'Dashboard')class="active"@endif>
                <a href="{{ route('admin.dashboard') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
            </li>

            <li @if($title === 'Manage User')class="active"@endif>
                <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Manage Users</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    {{--<li @if($subTitle === 'blood_bank_staff')class="active"@endif ><a href="">Blood Bank Staff</a></li>--}}
                    <li @if($subTitle === 'Doctor')class="active"@endif ><a href="{{ route('admin.manage-doctor') }}">Doctor</a></li>
                    <li @if($subTitle === 'Patients')class="active"@endif ><a href="{{ route('admin.manage-patient') }}">Patient</a></li>
                    <li @if($subTitle === 'Add User')class="active"@endif ><a href="{{ route('admin.create-user') }}">Add User</a></li>
                </ul>
            </li>
            {{--<li>
                <a href=""><i class="fa fa-edit"></i> <span class="nav-label">Appointments</span></a>
            </li>--}}
            <li @if($title === 'Department')class="active"@endif>
                <a href="{{ route('admin.view-departments') }}"><i class="fa fa-sitemap"></i> <span class="nav-label">Departments</span></a>
            </li>
            <li @if($title === 'Blog')class="active"@endif>
                <a href="{{ route('admin.view-blog') }}"><i class="fa fa-rss"></i> <span class="nav-label">Blog</span></a>
            </li>
            {{--<li @if($title === 'Blood-Bank')class="active"@endif>
                <a href="{{ route('admin.blood-bank') }}"><i class="fa fa-flask"></i> <span class="nav-label">Blood Banks</span></a>
            </li>--}}
            <li @if($title === 'Contact Us')class="active"@endif>
                <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">Contact Us </span> <span class="fa arrow" style="padding-left: 6px;"></span> @if($Count_Msg !== 0)<span class="label label-primary float-right">{{ $Count_Msg }}</span>@endif</a>
                <ul class="nav nav-second-level collapse">
                    <li @if($subTitle === 'Inbox')class="active"@endif><a href="{{ route('admin.inbox') }}">Inbox</a></li>
                </ul>
            </li>
            <li @if($title === 'Notification')class="active"@endif>
                <a href=""><i class="fa fa-bell"></i> <span class="nav-label">Notifications</span> <span class="fa arrow" style="padding-left: 6px;"></span> <span class="label label-primary float-right">16</span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="" id="damian">Posts <span class="fa arrow" style="padding-left: 6px;"></span> <span class="label label-primary float-right">16</span></a>
                        <ul class="nav nav-third-level">
                            <li> <a href="">New Post</a></li>
                            <li> <a href="">New Comment</a></li>
                        </ul>
                    </li>
                    <li><a href="">Blog Comment</a></li>
                    <li><a href="">Doctor review</a></li>
                    <li><a href="">Donor review</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
