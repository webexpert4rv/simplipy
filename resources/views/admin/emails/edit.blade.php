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
                            <a href="{{ route('emails.index') }}">Emails</a>
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
                            {!! Form::open(['files' => true, 'route' => ['emails.update', 'id' => $model->id], 'class' => 'form-horizontal admin_create form-label-left', 'id' => 'demo-form2']) !!}
                            <input type="hidden" name="_method" value="PUT">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="control-label col-md-2" for="first_name">Email
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="email" type="email" value="{{ old('email', $model->email) }}"
                                           required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="header">Recipient<span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select required="required" name="header_id"
                                            class="form-control col-md-7 col-xs-12">
                                        @foreach(\App\Email::getHeaderOptions() as $key => $header)
                                            <option value="{{ $key }}" {{ old('header_id', $model->header_id) == $key ? 'selected' : ""}}> {{ $header }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="email">Type <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select required="required" name="type_id"
                                            class="form-control col-md-7 col-xs-12">
                                        @foreach(\App\Email::getTypeOptions() as $key => $type)
                                            <option value="{{ $key }}" {{ old('type_id', $model->type_id) == $key ? 'selected' : ""}}> {{ $type }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="center_id">Center <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select required="required" name="center_id"
                                            class="form-control col-md-7 col-xs-12">
                                        @foreach(\App\Email::getCenterOptions() as $key => $center)
                                            <option value="{{ $key }}" {{ old('center_id', $model->center_id) == $key ? 'selected' : ""}}> {{ $center }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a class="btn btn-warning" type="button" href="{{ route('emails.index') }}">Cancel</a>
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