@extends('layouts.app')

@section('content')
    <div layout="column" layout-align="center" class="layoutSingleColumn_compact md-padding" ng-controller="QuestionCtrl as questionCtrl" ng-cloak="">

        <div flex layout="row">
            <div flex="100" flex-gt-xs="70" ng-controller="UserCtrl as userCtrl">

                {{--{{ print_r($user) }}--}}

                <md-content>

                    <div layout-align="center center" layout="column">

                        <img src="{{ $user->avatar}}"
                             id="profilePhoto"
                             class="img-fluid img-circle"
                             width="150px">

                        <div flex>
                            <a href="/profile/{{ $user->displayname }}">
                                {{ $user->firstname }} {{ $user->lastname }}

                            </a> | {{ '@'.$user->displayname }}

                            <p>
                                <span> {{ $user->description }}</span>
                            </p>
                        </div>

                        @if($IS_USER)

                            {{-- Other user menu--}}
                            <md-menu>

                                <md-button aria-label="menu" class="md-icon-button"
                                           ng-click="$mdOpenMenu($event)">
                                    <i class="material-icons">more_horiz</i>
                                </md-button>

                                <md-menu-content width="4" layout="column" layout-align="center center" >

                                    {{-- CHANGE PROFILE IMG --}}
                                    <md-menu-item>
                                        <div flow-init
                                             flow-name="uploader.flow"
                                             flow-files-added="userCtrl.addProfileImage($files)">
                                            <md-button flow-btn type="file" name="image">
                                                @{{ 'KEY_UPLOAD_PHOTO' | translate }}
                                            </md-button>
                                        </div>
                                    </md-menu-item>

                                    {{-- EDTI / SETTING --}}
                                    <md-menu-item>
                                        <md-button class="" ng-href="{{ $user->displayname }}/edit">
                                            @{{ 'KEY_SETTING' | translate }}
                                        </md-button>
                                    </md-menu-item>

                                    {{-- LOGOUT --}}
                                    <md-menu-item>
                                        <md-button ng-href="/logout">
                                            @{{ 'KEY_LOGOUT' | translate }}
                                        </md-button>
                                    </md-menu-item>

                                </md-menu-content>

                            </md-menu>

                        @endif


                    </div>


                    {{-- QUESTIONS --}}
                    <md-tabs md-dynamic-height md-border-bottom>

                        <md-tab label="@{{ 'KEY_QUESTION' | translate }} {{ $user->questions }}">

                            @include('layouts.topic_listing_card', ['topics' => $user_questions])

                        </md-tab>

                        {{-- ANSWERS --}}
                        <md-tab label="@{{ 'KEY_ANSWER' | translate }} {{ $user->answers }}">
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

                                                {!! \Carbon\Carbon::parse($answer->created_at)->diffForHumans() !!}
                                            </p>
                                        </div>
                                    </md-list-item>
                                @endforeach
                            </md-content>
                        </md-tab>

                        {{-- FOLLOWERS --}}
                        <md-tab label="@{{ 'KEY_FOLLOWER' | translate }} {{ $user->followers }}">
                            <md-content class="md-padding">
                                <h1 class="md-display-2">Tab Two</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla venenatis ante augue. Phasellus volutpat neque ac dui mattis vulputate. Etiam consequat aliquam cursus. In sodales pretium ultrices. Maecenas lectus est, sollicitudin consectetur felis nec, feugiat ultricies mi.</p>
                            </md-content>
                        </md-tab>
                    </md-tabs>
                </md-content>
            </div>

            <div hide-xs="true" class="md-padding" flex layout="column">

                {{-- Add what you know / interested --}}
                @if(Auth::user())
                <div class="md-block" flex layout="solumn" ng-controller="UserCtrl as userCtrl">
                    <form ng-submit="userCtrl.addExpertise('{{ Auth::user()->uuid }}')">
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
                @endif

                @{{ 'KEY_INTEREST_IN' | translate }}

                <div ng-controller="UserCtrl as userCtrl"
                     ng-init="userCtrl.expertiseList('{{  $user->uuid }}')">

                    <user-expertise data="userCtrl.expertiseArray"></user-expertise>

                </div>
            </div>
        </div>
    </div>

@endsection