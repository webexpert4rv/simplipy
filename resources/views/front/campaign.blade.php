@extends('layouts.layout')
@section('meta')
    <meta property="og:title" content="{{ $campaign_request->campaign->title }}"/>
    <meta property="og:image" content="{{ $campaign_request->campaign->getSingleImageUrl() }}"/>
    <meta property="og:description" content="{{ $campaign_request->campaign->description }}"/>
    @endsection
@section('content')
    <div class="campain_main_wrapper">

        <div class="container">

            @if(!isset($error))
                <div class="campain_inner_con">

                    <div class="page_title"> {{ $campaign_request->campaign->title }}</div>
                    <!-- Left Section -->
                    <div class="campain_left">


                        <!-- Campaign Carousel  -->
                        <div class="campaign_carousel_main">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    @foreach($campaign_request->campaign->getImages(false) as $image)
                                        <li data-target="#myCarousel" data-slide-to="{{ $loop->iteration - 0 }}"
                                            class="{{ $loop->iteration - 1 == 0 ? 'active' : '' }}"></li>
                                    @endforeach
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    @foreach($campaign_request->campaign->getImages(false) as $image)
                                        <div class="item {{ $loop->iteration == 1 ? 'active' : '' }}">
                                            @if (strstr($image->content_type, 'video') != false)
                                                <video controls>
                                                    <source src="{{ $image->getUrl()}}"
                                                            type="{{ $image->content_type}}">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <img src="{{ $image->getUrl() }}" alt="/">
                                            @endif
                                        </div>
                                    @endforeach

                                </div>

                                <!-- Left and right controls -->
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <!-- Campaign Carousel end  -->


                        <!-- campain Tab content -->
                        <div class="campain_tabs_content">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#description">Description</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="description" class="tab-pane fade in active">
                                    {!! $campaign_request->campaign->description !!}
                                </div>
                            </div>
                        </div>
                        <!-- campain Tab content end here -->


                    </div>
                    <!-- Left Section end -->


                    <!-- Right Section -->
                    <div class="campain_right">

                        <div class="retailer_list_con">
                            <h2>Product price</h2>

                            <div class="offer_clip"><span>{{ $campaign_request->campaign->getDiscount() }}% off </span>
                            </div>

                            <ul class="proice_listing">
                                <li>
                                    <span class="price">{{ $campaign_request->campaign->getCurrency(true) }}{{ $campaign_request->campaign->price}}</span>
                                    <span class="old_price">{{ $campaign_request->campaign->getCurrency(true) }}{{ $campaign_request->campaign->retail_price}}</span>
                                </li>
                            </ul>

                            <div class="button_con">
                                <a class="btn_campaign" href="#">Buy Now</a>
                            </div>
                        </div>

                        <div class="retailer_list_con">
                            <h2>Retailer web page</h2>
                            <div class="button_con">
                                <a class="btn_campaign" target="_blank"
                                   href="http://{{ $campaign_request->campaign->product_retail_webpage }}">Click
                                    here</a>
                            </div>
                        </div>

                        <div class="retailer_list_con">
                            <h2>Profile Details</h2>
                            <ul class="pro_listing">
                                <li>
                                    <div class="pro_img_sec">
                                        @if(\App\SystemFile::getImageUrl($campaign_request->influencer->userProfile, 'profile_pic'))
                                            <img height="120px"
                                                 src="{{ \App\SystemFile::getImageUrl($campaign_request->influencer->userProfile, 'profile_pic')}}">
                                        @else
                                            <img height="120px" src="{{ asset('images/user-img.jpg') }}">
                                        @endif{{--
									<img src="https://nrgedge-static.s3.amazonaws.com/static/signup/oil-platform-bg.png" alt="Los Angeles">--}}
                                    </div>
                                    <div class="pro_cont_sec">
                                        <h2 class="title">{{ $campaign_request->influencer->userProfile->first_name.' '.$campaign_request->influencer->userProfile->last_name }}</h2>
                                        <h3 class="last_active"> Member
                                            since:</strong> {{ \App\Settings::getDate($campaign_request->influencer->created_at, 'jS F, Y') }}</h3>
                                        <h4 class="active">Last
                                            active: {{ $campaign_request->influencer->isOnline() }}</h4>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- Right Section end -->

                </div>
            @else
                <div class="campain_inner_con">
                    <div class="retailer_list_con">
                        <h4 class="text-center"><b>{!! $error !!}</b></h4>
                        @if(isset($retail_webpage))
                            <div class="button_con">
                                <a target="_blank" class="btn_campaign" href="http://{{ $retail_webpage }}">Retailer's
                                    Web Page</a>
                            </div>
                        @endif
                    </div>

                </div>
            @endif
        </div>
    </div>

@endsection