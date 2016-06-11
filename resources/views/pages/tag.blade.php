@extends('layouts.app')

@section('content')


    <md-toolbar md-theme="blue-grey" md-theme-watch class="md-accent" layout="row" layout-align="center center">
        <h2>
            <span>
                #{{ $tag }}
            </span>
        </h2>
    </md-toolbar>

    <div layout="row" layout-align="center" class="layoutSingleColumn" >

        <div flex="100" flex-gt-xs="60">

            <md-content>
                <md-list flex>
                    @include('layouts.topic_listing', ['topics' => $topics])
                </md-list>
            </md-content>

        </div>


        <div flex hide-xs="true">

            @include('layouts.tag_listing', ['tags' => $trendingTags])

        </div>

    </div>
@endsection