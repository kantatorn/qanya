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

                {{-- STATIC CONTENT --}}
                <div layout="row" layout-align="start center">

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


            <div layout-align="start" class="md-padding">

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

            {{-- ANSWER FORM--}}
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

                            <h3>
                                <a href="/profile/{{ $answer->displayname }}">
                                    {{ $answer->firstname }} {{ $answer->lastname }}
                                </a>
                            </h3>

                            <p>test</p>

                            <p>
                                <div class="listing-article">
                                    {{ strip_tags($answer->body) }}
                                </div>
                            </p>

                            <p>
                                {!! \Carbon\Carbon::parse($answer->created_at)->diffForHumans() !!}
                            </p>

                            <div layout="row" ng-controller="AnswerCtrl as answerCtrl">

                                @if(Auth::user())
                                    <md-button class="md-primary"
                                               ng-init="answerCtrl.getAnswerStatus({{ $answer->uuid }},$index)"
                                               ng-click="answerCtrl.upvote({{ $answer->uuid }})">
                                @else
                                    <md-button ng-ref="/login">
                                @endif
                                    เห็นด้วย @{{ answerCtrl.upvoteStatusText[$index] }}
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


            <h4>Trend</h4>
        </div>

    </div>
@endsection