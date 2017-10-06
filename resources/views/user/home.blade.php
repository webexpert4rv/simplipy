@extends('layouts.client_layout')
@section('content')
    <div class="dash_content">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($user->getActiveCampaigns(true) == 0)
            <div class="ExploreCampaigns">
                <a href="{{ url("campaigns/explore") }}">Explore Campaigns</a>
            </div>
        @else
            @foreach($user->getActiveCampaigns() as $campaign)
                <div class="information_block clearfix">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <table class="data_table equal_width">
                            <thead>
                            <tr>
                                <th data-label="5600">Units Left</th>
                                <th data-label="35">USD</th>
                                <th data-label="20%">Discount</th>
                                <th data-label="44">Days Left</th>
                                <th data-label="7">Participating Influencers</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td scope="col">{{ $campaign->campaign->getUnitsLeft() }}</td>
                                <td scope="col">{{ $campaign->campaign->getCurrency(true) }}{{ $campaign->campaign->price }}</td>
                                <td scope="col">{{ $campaign->campaign->getDiscount() }}%</td>
                                <td scope="col">{{ $campaign->daysLeft() }}</td>
                                <td scope="col">{{ $campaign->campaign->influencersCount() }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="product_details">
                            <div class="left_product_img">
                                {!! $campaign->campaign->getImages(true) !!}
                            </div>
                            <div class="right_product_details">
                                <ul class="pD">
                                    <li><span>Product Name :</span> <span class="home_span">{{ $campaign->campaign->title }}</span></li>
                                    <li>
                                        <span>Company Name :</span>  <span class="home_span"> {{ $campaign->campaign->createdBy->userProfile->company_name }}
                                    </li>
                                </ul>
                                <div class="Description clearfix">
                                    <h2>Description :</h2>
                                    <p>{!! $campaign->campaign->description !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 inflex">
                        @if($campaign->status == \App\CampaignRequest::STATUS_PENDING)
                            <a class="inner-btns" href="#">Allocation Request Pending</a>
                        @else
                            <h2 class="heading">You Have</h2>
                            <table class="data_table equal_width">
                                <thead>
                                <tr>
                                    <th data-label="2000">Units Allocated</th>
                                    <th data-label="740">Units Left</th>
                                    <th data-label="5%">Commission</th>
                                    <th data-label="44">Days Left</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $campaign->requested_units }}</td>
                                    <td>{{ $campaign->leftUnits() }}</td>
                                    <td>{{ $campaign->commission }}%</td>
                                    <td>{{ $campaign->daysLeft()}}</td>
                                </tr>

                                </tbody>
                            </table>

                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <h2 class="heading">Your Exclusive Link</h2>
                            <a id="share-url_{{ $campaign->id }}" href="{{ $campaign->getShortUrl() }}">{{ $campaign->getShortUrl() }}</a>
                        @endif
                    </div>

                    <div class="view_campaign"><a href="{{ url('campaigns/'.$campaign->campaign_id) }}">view campaign</a></div>

                </div>
            @endforeach

            @if($user->getActiveCampaigns(true) == 1)
                <div class="ExploreCampaigns">
                    <a href="{{ url('campaigns/explore') }}">Explore Campaigns</a>
                </div>
            @endif
        @endif
    </div>

    <div class="modal fade" id="bookingModal" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Share Url</h4>
                </div>
                <div class="modal-body">
                    <p>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="ui blue btn btn-default modal-close" data-dismiss="modal">Close
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("[id^=share-url_]").click(function(e){
                e.preventDefault();
                e.stopPropagation();
                var id = $(this).attr('id').split('share-url_')[1];
                var share_url = '{{ url('share-url/') }}' + '/' + id;
                $(".modal .modal-body").html("Content loading please wait...");
                $(".modal").modal("show");
                $(".modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                });
                $(".modal .modal-body").load(share_url);
            })

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
        });

        $(document).ready(function () {
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
        });
    </script>
    <script>
        $("#edit_dp").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $("#dp_form_div").toggle();
        });

        $("#submit_dp_form").click(function () {
            var formData = new FormData($("#dp_form")[0]);
            var id = "dp_form"
            update(formData, id);
        });
        $("#cancel_dp_form").click(function () {
            $("#dp_form_div").hide();
        })

        $("#edit_basic_details").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $("#basic_details_form_div").show();
            $(".basic_txt").hide();
        });

        $("#submit_basic_details_form").click(function () {
            var formData = new FormData($("#basic_details_form")[0]);
            var id = "basic_details_form"
            update(formData, id);
            $(".basic_txt").show();
        });
        $("#cancel_basic_details_form").click(function () {
            $("#basic_details_form_div").hide();
            $(".basic_txt").show();
        })

        $("#edit_address").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $("#address_form_div").show();
            $(".add_data").hide();
        });

        $("#submit_address_form").click(function () {
            var formData = new FormData($("#address_form")[0]);
            var id = "address_form"
            update(formData, id);
            $("#address_form_div").hide();
            $(".add_data").show();
        });
        $("#cancel_address_form").click(function () {
            $("#address_form_div").hide();
            $(".add_data").show();
        })


        $("#edit_bank_details").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $("#bank_details_form_div").show();
            $(".bank_data").hide();
        });

        $("#submit_bank_details_form").click(function () {
            var formData = new FormData($("#bank_details_form")[0]);
            var id = "bank_details_form"
            update(formData, id);
            $(".bank_data").show();
            $("#bank_details_form_div").hide();
        });
        $("#cancel_bank_details_form").click(function () {
            $("#bank_details_form_div").hide();
            $(".bank_data").show();
        })

        function update(formData, id) {
            $.ajax({
                url: "{{ url('profile/update') }}",
                type: 'POST',
                data: formData,
                async: false,
                success: function (response) {
                    console.log('response' + response.first_name);
                    updateFields(response);
                    $("#" + id + "_div").hide();
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

            data.selected_currency = data.selected_currency != null ? data.selected_currency : "";
            $("#currency_data").html(data.selected_currency.currency);

            $("#address_data").html(data.address);
            $("#zip_data").html(data.zip);
            $("#city_data").html(data.city);

            data.selected_country = data.selected_country != null ? data.selected_country : "";
            $("#country_data").html(data.selected_country.name);

            $("#bank_name_data").html(data.bank_name);
            $("#iban_data").html(data.iban);
            $("#bic_swift_data").html(data.bic_swift);
            $("#bank_acount_name_data").html(data.bank_account_name);


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
    </script>
    <link rel="stylesheet" href="{{ asset("css/croppie.css") }}"/>
    <script src="{{ asset("js/croppie.js") }}"></script>


    <script>
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

    </script>
@endsection