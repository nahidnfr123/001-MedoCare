@extends('layouts.app_back')

@section('title')
    @php $title = 'Blood-Bank'; @endphp
    @php $subTitle = ''; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

    <!-- Page header title -->
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>Blood Bank</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Blood bank</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-8">
                <!--<div class="title-action">
                <a href="" class="btn btn-primary">This is action area</a>
            </div>-->
            </div>
        </div>




        <!-- Website content -->
        <div class="wrapper wrapper-content">

            <div class="row white-bg">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Add blood bank</h5>
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

                            <form id="form" action="backend/add_bloodbank.php" class="wizard-big" method="post" enctype="multipart/form-data">
                                <h1>Bank information</h1>
                                <fieldset>
                                    <h2>Blood bank Information</h2>
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="BloodBankName">Blood bank name: *</label>
                                                <input id="BloodBankName" name="BankName" type="text" class="form-control required" required minlength="5" value="<?php if(isset($_SESSION['BB_Form_Data'])){echo $_SESSION['BB_Form_Data']['BBName'];}?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="Phone">Phone: *</label>
                                                <input id="Phone" name="Phone" type="text" class="form-control required" required placeholder="01XXXXXXXXX" minlength="11" maxlength="11" value="<?php if(isset($_SESSION['BB_Form_Data'])){echo $_SESSION['BB_Form_Data']['BBPhone'];}?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="date_picker" class="font-normal">Blood bank image: </label>
                                                <div class="custom-file">
                                                    <input id="BloodBankImage" name="BloodBankImage" type="file" class="form-control custom-file-input report" onchange="document.getElementById('image_preview').src = window.URL.createObjectURL(this.files[0])">
                                                    <label for="BloodBankImage" class="custom-file-label">Choose file...</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <img src="" alt="" width="200" id="image_preview">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="Other_info"> Other information: </label>
                                                <textarea name="Other_info" id="Other_info" cols="30" rows="10" class="form-control text-areas"><?php if(isset($_SESSION['BB_Form_Data'])){echo $_SESSION['BB_Form_Data']['OtherDetails'];}?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>


                                <h1>Location</h1>
                                <fieldset>
                                    <h2>Location</h2>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="District">District: *</label>
                                                <input id="District" name="District" type="text" class="form-control required" required placeholder="Dhaka" minlength="3" value="<?php if(isset($_SESSION['BB_Form_Data'])){echo $_SESSION['BB_Form_Data']['District'];}?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="Area">Area: *</label>
                                                <input id="Area" name="Area" type="text" class="form-control required" required placeholder="Dhanmondi" minlength="3" value="<?php if(isset($_SESSION['BB_Form_Data'])){echo $_SESSION['BB_Form_Data']['Area'];}?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Address: *</label>
                                                <input id="address" name="Address" type="text" class="form-control required address" required placeholder="27/a, House 13/a" minlength="6" value="<?php if(isset($_SESSION['BB_Form_Data'])){echo $_SESSION['BB_Form_Data']['Address'];}?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">

                                        </div>
                                    </div>
                                </fieldset>

                                <h1>Finish</h1>
                                <fieldset>
                                    <div class="col-lg-12 text-center" style="margin-top: 100px;">
                                        <h1>... Done ...</h1>
                                        <p>Click finish to add the user to the donor list.</p>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

            </div>



            <!-- Data table --><br>
            <div class="animated fadeInRight">
                <div class="row white-bg">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>All blood banks list</h5>
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
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example Blood_donor_tbl">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px!important;" title="Blood bank ID">ID</th>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th style="width: 40px!important;">Phone</th>
                                            <th style="width: 40px!important;">Stock</th>
                                            <th style="width: 40px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr class="gradeA">
                                            <td></td>
                                            <td class="Profile_Image"></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle"> View Stock </button>
                                                    <ul class="dropdown-menu" style="cursor: default;">
                                                        <li><span class="dropdown-item-text">A+ 10 bags</span></li>
                                                        <li><span class="dropdown-item-text">A- 10 bags</span></li>
                                                        <li><span class="dropdown-item-text">AB+ 10 bags</span></li>
                                                        <li><span class="dropdown-item-text">AB- 10 bags</span></li>
                                                        <li><span class="dropdown-item-text">O+ 10 bags</span></li>
                                                        <li><span class="dropdown-item-text">O- 10 bags</span></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle"> </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="">View</a></li>
                                                        <li class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item" href="">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Phone</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



@stop


@section('Page_Level_script')


@stop
