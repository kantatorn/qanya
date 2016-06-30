@extends('layouts.app')

@section('content')
    <div layout="row" layout-align="center" class="layoutSingleColumn_compact md-padding" ng-controller="QuestionCtrl as questionCtrl" ng-cloak="">

        <div flex="100" flex-gt-xs="70">

            <md-content class="md-padding">

            {{--{{ print_r($answer) }}--}}

                <div>
                    <span class="md-caption">ตอบในคำถาม</span>
                    <p class="md-body-1">
                        <a href="/question/{{ $answer->topic_uuid }}">
                            {{  strip_tags ($answer->topic) }}
                        </a>
                    </p>

                    <md-divider></md-divider>

                    {{-- ABOUT AUTHOR--}}
                    <md-content>
                        <md-list flex>
                            {{--<md-subheader class="md-no-sticky">3 line item (with hover)</md-subheader>--}}
                            <md-list-item class="md-3-line">
                                <img src="{{ $answer->avatar }}"
                                     class="md-avatar"
                                     alt="k" />
                                <div class="md-list-item-text" layout="column">
                                    <h3>
                                        <a href="/profile/{{ $answer->displayname }}">
                                            {{ $answer->firstname }} {{ $answer->lastname }}
                                        </a>
                                    </h3>



                                    <h4>

                                        @{{ 'KEY_VIEW' | translate }}
                                        {{  $answer->views }}

                                        ·
                                        <b>{{ strip_tags($answer->expert_title) }}</b>
                                        <i>{{ strip_tags($answer->expert_text) }}</i>

                                    </h4>
                                    <p>@{{ 'KEY_FOLLOWER' | translate }} {{ $answer->followers }}</p>
                                </div>

                                <div class="md-secondary">
                                    @if(Auth::user())
                                        @if(Auth::user()->uuid != $answer->user_uuid)
                                        <md-button class="md-raised">
                                            @{{ 'KEY_FOLLOW' | translate }}</md-button>
                                        @endif
                                    @endif
                                </div>
                            </md-list-item>
                        </md-list>
                    </md-content>
                    {{-- END ABOUT AUTHOR--}}

                    <h1 class="md-title reading">
                        {!! clean($answer->body)  !!}
                    </h1>

                    <div layout="row">

                        {{-- ACTIONABLE BUTTONS--}}
                        <div>

                            {{-- Up vote --}}
                            @if(Auth::user())
                                <md-button ng-click="questionCtrl.questionUpvote('{{ $answer->uuid }}')"
                                           ng-init="questionCtrl.upvoteStatus('{{ $answer->uuid }}')">
                            @else
                                <md-button class="md-primary" aria-label="More" ng-href="/login">
                            @endif

                                <span ng-if="questionCtrl.upvoteStatusText" class="green-font md-padding">
                                    <md-icon class="green-font">
                                        <i class="material-icons md-18">thumb_up</i>
                                    </md-icon>
                                    @{{ 'KEY_UPVOTED' | translate  }}
                                </span>

                                <span ng-if="!questionCtrl.upvoteStatusText">
                                    <md-icon>
                                        <i class="material-icons md-inactive md-18">thumb_up</i>
                                    </md-icon>
                                    @{{ 'KEY_UPVOTE' | translate  }}
                                </span>
                                </md-button>


                            {{-- Down vote--}}
                            @if(Auth::user())
                            <md-button  ng-click="questionCtrl.questionDownvote('{{ $answer->uuid }}')"
                                        ng-init="questionCtrl.downvoteStatus('{{ $answer->uuid }}')"
                                        class="md-inactive">
                            @else

                                <md-button class="md-primary" aria-label="More" ng-href="/login">

                            @endif

                                        <span ng-if="questionCtrl.downvoteStatusText" class="green-font md-padding">
                            <md-icon class="green-font">
                                <i class="material-icons md-18">thumb_down</i>
                            </md-icon>
                                                                        @{{ 'KEY_DWN_VOTED' | translate  }}
                        </span>

                        <span ng-if="!questionCtrl.downvoteStatusText">
                              <md-icon>
                                  <i class="material-icons md-inactive md-18">thumb_down</i>
                              </md-icon>
                            @{{ 'KEY_DWN_VOTE' | translate  }}
                        </span>
                                                                </md-button>


                        </div>
                        {{-- END ACTIONABLE BUTTONS --}}

                        <span flex></span>
                        {{ \Carbon\Carbon::parse($answer->created_at)->diffForHumans() }}
                    </div>
                </div>

            </md-content>


            {{-- COMMENT--}}
            <div style="padding-top: 20px" ng-controller="AnswerCtrl as answerCtrl" ng-cloak>

                <h1 class="md-title"> @{{ 'KEY_WRT_COMMENT' | translate }}</h1>

                <md-content layout="column" layout-padding>

                    @if(Auth::user())
                    <md-list flex>
                        <md-list-item class="md-3-line">
                            <img src="{{ Auth::user()->avatar }}"
                                 class="md-avatar"
                                 alt="k" />
                            <div flex>
                                <form ng-submit="answerCtrl.commentAnswer('{{ $answer->uuid }}')">
                                    <div class="md-list-item-text" layout="column">
                                        <h3>
                                            <a href="/profile/{{ $answer->displayname }}">
                                                {{ $answer->firstname }} {{ $answer->lastname }}
                                            </a>
                                        </h3>

                                        <h4>
                                            <md-input-container class="md-block">
                                                <label>@{{ 'KEY_WRT_ANSWER' | translate }}</label>
                                                <textarea required
                                                          ng-model="answerCtrl.answer_comment"
                                                          md-maxlength="1000" rows="5"></textarea>
                                            </md-input-container>
                                        </h4>
                                    </div>

                                    <div  layout="row"
                                          layout-align="end center">
                                        <md-button ng-if="answerCtrl.answer_comment"
                                                    type="submit"
                                                    class="md-raised md-hue-1 md-mini">
                                                    @{{ 'KEY_POST' | translate }}</md-button>
                                    </div>
                                </form>
                            </div>

                        </md-list-item>

                        @else
                            <md-button> @{{ 'KEY_LOGIN_REGISTER' | translate }}</md-button>
                        @endif

                    </md-list>


                    {{-- Comment listing --}}
                    <h1 class="md-title"> @{{ 'KEY_COMMENTS' | translate }}</h1>

                    <md-list ng-init="answerCtrl.fetchAnswerReply({{$answer->uuid}})">
                        <md-list-item class="md-3-line md-long-text"
                                      ng-repeat="reply in answerCtrl.answerReplyArr[{{$answer->uuid}}]">
                            {{--@{{ reply }}--}}
                            <img src="@{{reply.avatar}}"
                                 class="md-avatar"
                                 alt="k" />
                            <div layout="row" flex>
                                <div class="md-list-item-text">
                                    <p>
                                    <div class="listing-article">
                                        @{{ reply.body | htmlToPlaintext }}
                                    </div>
                                    </p>

                                    <h4>
                                        <a href="/profile/@{{ reply.displayname }}">
                                            @{{ reply.firstname }}
                                        </a>
                                    </h4>

                                    <p>
                                        @{{ reply.created_at }}
                                    </p>
                                </div>
                            </div>
                        </md-list-item>
                    </md-list>

                    {{-- End comment--}}

                </md-content>

            </div>
            {{-- END COMMENT --}}

        </div>
    </div>
@endsection