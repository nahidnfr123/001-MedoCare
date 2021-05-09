@extends('layouts.app_back')

@section('title')
    @php $title = 'Contact Us'; @endphp
    @php $subTitle = 'Trash Messages'; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

    <div class="wrapper wrapper-content">
        <div class="row">


            @include('layouts.partials.admin.contact_side_nav')



            <div class="col-lg-9 animated fadeInRight">
                <div class="mail-box-header">

                    {{--<form method="get" action="index.html" class="float-right mail-search">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="search" placeholder="Search email">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>--}}
                    <h2>
                        Trashed Messages
                    </h2>
                    <div class="mail-tools m-t-md">

                        <button class="btn btn-white btn-sm" title="Refresh inbox" onclick="window.location.href = '{{ route('admin.trash-message') }}'"><i class="fa fa-refresh"></i> Refresh</button>
                        <button class="btn btn-white btn-sm" title="Move to trash" name="bulk_delete" id="bulk_delete"><i class="fa fa-trash-o"></i> Remove from trash</button>
                        <button class="btn btn-white btn-sm" title="Restore" name="bulk_restore" id="bulk_restore"><i class="fa fa-trash-restore"></i> Restore</button>

                    </div>
                </div>
                <div class="mail-box">
                    <div class="col-12 alert alert-success Success_message_message_box">

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-mail message_table no-borders" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($Deleted_Messages) > 0)
                                @foreach($Deleted_Messages as $message)
                                    <tr @if($message->seen === 0) class="comment_unread" @else class="comment_read" @endif>
                                        <td class="check-mail">
                                            <input type="checkbox" class="i-checks mail_checkbox" name="mail_checkbox[]" value="{{ $message->id }}">
                                        </td>
                                        <td class="mail-ontact">{{ $message->name }}</td>
                                        <td class="mail-subject">
                                                <!-- Truncate blog description -->
                                                @php
                                                    $string = strip_tags($message->message);
                                                    if (strlen($string) > 20) {
                                                        // truncate string
                                                        $stringCut = substr($string, 0, 100);
                                                        $endPoint = strrpos($stringCut, ' ');
                                                        //if the string doesn't contain any space then it will cut without word basis.
                                                        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                        $string .= '... ';
                                                    }
                                                    echo $string;
                                                @endphp
                                        </td>
                                        <td class="text-white text-center">
                                            <span class="m-l-sm" title="replied">@if($message->replied === 1)<i class="fa fa-reply"></i>@endif</span>
                                            <span class="m-r-sm" title="seen">@if($message->seen === 1)<i class="fa fa-eye"></i>@endif</span>
                                        </td>
                                        <td class="text-right mail-date">{{ date('M-d-y H:i A', strtotime($message->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-center"> No deleted messages. </p>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="Pagination">
                        <br>
                        <div class="text-center row" style="position: relative;">
                            <div style="position: absolute;left: 50%;top: 60%;transform: translate(-50%, -50%)">{{ $Deleted_Messages->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('Page_Level_script')
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


            $('.Success_message_message_box').hide();

            $('.message_table').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    //{extend: 'copy'},
                    //{extend: 'csv'},
                    //{extend: 'excel', title: 'ExampleFile'},
                    //{extend: 'pdf', title: 'ExampleFile'},

                    /*{extend: 'print',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }*/
                ]
            });


            //Delete
            $(document).on('click', '#bulk_delete', function () {
                let id = [];
                if(confirm('Are you sure you want to delete message.')){
                    $('.mail_checkbox:checked').each(function () {
                        id.push($(this).val());
                        if(id.length > 0){
                            $.ajax({
                                url: "{{ route('admin.destroy-multiple-message') }}",
                                method: "GET",
                                data: {id:id},
                                success:function (data) {
                                    $('.Success_message_message_box').fadeIn(200);
                                    $('.Success_message_message_box').html(data);
                                    $('.Success_message_message_box').fadeOut(2000);
                                    window.location.href = "{{ route('admin.trash-message') }}";
                                }
                            });
                        }else{
                            alert('You did not select message to perform the delete action.');
                        }
                    });
                }
            });


            //Restore
            $(document).on('click', '#bulk_restore', function () {
                let id = [];
                if(confirm('Are you sure you want to restore message.')){
                    $('.mail_checkbox:checked').each(function () {
                        id.push($(this).val());
                        if(id.length > 0){
                            $.ajax({
                                url: "{{ route('admin.restore-multiple-message') }}",
                                method: "GET",
                                data: {id:id},
                                success:function (data) {
                                    $('.Success_message_message_box').fadeIn(200);
                                    $('.Success_message_message_box').html(data);
                                    $('.Success_message_message_box').fadeOut(2000);
                                    window.location.href = "{{ route('admin.trash-message') }}";
                                }
                            });
                        }else{
                            alert('You did not select message to perform the delete action.');
                        }
                    });
                }
            });

        });
    </script>
@stop
