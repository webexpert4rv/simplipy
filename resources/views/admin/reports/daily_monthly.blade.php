@extends('admin.layouts.admin_layout')
@section('title', $page_title)
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <ul class="breadcrumb">
                       {{-- <li>
                           <a href="{{ route('emails.index') }}">Adresses Mails</a>
                        </li>--}}
                        <li class="active">
                           Daily/Monthly Emails
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2> Daily/Monthly Emails
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
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left admin_create"
                                  method="post" action="{{ route('dailyReports.store') }}">
                                {!! csrf_field() !!}

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="email">Type <span
                                                class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required="required" name="type_id"
                                                class="form-control col-md-7 col-xs-12 dailyType">
                                           <option value="1">Daily Report</option>
                                           <option value="2">Monthly Report</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                       {{-- <a class="btn btn-warning" type="button"
                                           href="{{ route('emails.index') }}">Annuler</a>--}}
                                        {{-- <button class="btn btn-primary" type="reset">Réinitialiser</button> --}}
                                        <button type="submit" class="btn btn-success">Resend Email</button>
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
    <script>
        $(document).ready(function () {
            $('.centerDaily').append( '<option value="3" selected>Cardif</option>');
            $('.dailyType').change(function () {
                if($(this).val() == 1){
                    $('.centerDaily').attr('readonly');
                    $('.centerDaily').css('cursor','pointer');
                    $('.centerDaily').css('pointer-events','none');
                    $('.centerDaily').append( '<option value="3" selected>Cardif</option>');
                }
                if($(this).val() == 2){
                    $(".centerDaily").removeAttr('readonly');
                    $(".centerDaily").css('cursor','');
                    $(".centerDaily").css('pointer-events','');
                    $(".centerDaily option[value='3']").remove();
                }
            });
        });
    </script>
@endsection