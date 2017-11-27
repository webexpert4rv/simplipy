@extends('admin.layouts.admin_layout')
@section('title', $page_title)
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <ul class="breadcrumb">
                        <li>
                           <a href="{{route('reports.index')}}">Gestion Messagerie</a>
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
                        <div class="x_title" style="border-bottom: 0px white !important; margin-bottom: -30px!important;">
                            <h2> {!! $page_title !!}
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
                          {{--  <p class="main_title">Fields marked with an asterisk * are mandatory.</p>--}}
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"
                                  method="post" action="{{ url('user/reports') }}">
                                {!! csrf_field() !!}
                                <div class="first_section">
                                    <h1 class="fh1" >Centre Médical</h1>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Centre <span
                                                    class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select required="required" name="center_id"
                                                    class="form-control col-md-7 col-xs-12">
                                                @foreach(\App\Report::getCenterOptions() as $key => $center)
                                                    <option value="{{ $key }}" {{ old('center_id') == $key ? 'selected' : ""}}> {{ $center }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="second_section">
                                    <h1 class="fh2">Informations personnelles du patient</h1>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="civil">Civilité<span
                                                    class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select required="required" name="civil_id"
                                                    class="form-control col-md-7 col-xs-12">
                                                @foreach(\App\Report::getCivilOptions() as $key => $civil)
                                                    <option value="{{ $key }}" {{ old('civil_id') == $key ? 'selected' : ""}}> {{ $civil }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nom <span
                                                    class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="name" class="form-control col-md-7 col-xs-12" value="{{old('name')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Prénom<span
                                                    class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="first_name" class="form-control col-md-7 col-xs-12" value="{{old('first_name')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="comp">Société
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="company" class="form-control col-md-7 col-xs-12" value="{{old('company')}}">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Date de Naissance
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="dob" class="form-control col-md-7 col-xs-12" value="{{old('dob')}}">
                                            <p>Date format: (jj/mm/aaaa) </p>
                                        </div>


                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="add" >Adresse Postale
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="pac-input" name="address" class="form-control col-md-7 col-xs-12" value="{{old('address')}}" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">Ville
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="city" name="city" class="form-control col-md-7 col-xs-12" value="{{old('city')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="post_code">Code Postal
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="postal_code" name="postal_code" class="form-control col-md-7 col-xs-12" value="{{old('postal_code')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Adresse Mail
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="email" name="email" class="form-control col-md-7 col-xs-12" value="{{old('email')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mob">Téléphone Mobile
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="mobile" class="form-control col-md-7 col-xs-12" value="{{old('mobile')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Téléphone Fixe
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="phone" class="form-control col-md-7 col-xs-12" value="{{old('phone')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="third_section">
                                    <h1 class="fh1">Raisons d'appel</h1>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="physic">Médecin Concerné
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="physician_id"
                                                    class="form-control col-md-7 col-xs-12">
                                                @foreach(\App\Report::getPhysicianOptions() as $key => $physician)
                                                    <option value="{{ $key }}" {{ old('physician_id') == $key ? 'selected' : ""}}> {{ $physician }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="add">Message
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="reason" class="form-control col-md-7 col-xs-12" rows="5" >{{old('reason')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="physic">Type d'examen
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="exam_id"
                                                    class="form-control col-md-7 col-xs-12">
                                                @foreach(\App\Report::getExamOptions() as $key => $exam)
                                                    <option value="{{ $key }}" {{ old('exam_id') == $key ? 'selected' : ""}}> {{ $exam }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="physic">Urgence
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <!-- <select required="required" name="emergency_id"
                                                    class="form-control col-md-7 col-xs-12">
                                                {{--@foreach(\App\Report::getEmergencyOptions() as $key => $emergency)
                                                    <option value="{{ $key }}" {{ old('emergency_id') == $key ? 'selected' : ""}}> {{ $emergency }}</option>
                                                @endforeach--}}
                                            </select> -->
                                            <input type="checkbox" name="emergency_id" value="1"> Oui
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="physic">Tentative
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  name="attempt"
                                                    class="form-control col-md-7 col-xs-12">
                                               <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                                </div>    
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 report_btn">
                                       {{-- <a class="btn btn-warning" type="button"
                                           href="{{ url('/reports') }}">Cancel</a>
                                        <button class="btn btn-primary" type="reset">Reset</button>--}}
                                        <button type="submit" class="btn btn-success" name="status_submit" value="status_submit">Valider</button>
                                        <button type="submit" class="btn btn-warning" name="status_call" value="status_call">Appel Interrompu</button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOHjLVDgGV6Ww3XAqU44BzFEY00otrndQ&libraries=places&callback=initAutocomplete" async defer></script>
    <script>
        $(".datepicker").datepicker({format: "dd-mm-yyyy", autoclose: true, endDate: new Date()});

    </script>

    <script>
        /*function initAutocomplete() {
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            /!*map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);*!/
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                for (var i = 0; i < place.address_components.length; i++) {
                    if(place.address_components[i].types[0] == 'postal_code'){
                        var post_code = place.address_components[i].long_name;
                        $('#postal_code').val(post_code);
                    }
                    if(place.address_components[i].types[0] == 'locality'){
                        var city = place.address_components[i].long_name;
                        $('#city').val(city);
                    }
                    /!*if(place.address_components[i].types[0] == 'country'){
                        var country = place.address_components[i].long_name;
                        $('#country').val(country);
                    }*!/
                }
            });
        }*/
    </script>
@endsection