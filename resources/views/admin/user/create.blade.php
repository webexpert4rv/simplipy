@extends('admin.layouts.admin_layout')
@section('title', $page_title)
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <ul class="breadcrumb">
                        <li>
                           {!! $back_link !!}
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
                            <h2> {!! $page_title !!}
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
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left admin_create"
                                  method="post" action="{!! @$add_link !!}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="role_id" value="{{ @$role_id }}">
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="first_name">Prénom
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="first_name" type="text" value="{{ old('first_name') }}"
                                               required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="last_name">Nom
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="last_name" type="text" value="{{ old('last_name') }}"
                                               required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="email">Adresse Mail<span
                                                class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('email') }}" type="email" name="email" required="required"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <input type="hidden" name="center_id" value="1">
                                {{--<div class="form-group">
                                    <label class="control-label col-md-2" for="email">Center <span
                                                class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required="required" name="center_id"
                                                class="form-control col-md-7 col-xs-12">
                                            @foreach(\App\Email::getCenterOptions() as $key => $center)
                                            <option value="{{ $key }}" {{ old('center_id') == $key ? 'selected' : ""}}> {{ $center }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>--}}
                                <div class="form-group">
                                    <label for="password"
                                           class="control-label col-md-2">Mot de Passe</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="middle-name" class="form-control col-md-7 col-xs-12" type="password"
                                               name="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation"
                                           class="control-label col-md-2">Confirmer  le Mot de Passe</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="middle-name" class="form-control col-md-7 col-xs-12" type="password"
                                               name="password_confirmation">
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <a class="btn btn-warning" type="button"
                                           href="{{ url('admin-login-cardif/'.$cancel_link) }}">Annuler</a>
                                       
                                        <button type="submit" class="btn btn-success">Créer</button>
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
