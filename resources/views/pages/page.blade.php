@extends('layouts.app')

@section('content')
    <div layout="row" layout-align="center" class="layoutSingleColumn_compact md-padding" ng-controller="QuestionCtrl as questionCtrl" ng-cloak="">

        <div flex="100" flex-gt-xs="70">

            <md-content class="md-padding">
            {{--{{ print_r($topic) }}--}}

            {{-- TAGS CHIPS --}}
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

                <h1 class="md-headline">
                    {{  strip_tags ($topic->topic) }}
                </h1>

                <p class="md-body-1">
                    {!!  clean($topic->text)  !!}
                </p>


            </div>


            <div layout="row" layout-align="start" class="md-padding" >

                <div flex>
                    <h1 class="md-headline">
                        @{{ 'KEY_CAN_YOU_ANSWER' | translate }}
                    </h1>
                    มีคน {{ $topic->follow }} คนรอคำตอบอยู่


                    @if(Auth::user())
                    <md-button aria-label="@{{ 'KEY_REPLY' | translate }}"
                               ng-click="questionCtrl.answerForm = true">

                        <md-icon>
                            <i class="material-icons md-inactive">create</i>
                        </md-icon>

                        @{{ 'KEY_REPLY' | translate }}


                    </md-button>
                    @else
                        <md-button class="md-primary" aria-label="More" ng-href="/login">
                            @{{ 'KEY_REPLY' | translate }}
                        </md-button>
                    @endif
                </div>

                {{-- STATIC CONTENT --}}
                <div layout="column" layout-align="start">

                    <span flex>
                        @{{ 'KEY_VIEW' | translate }}
                        {{ $topic->views }}
                    </span>

                    <span flex ng-init="questionCtrl.getUpvoteCount({{ $topic->upvote }})">
                        @{{ 'KEY_UPVOTE' | translate }}
                        @{{ questionCtrl.upvoteCount }}
                    </span>

                    {{-- Downvote --}}
                    <span flex ng-init="questionCtrl.getDownvoteCount({{ $topic->downvote }})">
                        @{{ 'KEY_DWN_VOTE' | translate }}
                        @{{ questionCtrl.downvoteCount }}
                    </span>

                    {{-- Following--}}
                    <span flex>@{{ 'KEY_FOLLOWING' | translate }} {{ $topic->follow }}</span>

                </div>
                {{-- END STATIC CONTENT --}}

            </div>

            {{-- ANSWER CARD--}}
            @include('layouts.answer_card',['topic' => $topic]);


            {{-- ACTIONABLE BUTTONS--}}
            <div>

                {{-- Following the answer--}}
                @if(Auth::user())
                    <md-button ng-init="questionCtrl.getFollowStatus('{{ $topic->uuid }}')"
                               aria-label=" @{{ 'KEY_WNT_TO_KNOW' | translate }}"
                               ng-click="questionCtrl.followQuestion('{{ $topic->uuid }}')">
                @else
                    <md-button class="md-primary" aria-label="More" ng-href="/login">
                @endif
                        <span ng-if="questionCtrl.followStatusText" class="green-font">
                            <md-icon class="green-font">
                                <i class="material-icons">grade</i>
                            </md-icon>
                            @{{ 'KEY_FOLLOWING' | translate  }}
                        </span>

                        <span ng-if="!questionCtrl.followStatusText">
                            <md-icon>
                                <i class="material-icons md-inactive">grade</i>
                            </md-icon>
                            @{{ 'KEY_WNT_TO_KNOW' | translate  }}
                        </span>

                    </md-button>


                {{-- Up vote --}}
                @if(Auth::user())
                    <md-button ng-click="questionCtrl.questionUpvote('{{ $topic->uuid }}')"
                               ng-init="questionCtrl.upvoteStatus('{{ $topic->uuid }}')">
                @else

                    <md-button class="md-primary" aria-label="More" ng-href="/login">

                @endif

                        <span ng-if="questionCtrl.upvoteStatusText" class="green-font md-padding">
                             <md-icon class="green-font">
                                 <i class="material-icons">thumb_up</i>
                             </md-icon>
                            @{{ 'KEY_UPVOTED' | translate  }}
                        </span>

                        <span ng-if="!questionCtrl.upvoteStatusText">
                            <md-icon>
                                <i class="material-icons md-inactive">thumb_up</i>
                            </md-icon>
                            @{{ 'KEY_UPVOTE' | translate  }}
                        </span>
                    </md-button>


                {{-- Down vote--}}
                @if(Auth::user())
                    <md-button  ng-click="questionCtrl.questionDownvote('{{ $topic->uuid }}')"
                                ng-init="questionCtrl.downvoteStatus('{{ $topic->uuid }}')"
                                class="md-inactive">
                @else

                    <md-button class="md-primary" aria-label="More" ng-href="/login">

                @endif

                        <span ng-if="questionCtrl.downvoteStatusText" class="green-font md-padding">
                            <md-icon class="green-font">
                                <i class="material-icons">thumb_down</i>
                            </md-icon>
                            @{{ 'KEY_DWN_VOTED' | translate  }}
                        </span>

                        <span ng-if="!questionCtrl.downvoteStatusText">
                              <md-icon>
                                  <i class="material-icons md-inactive">thumb_down</i>
                              </md-icon>
                            @{{ 'KEY_DWN_VOTE' | translate  }}
                        </span>
                    </md-button>


            </div>
            {{-- END ACTIONABLE BUTTONS --}}



            </md-content>

            <md-divider></md-divider>

            {{-- ANSWERS SECTION --}}
            <md-content class="md-padding">

                <h1 class="md-title">
                   {{ count($answers) }} @{{ 'KEY_ANSWER' | translate }}
                </h1>

                @foreach($answers as $answer)

                    {{--{{ print_r($answer) }}--}}

                    <md-list-item class="md-3-line md-long-text">
                        <img ng-src="{{ $answer->avatar }}" class="md-avatar" alt="user" />
                        <div class="md-list-item-text">

                            <h3>
                                <a href="/profile/{{ $answer->displayname }}">
                                    {{ $answer->firstname }} {{ $answer->lastname }}
                                </a>
                            </h3>

                            <p>
                                @{{ 'KEY_VIEW' | translate }} {{ $answer->views }}
                            </p>

                            <p class="md-body-1">
                                {!! clean($answer->body) !!}
                                <span class="md-caption">
                                    {!! \Carbon\Carbon::parse($answer->created_at)->diffForHumans() !!}
                                </span>
                            </p>


                            {{-- ANSWER ACTIONABLE BUTTONS --}}
                            @include('layouts.answer_action_btn',['answer' => $answer])

                        </div>
                    </md-list-item>
                @endforeach
            <md-content>
        </div>

        {{-- RIGHT SIDE --}}
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


            <h4>Trend</h4>
        </div>

    </div>
@endsection