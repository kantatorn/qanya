{{-- LISTING TOPICS CARD --}}

@foreach($topics as $topic)

    <md-card layout="row" ng-controller="QuestionCtrl as questionCtrl">
        {{--{{ print_r($topic) }}--}}

        <div layout="column" layout-align="start center" >

            <md-button aria-label="@{{ 'KEY_UPVOTE' | translate }}"
                       ng-click="questionCtrl.questionUpvote({{$topic->uuid}});
                                 questionCtrl.upvoteListing[{{ $topic->uuid }}] = 'green-font-1';
                                 questionCtrl.downvoteListing[{{ $topic->uuid }}] = ''">
                <md-icon>
                    <i  ng-class="questionCtrl.upvoteListing[{{ $topic->uuid }}]"
                        ng-init="questionCtrl.voteHighlight('{{ $topic->uuid }}','{{$topic->voteActivity}}')"
                        class="material-icons md-36">expand_less</i>
                </md-icon>
            </md-button>

            {{-- TALLY --}}
            <span
                ng-init="questionCtrl.voteTallyCalc({{$topic->upvote }},{{  $topic->downvote}}, {{ $topic->uuid }})"
                class="md-display-1"
                layout-align="center center">
                {{ questionCtrl.voteTally['<?php echo  $topic->uuid?>'] }}
            </span>

            <md-button aria-label="@{{ 'KEY_DWN_VOTE' | translate }}"
                       ng-click="questionCtrl.questionDownvote({{$topic->uuid}});
                                 questionCtrl.downvoteListing[{{ $topic->uuid }}] = 'green-font-1';
                                 questionCtrl.upvoteListing[{{ $topic->uuid }}] = ''">
                <md-icon>
                    <i ng-class="questionCtrl.downvoteListing[{{ $topic->uuid }}]"
                       ng-init="questionCtrl.voteHighlight('{{ $topic->uuid }}','{{$topic->voteActivity}}')"
                       class="material-icons md-36">expand_more</i>
                </md-icon>
            </md-button>

        </div>

        <div layout="column">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-title">
                        <a href="/question/{{$topic->uuid}}">
                            {{ strip_tags($topic->topic) }}
                        </a>
                    </span>
                    <span class="md-subhead">
                        @{{ 'KEY_VIEW' | translate }}  {{ $topic->views }}
                        ·
                        @{{ 'KEY_WNT_TO_KNOW' | translate }}  {{ $topic->follow }}
                        ·
                        @{{ 'KEY_ANSWER' | translate }}  {{ $topic->answer }}
                        ·
                        <a href="/channel/{{ $topic->channel_slug }}" class="md-secondary">
                            {{ $topic->channel_name }}
                        </a>

                    </span>
                </md-card-title-text>
            </md-card-title>


            <md-card-content>

                {{--<p class="md-body-1">

                    {!! str_limit(clean($topic->text),250) !!}

                    <a href="/profile/{{ $topic->displayname }}">
                        {{ '@'.$topic->displayname }}
                    </a>
                </p>--}}

                <div>
                    @if($topic->tags != null)
                        @foreach(explode(",",$topic->tags) as $tag)
                            <a href="/tag/{{$tag}}">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    @endif
                </div>

            </md-card-content>


        </div>
    </md-card>

@endforeach