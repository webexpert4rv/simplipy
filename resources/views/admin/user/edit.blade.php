@extends('admin.layouts.admin_layout')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
          rel="stylesheet">
@endsection
@section('title', $page_title)
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <ul class="breadcrumb">
                        <li>
                            {!! $model->getListLink() !!}
                        </li>
                        <li class="active">
                           {!! $page_title !!}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{!! $page_title !!}
                                <small> fill details in below form</small>
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                {{--  <li class="dropdown">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                      <ul class="dropdown-menu" role="menu">
                                          <li><a href="#">Settings 1</a>
                                          </li>
                                          <li><a href="#">Settings 2</a>
                                          </li>
                                      </ul>
                                  </li>--}}
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>
                            {!! Form::open(['files' => true, 'route' => $model->getEditLink(true), 'class' => 'form-horizontal form-label-left', 'id' => 'demo-form2']) !!}
                            <input type="hidden" name="_method" value="PUT">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">First Name
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="first_name" type="text" required="required"
                                           value="{{ old('first_name', $profile->first_name) }}"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Last Name <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="last_name" type="text" required="required"
                                           value="{{ old('last_name', $profile->last_name) }}"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('email', $model->email) }}" type="email" name="email"
                                           class="form-control col-md-7 col-xs-12" required="required">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Center <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select required="required" name="center_id"
                                            class="form-control col-md-7 col-xs-12">
                                        @foreach(\App\Email::getCenterOptions() as $key => $center)
                                            <option {{ old('center_id', $model->center_id) == $key ? 'selected' : ""}}> {{ $center }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="profile_pic">Profile
                                    Picture
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="profile_pic" id="profile_pic">
                                    <div id="profile-pic-div" class="col-md-4">
                                        @if(\App\SystemFile::getImageUrl($profile, 'profile_pic'))
                                            <img src="{{ \App\SystemFile::getImageUrl($profile, 'profile_pic') }}"
                                                 width="100%" height="127px">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_num">Phone
                                    Number
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="phone_num" type="text"
                                           value="{{ old('phone_num', $profile->phone_num) }}"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Address
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="address"
                                              class="form-control col-md-7 col-xs-12"> {{ old('address', $profile->address) }} </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Address 2
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="address2"
                                           class="form-control col-md-7 col-xs-12"
                                           value="{{ old('address2', $profile->address2) }}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">State
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="state"
                                           class="form-control col-md-7 col-xs-12"
                                           value="{{ old('state', $profile->state) }}"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zip">Zip
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="zip" type="text" value="{{ old('zip', $profile->zip) }}"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="city" type="text" value="{{ old('city', $profile->city) }}"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="country" type="text" value="{{ old('country', $profile->country) }}"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a class="btn btn-primary" type="button" href="{{ url('admin/users') }}">Cancel</a>
                                    <button class="btn btn-primary" type="reset">Reset</button>
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
    <script>
        $(".datepicker").datepicker({format: "yyyy-mm-dd", autoclose: true, endDate: new Date()});
        $("#profile_pic").change(function () {
            showImage(this);
        });


        function showImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile-pic-div img').attr('src', e.target.result);
                    $('#profile-pic-div img').attr('src', e.target.result);
                    $('#profile-pic-div img').attr('src', e.target.result);

                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection