<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" style="margin-bottom: 0">
        <!-- role="navigation" -->
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search.php">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
            <span style="line-height: 60px;">
                <span onclick="openFullscreen()" class="active Expand"><i class="fa fa-arrows-alt"></i></span>
                <span onclick="closeFullscreen()" class="active Shrink" ><i class="fa fa-compress"></i></span>
            </span>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome to MedoCare Admin.</span>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope"></i> @if($Count_Msg !== 0)<span class="label label-warning">{{ $Count_Msg }}</span> @endif
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    @if(count($Msg) > 0)
                        @foreach($Msg as $Ms)
                        <li @if($Ms->seen === 1) style="background-color: #d0d0d0;transition: all 200ms;" @endif>
                            <a href="{{ url('admin/message-details|') . encrypt($Ms->id) }}" style="font-size: 12px;">
                                <div class="dropdown-messages-box">
                                    <div>
                                        <small class="float-right">
                                        @php
                                            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:s:i'));
                                            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:s:i', strtotime($Ms->created_at)));
                                            $diff_in_hours = $to->diffInHours($from);
                                        @endphp
                                            @if($diff_in_hours === 0)
                                                {{ 'Less then an hr ago' }}
                                            @else
                                                {{ $diff_in_hours . 'hr ago' }}
                                            @endif
                                        </small>
                                        <strong>{{ ucwords($Ms->name) }}</strong>
                                        <div>
                                            @php
                                                $string = strip_tags($Ms->message);
                                                if (strlen($string) > 20) {
                                                    // truncate string
                                                    $stringCut = substr($string, 0, 60);
                                                    $endPoint = strrpos($stringCut, ' ');
                                                    //if the string doesn't contain any space then it will cut without word basis.
                                                    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                    $string .= '... ';
                                                }
                                                echo $string;
                                            @endphp
                                        </div>
                                        <small class="text-muted"><strong> {{ date('d.M.Y H:i:s a', strtotime($Ms->created_at)) }} </strong></small>
                                        <small class="text-muted float-right"><strong> @if($Ms->seen === 1) {{ 'seen' }} @endif </strong></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        @endforeach
                    @else
                        No message available ...
                    @endif

                    <li>
                        <div class="text-center link-block">
                            <a href="{{ route('admin.inbox') }}" class="dropdown-item">
                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

            {{--<li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="mailbox.html" class="dropdown-item">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                <span class="float-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <a href="profile.html" class="dropdown-item">
                            <div>
                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                <span class="float-right text-muted small">12 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <a href="grid_options.html" class="dropdown-item">
                            <div>
                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                <span class="float-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <div class="text-center link-block">
                            <a href="notifications.html" class="dropdown-item">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>--}}


            <li><a href="{{ route('logout') }}"
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

    </nav>
</div>
