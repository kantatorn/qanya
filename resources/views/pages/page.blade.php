@extends('layouts.app')

@section('content')
    <div layout="row" layout-align="center" class="layoutSingleColumn_compact md-padding" ng-controller="QuestionCtrl as questionCtrl" ng-cloak="">

        <div flex="100" flex-gt-xs="70">

            <md-content class="md-padding">

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

                    <br>

                    <h1 class="md-headline">
                        {{  strip_tags ($topic->topic) }}
                    </h1>

                    <div class="contentRead">
                        <p class="gray-font">
                            {!!  clean($topic->text)  !!}
                        </p>
                    </div>

                </div>

            <md-divider></md-divider>


            {{-- CAN YOU ANSWER AND STAT --}}
            <div layout="row" layout-xs="column" layout-align="start" class="md-padding" >

                <div flex layout="column" layout-align="center center">

                    <h1 class="md-title">
                        @{{ 'KEY_CAN_YOU_ANSWER' | translate }}
                    </h1>

                    มีคน {{ $topic->follow }} คนรอคำตอบอยู่

                    <md-button
                        aria-label="@{{ 'KEY_REPLY' | translate }}"
                        @if(Auth::user())
                            ng-click="questionCtrl.answerForm = true"
                        @else
                            ng-href="/login"
                        @endif
                            class="md-primary md-mini md-raised">
                        <md-icon>
                            <i class="material-icons">create</i>
                        </md-icon>
                        @{{ 'KEY_REPLY' | translate }}
                    </md-button>

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
            @include('layouts.answer_card',['topic' => $topic])

            <md-divider></md-divider>

            {{--
            ACTIONABLE BUTTONS
            UPVOTE, DOWNVOTE AND FOLLOW
            --}}
            <div layout-padding>

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


            {{-- ANSWERS SECTION --}}

                <h1 class="md-title" layout-padding="">
                   {{ count($answers) }} @{{ 'KEY_ANSWER' | translate }}
                </h1>

                @foreach($answers as $key=>$answer)

                    {{--{{ print_r($answer) }}--}}

                    <md-card>

                        <md-card-header>
                            <md-card-avatar>
                                <img class="md-user-avatar" ng-src="{{ $answer->avatar }}"/>
                            </md-card-avatar>
                            <md-card-header-text>
                                <b class="md-caption">@{{ 'KEY_COMMENTS_NUM' | translate }} {{ $key + 1 }} </b>
                                <span class="md-title">
                                    <a href="/profile/{{ $answer->displayname }}">
                                        {{ $answer->firstname }} {{ $answer->lastname }}
                                    </a>
                                    ·
                                     <span class="md-caption">
                                        {!! \Carbon\Carbon::parse($answer->created_at)->diffForHumans() !!}
                                    </span>
                                </span>
                                @if($answer->expert_title)

                                    <span class="md-subhead">
                                    <a href="/tag/{{ strip_tags($answer->expert_title) }}">
                                        <b>
                                            #{{ strip_tags($answer->expert_title) }}
                                            ( {{$answer->expert_endorsed}} )
                                        </b>
                                    </a>
                                    <i>·{{ strip_tags($answer->expert_text) }}</i>

                                    </span>

                                @endif

                            </md-card-header-text>

                            <md-menu ng-controller="UserCtrl as userCtrl">
                                <md-button class="md-icon-button md-secondary" aria-label="More"
                                           ng-click="userCtrl.openMenu($mdOpenMenu, $event)">
                                    <i class="material-icons md-14">more_vert</i>
                                </md-button>
                                <md-menu-content width="4">
                                    <md-menu-item>REPORT</md-menu-item>
                                    <md-menu-item>
                                        <md-button>
                                            เป็นแสปม
                                        </md-button>
                                    </md-menu-item>

                                    <md-menu-item>
                                        <md-button>
                                            มีเนื้อหาก้าวร้าวหรือให้ร้าย
                                        </md-button>
                                    </md-menu-item>

                                    <md-menu-item>
                                        <md-button>
                                            Other
                                        </md-button>
                                    </md-menu-item>
                                </md-menu-content>
                            </md-menu>
                        </md-card-header>

                        {{--<md-card-title>
                            <md-card-title-text>
                                <span class="md-headline">In-card mixed actions</span>
                                <span class="md-subhead">Reversed</span>
                            </md-card-title-text>
                        </md-card-title>--}}

                        <md-card-content>

                            {!! clean($answer->body) !!}

                        </md-card-content>

                        {{-- ANSWER ACTIONABLE BUTTONS --}}
                        @include('layouts.answer_action_btn',['answer' => $answer])



                    </md-card>


                    {{--<md-list-item class="md-3-line md-padding">

                        <img ng-src="{{ $answer->avatar }}" class="md-avatar" alt="user" />

                        <div class="md-list-item-text" flex>
                            <b class="md-caption">@{{ 'KEY_COMMENTS_NUM' | translate }} {{ $key + 1 }} </b>
                            <h3>
                                <span class="md-caption">
                                    <a href="/profile/{{ $answer->displayname }}">
                                        {{ $answer->firstname }} {{ $answer->lastname }}
                                    </a>
                                </span>

                                ·

                                 <span class="md-caption">
                                    {!! \Carbon\Carbon::parse($answer->created_at)->diffForHumans() !!}
                                </span>
                            </h3>

                            @if($answer->expert_title)
                            <p>
                                <span class="md-caption">
                                    <a href="/tag/{{ strip_tags($answer->expert_title) }}">
                                        <b>
                                            #{{ strip_tags($answer->expert_title) }}
                                            ( {{$answer->expert_endorsed}} )
                                        </b>
                                    </a>
                                    <i>-{{ strip_tags($answer->expert_text) }}</i>

                                </span>
                            </p>
                            @endif

                            <div class="contentRead">
                                <p style="padding-top:15px">
                                    --}}{{--<span class="md-headline">--}}{{--
                                    {!! clean($answer->body) !!}
                                    --}}{{--</span>--}}{{--
                                </p>
                            </div>

                            --}}{{-- ANSWER ACTIONABLE BUTTONS --}}{{--
                            @include('layouts.answer_action_btn',['answer' => $answer])

                        </div>
                    </md-list-item>

                    <md-divider></md-divider>--}}

                @endforeach

        </div>

        {{-- RIGHT SIDE --}}
        <div hide-xs="true" flex layout="column" layout-margin>

            <md-content layout-align="center center" layout-margin>

                <md-list>
                    <md-subheader class="md-no-sticky md-title">
                        @{{ 'KEY_SIMILAR_Q' | translate }}
                    </md-subheader>
                    @foreach($similar_topics as $s_topic)
                        <md-list-item>
                            <div class="md-list-item-text" layout="column">
                                <p class="md-body-1">
                                    <a href="/question/{{ $s_topic->uuid }}">
                                        {{  strip_tags ($s_topic->topic) }}
                                    </a>
                                </p>
                            </div>
                        </md-list-item>
                    @endforeach
                </md-list>

            </md-content>


            <md-content layout-align="center center" layout-margin>

                <md-list>
                    <md-subheader class="md-no-sticky md-title">

                        @{{ 'KEY_INTEREST_TAG_IN' | translate }}
                        <a href="/channel/{{$topic->channel_slug}}">
                            {{$topic->channel_name}}
                        </a>


                    </md-subheader>

                    @foreach($tagsChannel as $tag)
                        <md-list-item>
                            <div class="md-list-item-text" layout="column">
                                <p class="md-body-1">
                                    <a href="/tag/{{ strip_tags($tag->title) }}">
                                        #{{ strip_tags($tag->title) }}
                                    </a>
                                </p>
                                <span class="md-secondary"> {{ $tag->tag_count }}</span>
                            </div>
                        </md-list-item>
                    @endforeach

                </md-list>
            </md-content>

        </div>

    </div>
@endsection