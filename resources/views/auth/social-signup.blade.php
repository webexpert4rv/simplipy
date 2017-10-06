@extends('layouts.client_layout')
@section('content')
    <div class="dash_content">
        <div class="hst_panel">
            <div class="social_sg_block clearfix">
                <h2>Plug in Account</h2>
                <p>You need at least 4000 followers to join.</p>
                <div class="social_plug">
                    @if(\Auth::user()->isLinked('youtube_url') == "")
                        <a href="{{ url('auth/youtube') }}" target="_blank"><img
                                    src="{{ asset('images/youtube_btn_1.png') }}"></a>
                    @endif
                    @if(\Auth::user()->isLinked('facebook_url') == "")
                        <a href="{{ url('auth/facebook') }}" target="_blank"><img
                                    src="{{ asset('images/facebook_btn_1.png') }}"></a>
                    @endif
                    @if(\Auth::user()->isLinked('twitter_token') == "")
                        <a href="{{ url('auth/twitter') }}" target="_blank"><img
                                    src="{{ asset('images/twitter_btn_1.png') }}"></a>
                    @endif
                    @if(\Auth::user()->isLinked('instagram_url') == "")
                        <a href="{{ url('auth/insta') }}" target="_blank"><img
                                    src="{{ asset('images/instagram_btn_1.png') }}"></a>
                    @endif
                </div>
            </div>
            <div>
                @if(\Auth::user()->isLinked('youtube_url') != "")
                    <li class="youtube">

                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                        <span class="name">Youtube</span>
                        <span class="Followers-count">{{ \Auth::user()->userProfile->youtube_subscribers }}</span>
                        <span class="Followers">Followers</span>
                        <a href="{{ url('/auth/youtube') }}"> Refresh Followers </a>

                    </li>
                @endif

                @if(\Auth::user()->isLinked('twitter_token') != "")
                    <li class="youtube">

                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                        <span class="name">Twitter</span>
                        <span class="Followers-count">{{ \Auth::user()->userProfile->twitter_subscribers }}</span>
                        <span class="Followers">Followers</span>
                        <a href="{{ url('/auth/twitter') }}"> Refresh Followers </a>

                    </li>
                @endif
            </div>
        </div>
    </div>


@endsection
