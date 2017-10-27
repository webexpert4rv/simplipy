@extends('admin.layouts.admin_layout')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <ul class="breadcrumb">
                        <li class="active">
                            Profil
                        </li>
                    </ul>
                </div>

                {{--<div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                        </div>
                    </div>
                </div>--}}
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Détails du Profil
                                <small></small>
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="btn btn-primary" id="edit-profile"><i class="fa fa-pencil"></i>Edit
                                        Profile</a>
                                </li>

                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" id="view_profile_div">
                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                                <div class="profile_img">
                                    <div id="crop-avatar">
                                        <!-- Current avatar -->
                                        @if(!empty(\App\SystemFile::getImageUrl($model, 'profile_pic')))
                                            <img class="img-responsive avatar-view"
                                                 src="{{ \App\SystemFile::getImageUrl($model, 'profile_pic')}}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                                <h3>{{ @$model->first_name.' '.@$model->last_name}}</h3>

                                <ul class="list-unstyled user_data">
                                    <li>Email: {{ $model->email}}
                                    </li>
                                    <li>Phone: {{ @$model->phone_num}}
                                    </li>
                                    <li>ssn: {{ @$model->ssn}}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                                <h4>Adresse</h4>
                                <ul class="list-unstyled user_data">
                                    <li><b>Adresse : </b>
                                        <span id="address_data"
                                              class="profile-text">{{ @$model->address }}</span>
                                    </li>
                                    <li><b>Adresse 2 : </b>
                                        <span id="zip_data"
                                              class="profile-text">{{ @$model->address2}}</span>
                                    </li>
                                    <li><b>Code Postal : </b>
                                        <span id="country_data"
                                              class="profile-text">{{ @$model->zip }}</span>
                                    </li>
                                    <li><b>Ville : </b>
                                        <span id="city_data"
                                              class="profile-text">{{ @$model->city }}</span>
                                    </li>

                                    <li><b>Region : </b>
                                        <span id="city_data"
                                              class="profile-text">{{ @$model->state }}</span>
                                    </li>

                                    <li><b>Pays : </b>
                                        <span id="country_data"
                                              class="profile-text">{{ @$model->country }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="x_content" style="display: none;" id="edit_profile_div">
                            <form class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data"
                                  action="{{ url('admin/profile/'.$model->id.'/update') }}">
                                {!! csrf_field() !!}
                                <div id="preview-image-div">
                                    @if(!empty(\App\SystemFile::getImageUrl($model, 'profile_pic')))
                                        <img class="img-responsive avatar-view"
                                             src="{{ \App\SystemFile::getImageUrl($model, 'profile_pic')}}">
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Profile Pic
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="profile_pic" id="file-1"
                                               class="inputfile inputfile-1"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">First Name
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="First Name" name="first_name"
                                               value="{{ @$model->first_name }}" id="first_name"
                                               class="form-control"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Last Name
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Last Name" name="last_name"
                                               value="{{ @$model->last_name }}" id="last_name"
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Adresse Mail
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="email" placeholder="Email" name="email"
                                               value="{{ @$model->email }}" id="email" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Date de Naissance
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="DOB" name="dob"
                                               value="{{ @$model->dob }}" id="dob"
                                               class="form-control datepicker"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Numéro de Téléphone
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Phone Number" name="phone_num"
                                               value="{{ @$model->phone_num }}" id="phone_num"
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">SSN
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="ssn" name="ssn"
                                               value="{{ @$model->ssn }}" id="ssn" class="form-control"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Address1
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Address1" name="address"
                                               value="{{ @$model->address }}" id="address"
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Address2
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Address2" name="address2"
                                               value="{{ @$model->address2 }}" id="address2" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Postal Code
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Postal Code" name="zip"
                                               value="{{ @$model->zip }}" id="zip" class="form-control"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">City
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="City" name="city"
                                               value="{{ @$model->city }}" id="city" class="form-control"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">State
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="State" name="state"
                                               value="{{ @$model->state }}" id="state" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Country
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="Country" name="country"
                                               value="{{ @$model->country }}" id="country"
                                               class="form-control"/>
                                    </div>
                                </div>


                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button class="btn btn-primary" type="reset" id="cancel">Cancel</button>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="<?php echo(asset('js/admin_dist/bootstrap-datepicker.js')); ?>"></script>
    <script type="text/javascript">
        $(".datepicker").datepicker({format: "yyyy-mm-dd", autoclose: true, endDate: "-18y"});
        $("#edit-profile").click(function () {
            $("#edit_profile_div").show();
            $("#view_profile_div").hide();
        })
        $("#cancel-profile").click(function () {
            $("#edit_profile_div").hide();
            $("#view_profile_div").save();
        })
    </script>
@endsection
