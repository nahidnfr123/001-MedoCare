@extends('layouts.app_back')

@section('title')
    @php $title = 'Department'; @endphp
    @php $subTitle = ''; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12 white-bg">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>All departments</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <div class="animated fadeInRight">
                        <div class="row">

                            @if(count($Departments) >0 )
                            @foreach ($Departments as $Department)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="contact-box center-version" style="border-radius: 4px!important;">
                                    <div class="department_block">
                                        <h3 class="m-b-xs"><strong>{{ $Department->department_name }}</strong></h3>
                                        <img alt="image" class="Depart-img" src="{{ '/storage/image/web_layout/icon/'.$Department->icon }}">
                                    </div>
                                    <div class="contact-box-footer">
                                        <div class="m-t-xs btn-group">
                                            <a href="{{ urlencode('department-doctor|'.encrypt($Department->id)) }}" class="btn btn-xs btn-primary text-dark"> {{'Doctors'}} ({{ count($Department->doctor) }})</a>
                                            <a href="#edit-form-modal" data-toggle="modal" class="btn btn-xs btn-warning text-dark Btn_Edit_Dep"
                                               data-id="{{ $Department->id }}">
                                                {{'Edit'}}
                                            </a>
                                            <a href="{{ urlencode('delete-department|'.encrypt($Department->id))}}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this department?')"> {{'Delete'}} </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            @else
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="contact-box center-version">
                                        <div class="department_block" style="color: #666666!important;">
                                            {{ 'No departments is available' }}
                                            <i class="fa fa-"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <!-- Department add button -->
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="contact-box center-version">
                                    <div class="center-version department_block Add_department">
                                        <a data-toggle="modal" class="" href="#modal-form">
                                            <i class="fa fa-plus color-white"></i>
                                        </a>
                                    </div>
                                    <div class="contact-box-footer">
                                        <div class="m-t-xs btn-group">
                                            -
                                            -
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="bg-dark" style="height: 1px; width: 100%;">
                            <div class="container col-12">
                                <div class="row col-12 text-center">
                                    {{ $Departments->links() }}
                                </div>
                            </div>


                            <!-- Add department Popup -->
                            <div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add new department</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12 b-r">
                                                    <form role="form" action="{{ route('admin.add-department') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        {{--@method('PUT')--}}
                                                        <div class="form-group">
                                                            <label for="DepartmentName" >Department name: *</label>
                                                            <input type="text" name="department_name" id="DepartmentName" placeholder="Department name ..." class="form-control required @error('department_name') is-invalid @enderror" required  value="{{ old('department_name') }}">
                                                        </div>

                                                        <!-- Image -->
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-10">
                                                                    <label  for="date_picker" class="font-normal"> Department icon: * </label>
                                                                    <div class="custom-file">
                                                                        <input id="Department_Image" name="icon" type="file" class="form-control custom-file-input required report @error('icon') is-invalid @enderror" required onchange="document.getElementById('image_preview').src = window.URL.createObjectURL(this.files[0])">
                                                                        <label for="Department_Image" class="custom-file-label">Choose file...</label>
                                                                    </div>
                                                                </div>
                                                                <div style="background-color: #1a2d41; height: 70px;width: 70px; border-radius: 6px;">
                                                                    <img src="" alt="" id="image_preview" style="padding: 4px;height: 100%;width: 100%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Image end -->

                                                        <div class="form-group">
                                                            <label for="Text_Area_CK1" >Department description: *</label>
                                                            <textarea name="details" class="form-control required @error('details') is-invalid @enderror" id="Text_Area_CK1" cols="30" rows="8" placeholder="Description...." required>{{ old('details') }}</textarea>
                                                        </div>

                                                        <div>
                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit" name="Add_New_Department"><strong>Add department</strong></button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- App department Popup end-->


                            {{-- Edit Department Popup --}}
                            <div id="edit-form-modal" class="modal fade" aria-hidden="true" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit department</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12 b-r">
                                                    <form role="form" id="edit_form" action="{{ route('admin.update-department') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        {{--@method('PUT')--}}

                                                        <input type="hidden" hidden name="id" value="{{ old('id') }}">

                                                        <div id="Show_Form_Content">
                                                            <div class="form-group">
                                                                <label for="DepartmentName" >Department name: *</label>
                                                                <input type="text" name="department_name" id="DepartmentName" placeholder="Department name ..." class="form-control required @error('department_name') is-invalid @enderror" required  value="{{ old('department_name') }}">
                                                            </div>

                                                            <!-- Image -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-10">
                                                                        <label  for="date_picker" class="font-normal"> Department icon: * </label>
                                                                        <div class="custom-file">
                                                                            <input id="Department_Image" name="icon" type="file" class="form-control custom-file-input report @error('icon') is-invalid @enderror" onchange="document.getElementById('image_preview2').src = window.URL.createObjectURL(this.files[0])">
                                                                            <label for="Department_Image" class="custom-file-label">Choose file...</label>
                                                                        </div>
                                                                    </div>
                                                                    <div style="background-color: #1a2d41; height: 70px; width: 70px; border-radius: 6px;">
                                                                        <img src="" alt="" id="image_preview2" style="padding: 4px;height: 100%;width: 100%;">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="edit_details" >Department description: *</label>
                                                                <textarea name="edit_details" contenteditable="true" class="form-control required @error('edit_details') is-invalid @enderror" id="edit_details" cols="30" rows="8" placeholder="Department Details...." required>
                                                                    {{ old('edit_details') }}
                                                                </textarea>
                                                            </div>

                                                            <div>
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit" name="Add_New_Department"><strong>Update department</strong></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Edit Department Popup End --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Show Deleted content --}}
    @if(count($Soft_Deleted_Department) > 0 )
    <div class="row m-t-lg">
        <div class="col-sm-12 white-bg">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{'Deleted Departments'}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content" style="display: none;">
                    <div class="animated fadeInRight">
                        <div class="row">
                            @foreach ($Soft_Deleted_Department as $Department)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="contact-box center-version" style="border-radius: 4px!important;">
                                        <div class="department_block">
                                            <h3 class="m-b-xs"><strong>{{ $Department->department_name }}</strong></h3>
                                            <img alt="image" class="Depart-img" src="{{ '/storage/image/web_layout/icon/'.$Department->icon }}">
                                        </div>
                                        <div class="contact-box-footer">
                                            <div class="m-t-xs btn-group">
                                                <a href="{{ urlencode('restore-department|'.encrypt($Department->id))}}" class="btn btn-xs btn-primary text-dark"> Restore</a>
                                                <a href="{{ urlencode('hard-delete-department|'.encrypt($Department->id))}}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this department?')"> Destroy</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>



@stop


@section('Page_Level_script')

    <script>
        $(document).ready(function() {
            //File upload ...
            $('.custom-file-input').on('change', function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>

    <script>
        CKEDITOR.replace('Text_Area_CK1');
        //CKEDITOR.replace('Text_Area_CK2');
    </script>
    <script type= "text/javascript" >
        function createEditor() {
            let hEd = CKEDITOR.instances['edit_details'];
            if(hEd){
                CKEDITOR.instances['edit_description'].destroy();
            }
            hEd = CKEDITOR.replace('edit_details');
        }
        function destroyEditor(){
            let hEd = CKEDITOR.instances['edit_details'];
            if(hEd){
                //CKEDITOR.instances['txt1'] = false;
                //CKEDITOR.remove(hEd);
                CKEDITOR.instances['edit_details'].destroy();
            }
        }
    </script>
    <script>
        $(document).ready(function(){

            $('.Btn_Edit_Dep').click(function(e){
                e.preventDefault();
                let ID = $(this).data('id');

                // Reset all previous data ...
                destroyEditor();
                $('#edit_form input[name="id"]').val('');
                $('#edit_form input[name="department_name"]').val('');
                $('#image_preview2').attr('src', '');
                $('#edit_form textarea[name="edit_details"]').val('');

                // Ajax request for form submission ...
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                // Ajax get request to get previous data ...
                $.ajax({
                    type:'GET',
                    url: "{{ route('admin.Show_Edit_Form_Content') }}",
                    data: { "department_id" :  ID },
                    success:function(data) {
                        //console.log(data);
                        let Id = data.Id;
                        let Icon = data.Icon;
                        let Name = data.Name;
                        let Details = data.Details;

                        $('#edit_form input[name="id"]').val(Id);
                        $('#edit_form input[name="department_name"]').val(Name);
                        /*$('#edit_form input[name="icon"]').val(Icon);*/
                        $('#image_preview2').attr('src', Icon);
                        $('#edit_form textarea[name="edit_details"]').val(Details);
                        //$('#edit_form textarea[name="txt1"]').val(Details);

                        createEditor();
                    }
                });
            });
        });
    </script>


    @if(session('Error_create'))
        <script>
            $(document).ready(function () {
                $('#modal-form').modal('toggle')
            });
        </script>
    @endif
    @if(session('Error_update')) // edit for old data show problem ...
        <script>
            $(document).ready(function () {
                $('#edit-form-modal').modal('toggle');
                createEditor(); // Create CK editor ....
            });
        </script>
    @endif


@stop
