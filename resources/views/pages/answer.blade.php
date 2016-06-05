@extends('layouts.app')

@section('content')
    <div layout="row" layout-align="center" class="layoutSingleColumn_compact md-padding" ng-controller="QuestionCtrl as questionCtrl" ng-cloak="">

        <div flex="100" flex-gt-xs="70">

            {{--{{ print_r($answer) }}--}}
            <md-card class="md-padding">
                <div>
                    <span>ตอบในคำถาม</span>
                    <p class="md-body">
                        <a href="/question/{{ $answer->topic_uuid }}">
                            {{  strip_tags ($answer->topic) }}
                        </a>
                    </p>

                    <h1 class="md-title reading">
                        &quot;
                        {{  strip_tags ($answer->body) }}
                        &quot;
                    </h1>

                    view
                    {{  $answer->views }}
                    up
                    {{  $answer->upvote }}
                    down
                    {{  $answer->downvote }}

                    {{ \Carbon\Carbon::parse($answer->created_at)->diffForHumans() }}
                </div>


                {{-- ABOUT AUTHOR SECTION --}}
                <div style="padding-top: 20px" class="md-padding">
                    <h1 class="md-title">
                        @{{ 'KEY_ABT_AUTHOR' | translate }}
                    </h1>

                    <md-divider ></md-divider>

                    <md-content>
                        <md-list flex>
                            {{--<md-subheader class="md-no-sticky">3 line item (with hover)</md-subheader>--}}
                            <md-list-item class="md-3-line">
                                <img src="https://scontent.fbkk8-1.fna.fbcdn.net/v/t1.0-1/p160x160/3768_10156694116535179_601632126662207422_n.jpg?oh=6da6cc0c3a2381aa4cff9a7a8e246547&oe=57C31D82"
                                     class="md-avatar"
                                     alt="k" />
                                <div class="md-list-item-text" layout="column">
                                    <h3>
                                        <a href="/profile/{{ $answer->displayname }}">
                                            {{ $answer->firstname }} {{ $answer->lastname }}
                                        </a>
                                    </h3>

                                    <h4>สนใจในเรื่อง
                                        @foreach($user_expertise as $expertise)
                                            <a href="{{ strip_tags($expertise->slug) }}">
                                                {{ strip_tags($expertise->title) }}
                                            </a>
                                        @endforeach
                                    </h4>
                                    <p>@{{ 'KEY_FOLLOWER' | translate }} {{ $answer->followers }}</p>
                                </div>

                                <div class="md-secondary">
                                    <md-button class="md-raised">@{{ 'KEY_FOLLOW' | translate }}</md-button>
                                </div>
                            </md-list-item>
                        </md-list>
                    </md-content>
                </div>
                {{-- END ABOUT AUTHOR--}}
            </md-card>


            {{-- COMMENT--}}
            <div style="padding-top: 20px" class="md-padding" ng-controller="QuestionCtrl as questionCtrl" ng-cloak>

                <h1 class="md-title"> @{{ 'KEY_WRT_COMMENT' | translate }}</h1>

                <md-content layout="column">

                    @if(Auth::user())
                    <md-list flex>
                        <md-list-item class="md-3-line">
                            <img src="https://scontent.fbkk8-1.fna.fbcdn.net/v/t1.0-1/p160x160/3768_10156694116535179_601632126662207422_n.jpg?oh=6da6cc0c3a2381aa4cff9a7a8e246547&oe=57C31D82"
                                 class="md-avatar"
                                 alt="k" />
                            <div flex>
                                <form ng-submit="questionCtrl.commentAnswer('{{ $answer->uuid }}')">
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
                                                          ng-model="questionCtrl.answer_comment"
                                                          md-maxlength="1000" rows="5"></textarea>
                                            </md-input-container>
                                        </h4>
                                    </div>

                                    <div  layout="row"
                                          layout-align="end center">
                                        <md-button ng-if="questionCtrl.answer_comment"
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
                    <md-list flex>
                        @foreach($comments as $comment)
                            <md-list-item class="md-3-line md-long-text">
                                <img src="https://scontent.fbkk8-1.fna.fbcdn.net/v/t1.0-1/p160x160/3768_10156694116535179_601632126662207422_n.jpg?oh=6da6cc0c3a2381aa4cff9a7a8e246547&oe=57C31D82"
                                     class="md-avatar"
                                     alt="k" />
                                <div layout="row" flex>
                                    <div class="md-list-item-text">
                                        <p>
                                            <div class="listing-article">
                                                {{ strip_tags($comment->body) }}
                                            </div>
                                        </p>

                                        <h4>
                                            <a href="/profile/{{ $comment->displayname }}">
                                                {{ $comment->firstname }} {{ $comment->lastname }}
                                            </a>
                                        </h4>

                                        <p>
                                            {!! \Carbon\Carbon::parse($comment->created_at)->diffForHumans() !!}
                                        </p>
                                    </div>
                                </div>
                            </md-list-item>
                        @endforeach
                    </md-list>
                    {{-- End comment--}}

                </md-content>

            </div>
            {{-- END COMMENT --}}

        </div>
    </div>
@endsection