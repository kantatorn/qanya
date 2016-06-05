@extends('layouts.app')

@section('content')
    <div layout="row" layout-align="center" class="layoutSingleColumn_compact md-padding" ng-controller="QuestionCtrl as questionCtrl" ng-cloak="">

        <div flex="100" flex-gt-xs="70">

            {{--{{ print_r($topic) }}--}}

            <md-chips class="md-primary md-hue-1">
                @foreach(explode(",",$topic->tags) as $tag)
                    <md-chip>
                        <a href="/tag/{{$tag}}">
                            {{ $tag }}
                        </a>
                    </md-chip>
                @endforeach
            </md-chips>

            {{-- Layout after the topic header --}}
            <div class="md-padding">

                <div layout="row">
                    <a href="/channel/{{$topic->channel_slug}}">
                        {{$topic->channel_name}}
                    </a>
                    <span flex></span>
                    {!! \Carbon\Carbon::parse($topic->created_at)->diffForHumans() !!}
                </div>

                <h1 class="md-display-1">
                    {{  strip_tags ($topic->topic) }}
                </h1>

                <div layout="row" layout-align="start center">

                    @{{ 'KEY_VIEW' | translate }}

                    {{ $topic->views }}

                    {{-- Want to know the answer--}}
                    @if(Auth::user())
                        <md-button class="md-primary" aria-label=" @{{ 'KEY_WNT_TO_KNOW' | translate }}"
                                   ng-click="questionCtrl.followQuestion('{{$topic->uuid}}')">
                    @else
                        <md-button class="md-primary" aria-label="More" ng-href="/login">
                    @endif
                            <span>@{{ questionCtrl.followStatus }}</span>
                            @{{ 'KEY_WNT_TO_KNOW' | translate }} {{ $topic->follow }}
                        </md-button>

                    <md-button class="md-icon-button">
                        <md-icon md-svg-icon="/icons/ic_create_black_24px.svg"></md-icon>
                        <span>
                            @{{ 'KEY_UPVOTE' | translate }}
                        </span>
                    </md-button>
                    <md-button>@{{ 'KEY_DWN_VOTE' | translate }}</md-button>
                </div>
            </div>


            <div layout-align="start" class="md-padding">

                <h1 class="md-headline">
                    คุณตอบคำถามนี้ได้ไหม?
                </h1>
                มีคน {{ $topic->follow }} คนรอคำตอบอยู่


                @if(Auth::user())
                <md-button class="md-primary" aria-label="More" ng-click="questionCtrl.answerForm = true">
                    <md-icon md-svg-icon="/icons/ic_create_black_24px.svg"></md-icon>
                    @{{ 'KEY_REPLY' | translate }}
                </md-button>
                @else
                    <md-button class="md-primary" aria-label="More" ng-href="/login">
                        @{{ 'KEY_REPLY' | translate }}
                    </md-button>
                @endif

{{--
                <md-button class="md-accent">
                    @{{ 'KEY_REPLY' | translate }}
                </md-button>
--}}

            </div>


            @if(Auth::user())

                    <md-card class="md-padding" ng-show="questionCtrl.answerForm" ng-init="questionCtrl.answerForm = false">

                        <md-card-header>
                            <md-card-avatar>
                                <img class="md-user-avatar" src="https://scontent.fbkk8-1.fna.fbcdn.net/v/t1.0-1/p160x160/3768_10156694116535179_601632126662207422_n.jpg?oh=6da6cc0c3a2381aa4cff9a7a8e246547&oe=57C31D82"/>
                            </md-card-avatar>
                            <md-card-header-text>
                                <span class="md-title">
                                    {{ Auth::user()->firstname }}
                                    {{ Auth::user()->lastname }}
                                </span>
                                <span class="md-subhead">
                                    @{{ questionCtrl.userExpertTopic }}
                                    @{{ questionCtrl.userExpertTopicText }} ( 100 เห็นด้วย)
                                    <md-button class="md-primary md-mini" ng-click="questionCtrl.userExpertiseShow = true">
                                        ใส่ประสบการณ์
                                    </md-button>
                                </span>
                            </md-card-header-text>
                        </md-card-header>

                        {{-- User Expertise --}}
                        <md-content layout-padding ng-model="questionCtrl.userExpertise"
                                    ng-init="questionCtrl.userExpertiseShow = false"
                                    ng-show="questionCtrl.userExpertiseShow">
                            <md-card-actions layout="row" layout-align="start center">

                                <md-input-container class="md-block">
                                    <md-select ng-model="questionCtrl.userExpertTopic">
                                        @foreach(explode(",",$topic->tags) as $tag)
                                            <md-option value="{{$tag}}">
                                                {{$tag}}
                                            </md-option>
                                        @endforeach
                                    </md-select>
                                </md-input-container>

                                <md-input-container class="md-block" flex-gt-sm>
                                    <label>@{{ 'KEY_DETAILS' | translate }}</label>
                                    <input autocomplete="off"
                                           md-maxlength="80" required md-no-asterisk
                                           name="question_topic"
                                           ng-model="questionCtrl.userExpertTopicText">
                                </md-input-container>

                                <md-button ng-click="questionCtrl.userExpertiseSave()">@{{ 'KEY_SAVE' | translate }}</md-button>

                            </md-card-actions>
                        </md-content>

                        <md-input-container class="md-block">
                            <label>@{{ 'KEY_WRT_ANSWER' | translate }}</label>
                            <textarea required
                                      ng-model="questionCtrl.answer_text" md-maxlength="1000" rows="5"></textarea>
                        </md-input-container>

                        <md-button  type="submit"
                                    ng-show="questionCtrl.answer_text.length"
                                    ng-disabled="questionCtrl.answerBtnStatus"
                                    class="md-accent md-raised"
                                    ng-click="questionCtrl.answer_submit('{{$topic->uuid}}');
                                              questionCtrl.answerBtnStatus=true">
                                    @{{ 'KEY_REPLY' | translate }}</md-button>
                    </md-card>
            @endif


            <md-divider></md-divider>

            {{-- ANSWERS SECTION --}}
            <md-content class="md-padding">

                <h1 class="md-title">
                   {{ count($answers) }} @{{ 'KEY_ANSWER' | translate }}
                </h1>

                @foreach($answers as $answer)

                    {{--{{ print_r($answer) }}--}}

                    <md-list-item class="md-3-line md-long-text">
                        <img ng-src="https://scontent.fbkk8-1.fna.fbcdn.net/v/t1.0-1/p160x160/3768_10156694116535179_601632126662207422_n.jpg?oh=6da6cc0c3a2381aa4cff9a7a8e246547&oe=57C31D82" class="md-avatar" alt="user" />
                        <div class="md-list-item-text">

                            <h3>{{ $answer->firstname }} {{ $answer->lastname }}</h3>

                            <p>test</p>

                            <p>
                                <div class="listing-article">
                                    {{ strip_tags($answer->body) }}
                                </div>
                            </p>

                            <p>
                                {!! \Carbon\Carbon::parse($answer->created_at)->diffForHumans() !!}
                            </p>

                            <div layout="row">
                                <md-button class="md-primary md-raised">
                                    เห็นด้วย | 10
                                </md-button>
                                <md-button class="md-primary">
                                  โหวดลง
                                </md-button>
                                <md-button class="md-primary" ng-href="/answer/{{ $answer->uuid }}">
                                    @{{ 'KEY_REPLY' | translate }}
                                </md-button>
                                <span flex></span>
                            </div>
                        </div>
                    </md-list-item>
                @endforeach
            <md-content>

        </div>

        <div hide-xs="true" class="md-padding" flex layout="column">

            <md-content layout-align="center center">

                <md-list flex>
                    <md-subheader class="md-no-sticky md-title">คำถามคล้ายๆกัน</md-subheader>
                    @foreach($similar_topics as $s_topic)
                        <md-list-item>
                            <div class="md-list-item-text" layout="column">
                                <p class="md-body-2">
                                    <a href="/question/{{ $s_topic->uuid }}">
                                        {{  strip_tags ($s_topic->topic) }}
                                    </a>
{{--                                    {!! \Carbon\Carbon::parse($s_topic->created_at)->diffForHumans() !!}--}}
                                </p>
                            </div>
                        </md-list-item>
                    @endforeach
                </md-list>

                <i class="fa fa-trophy" aria-hidden="true"></i>
            </md-content>

        </div>

    </div>
@endsection