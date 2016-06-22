@extends('layouts.app')

@section('content')


    <div layout="row" layout-align="center" class="layoutSingleColumn">
        
        <div flex="100" flex-gt-xs="60">

            <md-tabs md-dynamic-height md-border-bottom>

                {{-- If user login show customize feed--}}
                @if(Auth::user())

                <md-tab label="@{{ 'KEY_FOR_YOU' | translate }}">

                    {{--@include('layouts.topic_listing', ['topics' => $channelFeed])--}}
                    @include('layouts.topic_listing_card', ['topics' => $channelFeed])

                </md-tab>

                @endif


                {{-- Questions listing --}}
                <md-tab label="@{{ 'KEY_MSTVIEW_TDAY' | translate }}">

                    @include('layouts.topic_listing_card', ['topics' => $topics])

                </md-tab>

                {{-- NO ANSWERS TAB--}}
                <md-tab label="@{{ 'KEY_NO_ANSWER' | translate }}">

                    @include('layouts.topic_listing_card', ['topics' => $noAnswers])

                </md-tab>
            </md-tabs>

        </div>

        {{-- LEFT SIDE CHANNEL AND USER CARD, HIDE ON XS --}}
        <div flex hide-xs="true">

            @if(Auth::user())
                <md-card md-theme="blue" md-theme-watch>
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-title">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }} </span>
                            <span class="md-subhead">{{ '@'.Auth::user()->displayname }}</span>
                        </md-card-title-text>
                        <md-card-title-media>
                            <div class="md-media-sm card-media">
                                <img src="{{ Auth::user()->avatar }}">
                            </div>
                        </md-card-title-media>
                    </md-card-title>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button>Action 1</md-button>
                        <md-button>Action 2</md-button>
                    </md-card-actions>
                </md-card>
            @endif

            {{-- CHANNEL LISTING --}}
            @foreach($channels as $channel)
                <md-button ng-href="/channel/{{ $channel->slug }}">{!! $channel->name !!}</md-button>
            @endforeach


            {{-- TRENDING --}}
            @include('layouts.tag_listing', ['tags' => $trendingTags])
            

        </div>

    </div>
@endsection
