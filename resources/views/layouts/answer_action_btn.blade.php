{{--

ACTIONABLE BUTTON FOR ANSWERS

FOR: UPVOTE, DOWNVOTE, GO TO LANDING ANSWER LANDING PAGE

--}}

<div layout="row" layout-align="start center" ng-controller="AnswerCtrl as answerCtrl">

{{--    {{ print_r($answer) }}--}}

    {{-- UPVOTE --}}
    <md-button ng-init="answerCtrl.upvoteClass('{{$answer->voteActivity}}',{{$answer->uuid}})"

            {{-- what button should do when click--}}
            @if(Auth::user())
                ng-click="answerCtrl.upvote({{ $answer->uuid }});
                          answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]=''"
            @else
                ng-href="/login"
            @endif

            ng-class="answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]">

            <md-icon ng-class="answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]" flex>
                 <i class="material-icons md-18">thumb_up</i>
            </md-icon>

            <span>
                {{ $answer->upvote }}
            </span>
            {{--@{{ 'KEY_UPVOTE' | translate  }}--}}

    </md-button>


    {{-- DOWNVOTE --}}
    <md-button ng-init="answerCtrl.downvoteClass('{{$answer->voteActivity}}',{{$answer->uuid}})"

            {{-- what button should do when click--}}
            @if(Auth::user())
                ng-click="answerCtrl.downvote({{ $answer->uuid }});
                          answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]=''"
            @else
            ng-href="/login"
            @endif

            ng-class="answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]">

        <md-icon ng-class="answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]">
            <i class="material-icons md-18">thumb_down</i>
        </md-icon>

         <span>
                {{ $answer->downvote }}
             {{--@{{ 'KEY_UPVOTE' | translate  }}--}}
            </span>
{{--        @{{ 'KEY_DWN_VOTE' | translate  }}--}}
    </md-button>


    <md-button ng-href="/answer/{{ $answer->uuid }}" class="md-subhead md-mini">
        <md-icon>
            <i class="material-icons md-18">question_answer</i>
        </md-icon>
        @{{ 'KEY_TALKBOUT_ANS' | translate }}
    </md-button>

</div>