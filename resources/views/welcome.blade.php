@extends('layouts.app')

@section('content')


    <div layout="row" layout-align="center" class="layoutSingleColumn">
        
        <div flex="100" flex-gt-xs="70">

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
            

            <md-content layout-padding>
                <p class="md-caption">
                    © 2016 Qanya
                    <br>
                        <a href="https://qanya.com/answer/1467475643">เกี่ยวกับเรา</a>
                    <br>
                    <a href="https://qanya.com/question/1467190947">ข้อตกลงในการใช้</a>
                    <br>
                    <a href="mailto:admin@qanya.com?Subject=Hello%20Qanya" target="_top">
                    ติดต่อ: </a>
                </p>
            </md-content>
        </div>

    </div>
@endsection
