<div class="col-12 col-md-12 col-lg-3 col-xl-2">
    <div class="ibox ">
        <div class="ibox-content mailbox-content">
            <div class="file-manager">
                <a class="btn btn-block btn-primary compose-mail" href="{{ route('admin.send-email-form') }}">Compose Mail</a>
                <div class="space-25"></div>
                <h5>Folders</h5>
                <ul class="folder-list m-b-md" style="padding: 0">
                    <li @if($subTitle === 'Inbox') class="active_msg_nav" @endif><a href="{{ route('admin.inbox') }}"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning float-right">{{$Count_Msg}}</span> </a></li>
                    <li @if($subTitle === 'Send Email') class="active_msg_nav" @endif><a href="{{ route('admin.send-email-form') }}"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                    <li @if($subTitle === 'Trash Messages') class="active_msg_nav" @endif><a href="{{ route('admin.trash-message') }}"> <i class="fa fa-trash-o"></i> Trash</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
