@extends('layouts.app')

@section('content')


    <md-toolbar  md-theme-watch class="md-warn md-hue-3" layout="row" layout-align="center center">
        <h2>
            <span>
                {{ $channelInfo->name }}
            </span>
        </h2>
    </md-toolbar>

    <div layout="row" layout-align="center" class="layoutSingleColumn" >

        <div flex="100" flex-gt-xs="60">

            <md-tabs md-dynamic-height md-border-bottom>

                <md-tab label="@{{ 'KEY_MSTVIEW_TDAY' | translate }}">

                    @include('layouts.topic_listing_card', ['topics' => $topics])

                </md-tab>

                <md-tab label="@{{ 'KEY_NO_ANSWER' | translate }}">

                    @include('layouts.topic_listing_card', ['topics' => $noAnswers])

                </md-tab>

            </md-tabs>

        </div>

        {{-- LEFT SIDE CHANNEL AND USER CARD, HIDE ON XS --}}
        <div flex hide-xs="true">
            @include('layouts.tag_listing', ['tags' => $tagsTrending])
        </div>
    </div>
@endsection