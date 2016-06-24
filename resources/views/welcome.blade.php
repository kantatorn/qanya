@extends('layouts.app')

@section('content')


    <div layout="row" layout-align="center" class="layoutSingleColumn">
        
        <div flex="100" flex-gt-xs="60">

            <md-tabs md-dynamic-height md-border-bottom>

                {{-- If user login show customize feed--}}
                @if(Auth::user())

                <md-tab label="@{{ 'KEY_FOR_YOU' | translate }}">

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

            {{-- USER EXPERTISE CARD--}}
            @include('layouts.user_expertise_card')

            {{-- TRENDING --}}
            @include('layouts.tag_listing', ['tags' => $trendingTags])
            

        </div>

    </div>
@endsection
