<!-- Topbar Start -->
@php
    $notifications = App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)
        ->where('confirm', 0)->where('due_date', '>=', date('Y-m-d 00:00:00'))->get();
@endphp
<div class="navbar-custom">
    <div class="container-fluid">
    
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li class="dropdown notification-list">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle nav-link">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle waves-effect notification-a" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="fe-bell noti-icon"></i>
                    @if(sizeof($notifications) > 0)
                        <span class="badge badge-danger rounded-circle noti-icon-badge">{{ sizeof($notifications) }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">
                            Notification
                        </h5>
                    </div>
                    <div class="slimscroll noti-scroll">
                        @foreach($notifications as $one)
                            @if (intval($one->docu_id) > 0)
                            <a href="{{ url('/document/view/'.$one->id) }}" class="dropdown-item notify-item">
                                @php
                                $document = App\Models\Document::find($one->docu_id);
                                $revision = App\Models\Revision::find($one->revision_id);
                                
                                $extension = explode('.', $revision->file_name);
                                $datetime1 = new DateTime($revision->created_at);
                                $datetime2 = new DateTime(date("Y-m-d H:i:s"));
                                $interval = $datetime1->diff($datetime2);
                                $format = $interval->format("%d");
                                if (intval($format) < 1){
                                    $format = $interval->format("%");
                                    if (intval($format) < 1){
                                        $format = $interval->format("%i");
                                        if (intval($format) < 1){
                                            $format = $interval->format("%s seconds ago");
                                        }else $format .= " minutes ago";
                                    }else $format .= " hours ago";
                                }else $format .= " days ago";
                                @endphp

                                <div class="notify-icon">
                                    @if (strtolower($extension[sizeof($extension) - 1]) == 'pdf')
                                        <img src="/assets/images/documents/pdf.png" class="img-fluid rounded-circle" height="30" alt="">
                                    @elseif ($extension[sizeof($extension) - 1] == 'doc' || $extension[sizeof($extension) - 1] == 'docx')
                                        <img src="/assets/images/documents/word.png" class="img-fluid rounded-circle" height="30" alt="">
                                    @elseif ($extension[sizeof($extension) - 1] == 'jpeg')
                                        <img src="/assets/images/documents/jpeg.png" class="img-fluid rounded-circle" height="30" alt="">
                                    @elseif ($extension[sizeof($extension) - 1] == 'ppt' || $extension[sizeof($extension) - 1] == 'pptx')
                                        <img src="/assets/images/documents/ppt.png" class="img-fluid rounded-circle" height="30" alt="">
                                    @else
                                        <img src="/assets/images/documents/excel.png" class="img-fluid rounded-circle" height="30" alt="">
                                    @endif
                                </div>
                                {{-- <p class="notify-details">{{ $document->docu_name }}</p> --}}
                                <p class="notify-details" style="word-break: break-all; white-space: normal;">
                                    Hi, one {{ \App\Models\Category::find($document->category_id)->category_name }} ({{ $document->docu_name }}) required you to read
                                </p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>{{ $format }}</small>
                                </p>
                            </a>
                            @else
                            <a href="{{ url('/embeds/view/'.$one->id) }}" class="dropdown-item notify-item">
                                @php
                                $embed = \App\Models\Embed::find($one->embed_id);
                                $embed_html = $embed->embed_html;
                                $datetime1 = new DateTime($embed->created_at);
                                $datetime2 = new DateTime(date("Y-m-d H:i:s"));
                                $interval = $datetime1->diff($datetime2);
                                $format = $interval->format("%d");
                                if (intval($format) < 1){
                                    $format = $interval->format("%h");
                                    if (intval($format) < 1){
                                        $format = $interval->format("%i");
                                        if (intval($format) < 1){
                                            $format = $interval->format("%s seconds ago");
                                        }else $format .= " minutes ago";
                                    }else $format .= " hours ago";
                                }else $format .= " days ago";

                                $due_date = $embed->due_date;
                                @endphp
                                <div class="notify-icon">
                                   <img src="/assets/images/embed/notification.png" class="img-fluid rounded-circle" height="30" alt="">
                                </div>
                                <p class="notify-details" style="word-break: break-all; white-space: normal;">
                                    Hi, you have one new form ({{ $embed->form_name }})
                                </p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>{{ $format }}</small>
                                </p>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light profile-notification" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ url(auth()->user()->photo) }}" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        {{ auth()->user()->name }} 
                        <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <a href="{{ url('profile') }}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Profile</span>
                    </a>
                    <a href="#logout" class="dropdown-item notify-item" onclick="$('#logout').submit();">
                        <i class="fe-log-out"></i>
                        <span>@lang('templates.logout')</span>
                    </a>
                </div>
            </li>

        </ul>
        <div class="logo-box">
            <a href="{{ url('/') }}" class="logo text-center">
                <span class="logo-lg">
                    <img src="{{ url('assets/images/logo.png') }}" alt="" height="57">
                    <!-- <span class="logo-lg-text-light">UBold</span> -->
                </span>
                <span class="logo-sm">
                    <!-- <span class="logo-sm-text-dark">U</span> -->
                    <img src="{{ url('assets/images/logo_sm.png') }}" alt="" height="57">
                </span>
            </a>
        </div>
    </div>
</div>




