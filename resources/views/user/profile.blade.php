@extends('layouts.client_layout')
@section('content')
    <div class="dash_content">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="col-lg-6 col-md-12">
            <div class="My_profile_details">
                <div class="dp">
                    <div class="pf_outer clearfix">
                        <div class="Profile_img_here">
                            @if(\App\SystemFile::getImageUrl($user->userProfile, 'profile_pic'))
                                <img height="120px"
                                     src="{{ \App\SystemFile::getImageUrl($user->userProfile, 'profile_pic')}}">
                            @else
                                <img height="120px" src="{{ asset('images/user-img.jpg') }}">

                            @endif
                        </div>
                        <div class="DP_name">
                            <h2>{{ $user->userProfile->first_name }} {{ $user->userProfile->last_name }}</h2>
                            <a href="" id="edit_dp"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                Profile</a>
                        </div>
                        <div class="Total-Earnings">
                            <p>Total Earnings
                                - {{ isset($user->userProfile->selectedCurrency->code) ? $user->userProfile->selectedCurrency->code : '£'}}
                                559</p>
                        </div>
                    </div>
                    <div id="dp_form_div" class="DP_form pf_block edit_form" style="display:none;">
                        <div class="upload-demo-wrap" style="display:none;">
                            <div id="upload-demo"></div>
                            <button class="upload-result">Upload</button>
                        </div>
                        <form id="dp_form" method="POST" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="text" placeholder="First Name" name="first_name"
                                   value="{{ $user->userProfile->first_name }}" id="first_name" class="form-control"/>
                            <input type="text" placeholder="Last Name" name="last_name"
                                   value="{{ $user->userProfile->last_name }}" id="last_name" class="form-control"/>

                            <div class="choose_box">
                                <input type="file" name="profile_pic" id="file-1" class="inputfile inputfile-1"
                                       data-multiple-caption="{count} files selected"/>
                                <label for="file-1"><span>Choose a file&hellip;</span></label>
                            </div>
                            {{--  <a type="submit" id="submit_dp_form" class="btns"><i class="fa fa-save"></i></a>
                              <a id="cancel_dp_form" class="btns cancel_bt"><i class="fa fa-times"></i></a>--}}
                        </form>
                    </div>
                </div>

                <div class="Profile_content_d">
                    <div class="pf_block" id="basic_details">
                        <div id="all_errors" class="error text-center"></div>
                        <h2>Basic Details <a href="" style="display:none;" id="edit_basic_details"><i
                                        class="fa fa-pencil-square-o"
                                        aria-hidden="true"></i>Edit</a></h2>
                        <ul class="basic_txt clearfix">
                            <li class="email_info"><span class="label">Email</span>
                                <p>{{ $user->email }} </p><i class="fa fa-question" aria-hidden="true"
                                                             title="To change your email please write to support@disclout.com."></i>
                            </li>
                            <li><span class="label">Phone</span>
                                <p id="phone_num_data">{{ $user->userProfile->phone_num }}</p></li>
                            <li><span class="label">SSN</span>
                                <p id="ssn_data">{{ $user->userProfile->ssn }}</p></li>
                            <li><span class="label">DOB</span>
                                <p id="dob_data">{{ $user->userProfile->dob }}</p></li>
                            <li><span class="label">Preferred Currency</span>
                                <p id="currency_data"><span
                                            class="text_editor">{{ isset($user->userProfile->selectedCurrency->currency) ? $user->userProfile->selectedCurrency->currency : "" }}</span>
                                </p></li>
                        </ul>
                        <div id="basic_details_form_div" class="DP_form edit_form" style="display:none;">

                            {!! Form::open(['class' => 'form-horizontal user-form', 'id' => 'basic_details_form']) !!}
                            {!! csrf_field() !!}
                            <p class="disable_field"><input type="text" placeholder="Email" name="email"
                                                            value="{{ $user->email }}" id="email" class="form-control"
                                                            disabled/>
                                <span><i class="fa fa-question"
                                         title="To change your email please write to support@disclout.com."></i> </span>
                            </p>
                            <input type="text" placeholder="Phone Number" name="phone_num"
                                   value="{{ $user->userProfile->phone_num }}" id="phone_num" class="form-control"/>
                            <span id="phone_num_error" class="error"></span>
                            <input type="text" placeholder="SSN" name="ssn"
                                   value="{{ $user->userProfile->ssn }}" id="ssn" class="form-control"/>
                            <span id="ssn_error" class="error"></span>

                            <input type="text" placeholder="DOB" name="dob"
                                   value="{{ $user->userProfile->dob }}" id="ssn" class="form-control datepicker"/>
                            <span id="dob_error" class="error"></span>
                            {!! Form::select('currency', ['' => 'Select Currency'] + \App\UserProfile::getCurrencyOptions() , old('currency', $user->userProfile->currency), ['class'=>'form-control']) !!}
                            {{-- <a type="submit" id="submit_basic_details_form" class="btns"><i class="fa fa-save"></i></a>
                             <a id="cancel_basic_details_form" class="btns cancel_bt"><i class="fa fa-times"></i></a>
 --}}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="pf_block" id="basic_details">
                        <h2>Address <a href="" style="display:none;" id="edit_address"><i class="fa fa-pencil-square-o"
                                                                                          aria-hidden="true"></i>Edit</a>
                        </h2>
                        <ul class="add_data clearfix">
                            <li><span class="label">Address</span>
                                <p id="address_data">{{ @$user->userProfile->address }}</p></li>
                            <li><span class="label">Address2</span>
                                <p id="address2_data">{{ @$user->userProfile->address2 }}</p></li>
                            <li><span class="label">Zip</span>
                                <p id="zip_data">{{ @$user->userProfile->zip }}</p></li>
                            <li><span class="label">City</span>
                                <p id="city_data">{{ @$user->userProfile->city }}</p></li>
                            <li><span class="label">State</span>
                                <p id="state_data">{{ @$user->userProfile->state }}</p></li>
                            <li><span class="label">Country</span>
                                <p id="country_data">{{ @$user->userProfile->selectedCountry->name}}</p>
                            </li>
                        </ul>
                        <div id="address_form_div" class="DP_form edit_form" style="display:none;">
                            {!! Form::open(['class' => 'form-horizontal user-form', 'id' => 'address_form']) !!}
                            {!! csrf_field() !!}
                            <input type="text" placeholder="Address" name="address"
                                   value="{{ $user->userProfile->address }}" id="address" class="form-control"/>
                            <input type="text" placeholder="Address2" name="address2"
                                   value="{{ $user->userProfile->address2 }}" id="address2" class="form-control"/>
                            <input type="text" placeholder="Zip (5 digits only)" name="zip" value="{{ $user->userProfile->zip }}"
                                   id="zip" class="form-control"/>
                            <input type="text" placeholder="City" name="city" value="{{ $user->userProfile->city }}"
                                   id="city" class="form-control"/>
                            <span id="city_error" class="error"></span>
                            <input type="text" placeholder="State (Use 2 uppercase letter abbreviation)" name="state"
                                   value="{{ $user->userProfile->state }}"
                                   id="state" class="form-control"/>

                            <span id="state_error" class="error"></span>
                            {!! Form::select('country', ['' => 'Select Country'] + \App\UserProfile::getCountryOptions() , old('country', $user->userProfile->country), ['class'=>'form-control']) !!}
                            <input type="button" id="submit_address_form" class="btns btn btn-info"
                                   data-loading-text="Save..."
                                   value='Save'>
                           {{-- <a type="submit" id="submit_address_form"  data-loading-text="..." class="btns"><i class="fa fa-save"></i></a>--}}
                            <a id="cancel_address_form" class="btns cancel_bt"><i class="fa fa-times"></i></a>
                            {!! Form::close() !!}
                        </div>
                    </div>


                </div>

            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="Profile_content_d My_profile_details top_mg">
                <div class="pf_block" id="billing_details">
                    <h2>Billing Info<a href="" id="edit_bank_details"><i class="fa fa-pencil-square-o"
                                                                         aria-hidden="true"></i>Edit</a>
                        <a href="" id="cancel_bank_details_form" style="display:none;"><i class="fa fa-times"></i>Cancel</a>
                    </h2>
                    <ul class="bank_data clearfix">
                        <li><span class="label">Bank Name</span>
                            <p><span id="bank_name_data">{{ @$user->fundingSource->bank_name }}</span></p></li>
                        <li><span class="label">Account Name</span>
                            <p><span id="bank_name_data">{{ @$user->fundingSource->account_name }}</span></p></li>
                        <li><span class="label">Bank Account Type</span>
                            <p><span id="bank_name_data">{{ @$user->fundingSource->bank_account_type }}</span></p></li>
                        <li><span class="label">Account Status</span>
                            <p><span id="bank_name_data">{{ @$user->fundingSource->account_status }}</span></p></li>

                        {{--<li><span class="label">IBAN</span>
                            <p><span id="iban_data">{{ $user->userProfile->iban }}</span>
                            <p></li>
                        <li><span class="label">BIC/SWIFT</span>
                            <p><span id="bic_swift_data">{{ $user->userProfile->bic_swift }}</span>
                            <p></li>
                        <li><span class="label">Account Holder Name</span>
                            <p><span id="bank_account_name_data">{{ $user->userProfile->bank_account_name }}</span><p>
                        </li>--}}
                    </ul>
                    <div id="bank_details_form_div" class="DP_form edit_form" style="display:none;">
                        <div id="controls" class="text-center">
                            <input type="button" id="add-bank" class="btn btn-info" id="load"
                                   data-loading-text="Checking Profile..."
                                   value="Add Bank Account">
                        </div>
                        <div id="iavContainer">
                            <div class="text-center error">
                                <h5 id="bank-error"></h5></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social_counter">
                <div class="social_icon">
                    <ul>
                        <li class="facebook">
                            <a href="{{ url('/social-signup') }}">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                <span class="name">Facebook</span>
                                <span class="Followers-count">35.1k</span>
                                <span class="Followers">Followers</span>
                            </a>
                        </li>
                        <li class="twitter">
                            <a href="{{ url('/social-signup') }}">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                <span class="name">Twitter</span>
                                <span class="Followers-count">0</span>
                                <span class="Followers">Followers</span>
                            </a>
                        </li>
                        <li class="youtube">
                            <a href="{{ url('/social-signup') }}">
                                <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                <span class="name">Youtube</span>
                                <span class="Followers-count">0</span>
                                <span class="Followers">Followers</span>
                            </a>
                        </li>
                        <li class="Instagram">
                            <a href="{{ url('/social-signup') }}">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                <span class="name">Instagram</span>
                                <span class="Followers-count">0</span>
                                <span class="Followers">Followers</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="total-Followers">
                    <h4>Total Followers</h4>
                    <span>800</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.dwolla.com/1/dwolla.js"></script>
    <script src="{{ asset('js/iban.js') }}"></script>
    <link rel="stylesheet" href="{{ asset("css/croppie.css") }}"/>
    <script src="{{ asset("js/croppie.js") }}"></script>
    <script type="text/javascript" src="<?php echo(asset('js/admin_dist/bootstrap-datepicker.js')); ?>"></script>
    <script type="text/javascript">
        var end_date = new Date().getFullYear() - 18;
        $(".datepicker").datepicker({format: "yyyy-mm-dd", autoclose: true, endDate: "-18y"});
        $(document).ready(function () {
            $("#add-bank").click(function () {
                $(this).button('loading');
                $.ajax({
                    url: "{{ url('funding-source/'.$user->id.'/iav-token') }}",
                    type: "GET",
                    success: function (response) {
                        $("#add-bank").button('reset');
                        $("#bank-error").html("");
                        if (typeof response.error != 'undefined') {
                            $("#bank-error").html(response.error);
                        } else {
                            $("#add-bank").hide();
                            var iavToken = response.token;
                            dwolla.configure('sandbox');
                            dwolla.iav.start(iavToken, {
                                container: 'iavContainer',
                                microDeposits: false,
                                fallbackToMicroDeposits: true
                            }, function (err, res) {
                                if (typeof  res._links != 'undefined') {
                                    res['_token'] = '{{ csrf_token() }}';
                                    $.ajax({
                                        url: "{{ url('funding-source/'.$user->id.'/ajax-create') }}",
                                        type: "POST",
                                        data: res,
                                        success: function (response) {
                                            $("#add-bank").button('reset');
                                            if (response = 'success') {
                                                alert('Successfully Added funding source');
                                                location.reload();
                                            } else {
                                                alert('Something went wrong');
                                                location.reload();
                                            }
                                        },
                                        error: function () {
                                            $("#bank-error").html("Please try again");
                                        }
                                    });
                                } else {
                                    alert(JSON.stringify(err));
                                }
                                console.log('Error: ' + JSON.stringify(err) + ' -- Response: ' + JSON.stringify(res))
                            });
                        }
                    },
                    error: function () {
                        $("#bank-error").html("Please try again");
                        $(this).button('reset');
                    }
                });
            });

            $('.submenu_1').click(function () {
                $('ul.dp_menu_1').toggle('slow');
                $('ul.dp_menu_2').hide('slow');
                $('.icon_f1').toggleClass('fa-chevron-right');
                $('.icon_f1').addClass('fa-chevron-down');
                $('.icon_f2').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                $(this).addClass('active');
                $('.submenu_2').removeClass('active');
            });

            $('.submenu_2').click(function () {
                $('ul.dp_menu_2').toggle('slow');
                $('ul.dp_menu_1').hide('slow');
                $('.icon_f2').toggleClass('fa-chevron-down');
                $('.icon_f1').removeClass('fa-chevron-down').addClass('fa-chevron-right');
                $(this).addClass('active');
                $('.submenu_1').removeClass('active');
            });

            jQuery('.toggle_menu_slide').click(function () {
                jQuery("body").addClass('open_menu');
            });
            jQuery(document).on('click', '.remove_menu', function () {
                jQuery("body").removeClass('open_menu');
            });

            var oriVal;
            $(".editbtn").on('click', function () {
                var me = $(this).prev('.text_editor');
                oriVal = me.text();
                me.text("");
                var name = $(this).attr('name');
                console.log('name' + name);

                $("<input type='text' name='" + name + "' id='" + name + "_id'> ").appendTo(me).focus();
            });
            $(".Profile_content_d p").on('focusout', 'input', function () {
                var $this = $(this);
            });

            $(document).delegate($("input[id^=user_]"), 'change', function () {

                console.log('val' + $(this).attr('id'));
                /* var val = $(this).val();

                 var attr = $(this).attr('name').split("user_")[1];
                 update(attr, val);*/
            });

            function update(attr, val) {
                var data = {attr: val, '_token': "{{ csrf_token() }}"};
                $.ajax({
                    url: "{{ url('profile/update') }}",
                    type: "POST",
                    data: data,
                    success: function (res) {
                        $(".Profile_content_d p").parent().text(res.val);
                        $(".Profile_content_d p").remove(); // Don't just hide, remove the element.
                    }
                })
            }

            $("#edit_dp").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                $("#dp_form_div").toggle();
                $("#edit_basic_details").trigger('click');
                $("#edit_address").trigger('click');

            });

            $("#submit_dp_form").click(function () {
                var formData = new FormData($("#dp_form")[0]);
                var id = "dp_form"
                updateForm(formData, id);
            });
            $("#cancel_dp_form").click(function () {
                $("#dp_form_div").hide();
            })

            $("#edit_basic_details").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                $("#basic_details_form_div").toggle();
                $(".basic_txt").toggle();
            });

            $("#submit_basic_details_form").click(function () {
                var formData = new FormData($("#basic_details_form")[0]);
                var id = "basic_details_form";
                var div = 'basic_txt';
                updateForm(formData, id, div);
            });
            $("#cancel_basic_details_form").click(function () {
                $("#basic_details_form_div").hide();
                $(".basic_txt").show();
            })

            $("#edit_address").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                $("#address_form_div").toggle();
                $(".add_data").toggle();
            });

            $("#submit_address_form").click(function () {
                $(this).button('loading');
                $("#submit_address_form").attr('disabled', 'disabled');
                $("#submit_address_form").attr('value', "Save...");
                var formData = new FormData($("#dp_form")[0]);// with the file input
                var basic_formData = $(document.forms['basic_details_form']).serializeArray();

                for (var i = 0; i < basic_formData.length; i++) {
                    formData.append(basic_formData[i].name, basic_formData[i].value);
                }
                var add_formData = $(document.forms['address_form']).serializeArray();

                for (var i = 0; i < add_formData.length; i++) {
                    formData.append(add_formData[i].name, add_formData[i].value);
                }
                var id = "address_form";
                var div = 'add_data';
                updateForm(formData, id, div);
            });
            $("#cancel_address_form").click(function () {
                $("#basic_details_form_div").hide();
                $(".basic_txt").show();
                $("#address_form_div").hide();
                $("#dp_form_div").hide();
                $(".add_data").show();
            })


            $("#edit_bank_details").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                $("#bank_details_form_div").show();
                $("#cancel_bank_details_form").show();
                $(this).hide();
                $(".bank_data").hide();
                $("#add-bank").show();
            });

            $("#submit_bank_details_form").click(function () {
                var formData = new FormData($("#bank_details_form")[0]);
                var id = "bank_details_form";
                if (IBAN.isValid($("#iban").val())) {
                    var div = 'bank_data';
                    updateForm(formData, id, div);
                } else {
                    $("#iban_error").html('IBAN is not valid').css('color', 'red');
                }
            });
            $("#cancel_bank_details_form").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                $("#bank_details_form_div").hide();
                $(this).hide();
                $(".bank_data").show();
                $("#edit_bank_details").show();
            })

            function updateForm(formData, id, div) {
                $.ajax({
                    url: "{{ url('profile/update') }}",
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (response) {/*
                        $("#submit_address_form").attr('disabled', false);
                        $("#submit_address_form").attr('value', "Save");*/
                        $("#submit_address_form").button('reset');
                        removeErrors();
                        if (typeof response.errors != 'undefined') {
                            console.log('error');
                            updateErrors(response.errors);
                            $(".add_data").hide();
                            $("#address_form_div").show();
                            $(".basic_txt").hide();
                            $("#basic_details_form_div").show();
                            $("#dp_form_div").show();
                        } else {
                            console.log('success');
                            updateFields(response);
                            $(".add_data").show();
                            $("#address_form_div").hide();
                            $(".basic_txt").show();
                            $("#basic_details_form_div").hide();
                            $("#dp_form_div").hide();
                        }
                    },
                    error:function(){
                        $("#submit_address_form").button('reset');/*
                        $("#submit_address_form").attr('disabled', false);
                        $("#submit_address_form").attr('value', "Save");*/
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

            function updateFields(data) {
                data.first_name = data.first_name != null ? data.first_name : "";
                data.last_name = data.last_name != null ? data.last_name : "";
                $(".DP_name").find('h2').html(data.first_name + " " + data.last_name);
                $(".pf-name").html(data.first_name + " " + data.last_name);

                $("#phone_num_data").html(data.phone_num);
                $("#ssn_data").html(data.ssn);
                $("#dob_data").html(data.dob);
                data.selected_currency = data.selected_currency != null ? data.selected_currency : "";
                $("#currency_data").html(data.selected_currency.currency);

                $("#address_data").html(data.address);
                $("#zip_data").html(data.zip);
                $("#city_data").html(data.city);
                $("#address2_data").html(data.address2);
                $("#state_data").html(data.state);

                data.selected_country = data.selected_country != null ? data.selected_country : "";
                $("#country_data").html(data.selected_country.name);

                $("#bank_name_data").html(data.bank_name);
                $("#iban_data").html(data.iban);
                $("#bic_swift_data").html(data.bic_swift);
                $("#bank_account_name_data").html(data.bank_account_name);
            }

            function updateErrors(data) {
                $("#all_errors").html(data.all_errors);
                $("#dob_error").html(data.dob);
                if (typeof data.dob != 'undefined') {
                    $("#dob").addClass('has-error');
                }

                $("#phone_num_error").html(data.phone_num);
                if (typeof data.phone_num != 'undefined') {
                    $("#phone_num").addClass('has-error');
                }
                $("#bank_name_error").html(data.bank_name);
                if (typeof data.bank_name != 'undefined') {
                    $("#bank_name").addClass('has-error');
                }
                $("#bic_swift_error").html(data.bic_swift);
                if (typeof data.bic_swift != 'undefined') {
                    $("#bic_swift").addClass('has-error');
                }
                $("#bank_acount_name_error").html(data.bank_account_name);
                if (typeof data.bank_account_name != 'undefined') {
                    $("#bank_acount_name").addClass('has-error');
                }
                $("#city_error").html(data.city);
                if (typeof data.city != 'undefined') {
                    $("#city").addClass('has-error');
                }

                $("#state_error").html(data.state);
                if (typeof data.state != 'undefined') {
                    $("#state").addClass('has-error');
                }

                $("#ssn_error").html(data.ssn);
                if (typeof data.ssn != 'undefined') {
                    $("#ssn").addClass('has-error');
                }
            }

            function removeErrors(data) {
                $("#all_errors").html("");
                $("#phone_num_error").html("");
                $("#bank_name_error").html("");
                $("#bic_swift_error").html("");
                $("#bank_acount_name_error").html("");
                $("#city_error").html("");
                $("#ssn_error").html("");
                $("#state_error").html("");
                $("#adress2_error").html("");
                $("#phone_num").removeClass("has-error");
                $("#bank_name").removeClass("has-error");
                $("#bic_swift").removeClass("has-error");
                $("#bank_acount_name").removeClass("has-error");
                $("#city").removeClass("has-error");
                $("#ssn").removeClass("has-error");
                $("#state").removeClass("has-error");
            }

            $("#file-1").change(function () {
                showImage(this);
            });


            function showImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.pf_img img').attr('src', e.target.result);
                        $('.Profile_img_here img').attr('src', e.target.result);

                    }

                    reader.readAsDataURL(input.files[0]);

                }
            }

            var $uploadCrop;

            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(".upload-demo-wrap").show();
                        $(".Profile_img_here").hide();
                        $('.upload-demo').addClass('ready');
                        $uploadCrop.croppie('bind', {
                            url: e.target.result
                        }).then(function () {
                            console.log('jQuery bind complete');
                        });

                    }

                    reader.readAsDataURL(input.files[0]);

                }
                else {
                    swal("Sorry - you're browser doesn't support the FileReader API");
                }
            }

            $uploadCrop = $('#upload-demo').croppie({
                viewport: {
                    width: 100,
                    height: 100,
                    type: 'circle'
                },
                enableExif: true
            });

            $('#profile_pic').on('change', function () {
                console.log("sd");
                readFile(this);
            });
            $('.upload-result').on('click', function (ev) {
                console.log("asd");
                $uploadCrop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {
                    if (resp) {
                        html = '<img src="' + resp + '" />';
                    }
                    $(".Profile_img_here").html(html);
                    $("#image_data").val(resp);
                    $("#profile_image_id").submit();
                    console.log("html2" + html);
                    popupResult({
                        src: resp
                    });
                });
            });

            'use strict';

            ;
            ( function (document, window, index) {
                var inputs = document.querySelectorAll('.inputfile');
                Array.prototype.forEach.call(inputs, function (input) {
                    var label = input.nextElementSibling,
                        labelVal = label.innerHTML;

                    input.addEventListener('change', function (e) {
                        var fileName = '';
                        if (this.files && this.files.length > 1)
                            fileName = ( this.getAttribute('data-multiple-caption') || '' ).replace('{count}', this.files.length);
                        else
                            fileName = e.target.value.split('\\').pop();

                        if (fileName)
                            label.querySelector('span').innerHTML = fileName;
                        else
                            label.innerHTML = labelVal;
                    });

                    // Firefox bug fix
                    input.addEventListener('focus', function () {
                        input.classList.add('has-focus');
                    });
                    input.addEventListener('blur', function () {
                        input.classList.remove('has-focus');
                    });
                });
            }(document, window, 0));
        });
    </script>
@endsection