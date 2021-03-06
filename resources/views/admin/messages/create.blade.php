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
                        <div class="x_title"
                             style="border-bottom: 0px white !important; margin-bottom: -30px!important;">
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
                                  method="post" action="{{ route('message.send.email') }}">
                                {!! csrf_field() !!}
                                <div class="first_section">
                                    {{--<h1 class="fh1" >Centre Médical</h1>--}}
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Client<span
                                                    class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="client_id"
                                                    class="form-control col-md-7 col-xs-12" id="clients_select">
                                                <option value=""> -- Select Client --</option>
                                                @if(!empty($clients))
                                                    @foreach($clients as $key=>$client)
                                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : ""}} data-name="{{ $client->name }}"> {{ $client->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Civilité
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">

                                            <select name="civil_id"
                                                    class="form-control col-md-7 col-xs-12">
                                                <option value="">N/C</option>
                                                <option value="M.">M.</option>
                                                <option value="Mme">Mme.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="agent_id" value="{{ \Auth::user()->id }}">
                                    <input type="hidden" name="client_name" value="" id="client_name">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Nom
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="name" class="form-control col-md-7 col-xs-12"
                                                   value="{{old('name')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Prénom
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="last_name" class="form-control col-md-7 col-xs-12"
                                                   value="{{old('last_name')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Date
                                            de Naissance
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="dob" class="form-control col-md-7 col-xs-12"
                                                   value="{{old('dob')}}">
                                            <p>Date format: (jj/mm/aaaa) </p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="add">Adresse
                                            Postale
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="pac-input" name="address"
                                                   class="form-control col-md-7 col-xs-12" value="{{old('address')}}"
                                                   placeholder="">
                                        </div>
                                    </div>

                                    {{--<div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="post_code">Code
                                            Postal
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="postal_code" name="postal_code"
                                                   class="form-control col-md-7 col-xs-12"
                                                   value="{{old('postal_code')}}">
                                        </div>
                                    </div>--}}

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="post_code">Complément d'adresse
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="complete_address"
                                                   class="form-control col-md-7 col-xs-12"
                                                   value="{{old('complete_address')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mob">Numéro de
                                            téléphone
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="mobile" class="form-control col-md-7 col-xs-12"
                                                   value="{{old('mobile')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mob">Numéro de
                                            fax
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="fax" class="form-control col-md-7 col-xs-12"
                                                   value="{{old('fax')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mob">Adresse e-mail
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="email" name="to_email" class="form-control col-md-7 col-xs-12"
                                                   value="{{old('to_email')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mob">Numéro de
                                            sécurité sociale
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="security" class="form-control col-md-7 col-xs-12"
                                                   value="{{old('security')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mob">Type d'examen
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="exam" class="form-control col-md-7 col-xs-12"
                                                   value="{{old('exam')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mob">Date de l'examen
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="dateexam" class="form-control col-md-7 col-xs-12"
                                                   value="{{old('dateexam')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>

                                <div class="third_section">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mob">Object du
                                            mail
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="email_subject"
                                                   class="form-control col-md-7 col-xs-12"
                                                   value="{{old('email_subject')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="add">Message
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="message_body" class="form-control col-md-7 col-xs-12"
                                                      rows="5">{{old('message_body')}}</textarea>
                                        </div>
                                    </div>


                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 report_btn">
                                            <button type="submit" class="btn btn-success" name="mail_submit"
                                                    value="mail_submit">Valider
                                            </button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9BslwF5YsiVo0euSXCtyeue6wz4j299g&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script>
        $(".datepicker").datepicker({format: "dd-mm-yyyy", autoclose: true, endDate: new Date()});

    </script>

    <script>

        $(document).ready(function () {


            $('#demo-form2').on('keyup keypress', function (e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            $("#clients_select").change(function(){
                var selectedClient = $("#clients_select option:selected").attr('data-name');
                $('#client_name').val(selectedClient);
            });

            //console.log(( "#clients_select option:selected" ).val());

        });

        function initAutocomplete() {
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            //maps.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                //debugger;
                //alert(place);
                for (var i = 0; i < place.address_components.length; i++) {
                    if (place.address_components[i].types[0] == 'postal_code') {
                        var post_code = place.address_components[i].long_name;
                        $('#postal_code').val(post_code);
                    }
                    if(place.address_components[i].types[0] == 'locality'){
                     var city = place.address_components[i].long_name;
                     $('#city').val(city);
                     }
                }

                var fulladdress = $('#pac-input').val();
                if(typeof post_code != "undefined"){
                    var match = fulladdress.match(post_code+" "+city);
                    if(match == null) {
                        fulladdress = fulladdress.replace(city, post_code + " " + city);
                    }
                }
                $('#pac-input').val(fulladdress);

            });
        }
    </script>
@endsection