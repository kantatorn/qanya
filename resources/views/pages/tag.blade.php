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

            <md-card>
                <md-list>
                    <md-subheader class="md-no-sticky md-title">Most Upvote in this tag</md-subheader>

                    @foreach($mostUpvotePerson as $person)
                        <md-list-item class="md-2-line" ng-click="null">
                            <img ng-src="{{ $person->avatar }}" class="md-avatar" alt="{{ $person->displayname }}" />
                            <div class="md-list-item-text" layout="column">
                                <h3>
                                    <a href="/profile/{{ $person->displayname }}">
                                        {{ $person->firstname }}
                                    </a>
                                </h3>
                                <p>{{ $person->text }}</p>
                                <span class="md-secondary"> {{ $person->endorsed }}</span>
                            </div>
                        </md-list-item>
                    @endforeach

                </md-list>
            </md-card>

        </div>

    </div>
@endsection