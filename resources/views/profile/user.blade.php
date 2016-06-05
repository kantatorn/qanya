@extends('layouts.app')

@section('content')
    <div layout="column" layout-align="center" class="layoutSingleColumn_compact md-padding" ng-controller="QuestionCtrl as questionCtrl" ng-cloak="">

        <div flex layout="row">

            <div flex="100" flex-gt-xs="50">

                <md-toolbar layout="row" class="md-hue-3">
                    <div class="md-toolbar-tools">
                        <span>Add what you know</span>
                    </div>
                </md-toolbar>

                {{-- Add what you know / interested --}}
                <div class="md-block" flex layout="solumn" ng-controller="UserCtrl as userCtrl">
                    <form ng-submit="userCtrl.addExpertise()">
                        <md-input-container class="md-block">
                            <label>Name</label>
                            <input ng-model="userCtrl.expertise" type="text" autocomplete="off">
                        </md-input-container>

                        <md-input-container class="md-block" ng-if="userCtrl.expertise">
                            <label>details</label>
                            <textarea ng-model="userCtrl.expertise_body"
                                      md-maxlength="150" rows="5"
                                      placeholder="optional"
                                      md-select-on-focus></textarea>
                        </md-input-container>

                        <md-button class="md-primary md-block" type="submit">
                            <md-icon md-svg-src="/icons/ic_send_black_24px.svg"></md-icon>
                        </md-button>
                    </form>
                </div>

                    <md-list flex>
                        <md-subheader class="md-no-sticky">What topics do you know about?</md-subheader>
                        <md-list-item class="md-3-line" ng-click="null">
                            {{--<img ng-src="{{item.face}}?{{$index}}" class="md-avatar" alt="{{item.who}}" />--}}
                            <div class="md-list-item-text" layout="column">
                                <h3>1</h3>
                                <h4>two</h4>
                                <p>three</p>
                                <div class="md-secondary">test</div>
                            </div>
                        </md-list-item>
                    </md-list>
                </md-content>
            </div>

            <div hide-xs="true" flex layout="column">

                <md-input-container class="md-block" flex-gt-sm>
                    <label>Add workplace</label>
                    <input ng-model="user.firstName">
                </md-input-container>

                <md-input-container class="md-block" flex-gt-sm>
                    <label>Add Education</label>
                    <input ng-model="user.firstName">
                </md-input-container>

                <md-input-container class="md-block" flex-gt-sm>
                    <label>Add Location</label>
                    <input ng-model="user.firstName">
                </md-input-container>
            </div>
        </div>

        <div flex layout="row">
            <div flex="100" flex-gt-xs="70">

                {{--{{ print_r($user) }}--}}

                <md-content>
                    <h1 class="md-headline"> {{ $user->firstname }} {{ $user->lastname }}</h1>

                    {{-- QUESTIONS --}}
                    <md-tabs md-dynamic-height md-border-bottom>
                        <md-tab label="@{{ 'KEY_QUESTION' | translate }} {{ $user->questions }}">
                            <md-content>
                                <md-list flex>
                                    @foreach($user_questions as $user_question)
                                        <md-list-item class="md-3-line" ng-click="null" ng-href="/question/{{ $user_question->uuid }}">
                                            {{--<img ng-src="{{item.face}}?{{$index}}" class="md-avatar" alt="{{item.who}}" />--}}
                                            <div class="md-list-item-text" layout="column">
                                                <h3>
                                                    <a href="/question/{{ $user_question->uuid }}">
                                                        {{ strip_tags($user_question->topic) }}
                                                    </a>
                                                </h3>
                                                <h4>
                                                    <a href="/channel/{{ $user_question->channel_slug }}">
                                                        {{ $user_question->channel_name }}
                                                    </a>
                                                </h4>
                                                <p>
                                                    @{{ 'KEY_ANSWER' | translate }} {{ $user_question->answer }}
                                                    @{{ 'KEY_WNT_TO_KNOW' | translate }} {{ $user_question->follow }}
                                                    @{{ 'KEY_VIEW' | translate }} {{ $user_question->views }}

                                                    {!! \Carbon\Carbon::parse($user_question->created_at)->diffForHumans() !!}
                                                </p>
                                            </div>
                                        </md-list-item>
                                    @endforeach
                                </md-list>
                            </md-content>
                        </md-tab>

                        {{-- ANSWERS --}}
                        <md-tab label="@{{ 'KEY_ANSWER' | translate }}">
                            <md-content class="md-padding">
                                @foreach($user_answers as $answer)
                                    {{--{{ print_r($answer) }}--}}
                                    <md-list-item class="md-3-line" ng-click="null" ng-href="/answer/{{ $answer->uuid }}">
                                        {{--<img ng-src="{{item.face}}?{{$index}}" class="md-avatar" alt="{{item.who}}" />--}}
                                        <div class="md-list-item-text" layout="column">
                                            <h1 class="md-headline">
                                                <span class="md-caption">Question</span>
                                                {{ strip_tags($answer->topic) }}
                                            </h1>
                                            <h3 class="md-title">
                                                <span class="md-caption">Answer</span>
                                                <a href="/answer/{{ $answer->uuid }}" target="_blank">
                                                    {{ strip_tags($answer->body) }}
                                                </a>
                                            </h3>
                                            <p>
                                                @{{ 'KEY_UPVOTE' | translate }} {{ $answer->upvote }}
                                                @{{ 'KEY_DWN_VOTED' | translate }} {{ $answer->downvote }}
                                                @{{ 'KEY_VIEW' | translate }} {{ $answer->views }}

                                                {!! \Carbon\Carbon::parse($user_question->created_at)->diffForHumans() !!}
                                            </p>
                                        </div>
                                    </md-list-item>
                                @endforeach
                            </md-content>
                        </md-tab>
                        <md-tab label="@{{ 'KEY_FOLLOWER' | translate }}">
                            <md-content class="md-padding">
                                <h1 class="md-display-2">Tab Two</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla venenatis ante augue. Phasellus volutpat neque ac dui mattis vulputate. Etiam consequat aliquam cursus. In sodales pretium ultrices. Maecenas lectus est, sollicitudin consectetur felis nec, feugiat ultricies mi.</p>
                            </md-content>
                        </md-tab>
                    </md-tabs>
                </md-content>
            </div>

            <div hide-xs="true" class="md-padding" flex layout="column">

                @{{ 'KEY_INTEREST_IN' | translate }}

                <md-content  ng-controller="UserCtrl as userCtrl">
                    <md-list flex>
                        @foreach($user_expertise as $expertise)
                            <md-list-item>
                                <div class="md-list-item-text" layout="column">
                                    <a href="/tag/{{ strip_tags($expertise->slug) }}">
                                        {{ strip_tags( $expertise->title) }}
                                    </a>
                                    <div class="md-secondary">
                                        <md-button class="md-raised" ng-click="showActionToast()">
                                            X
                                        </md-button>
                                    </div>
                                </div>
                            </md-list-item>
                        @endforeach
                    </md-list>
                </md-content>
            </div>
        </div>
    </div>

@endsection