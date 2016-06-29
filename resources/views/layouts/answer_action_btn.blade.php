{{--

ACTIONABLE BUTTON FOR ANSWERS

FOR: UPVOTE, DOWNVOTE, GO TO LANDING ANSWER LANDING PAGE

--}}

<div layout="row" ng-controller="AnswerCtrl as answerCtrl">

    {{--{{ print_r($answer) }}--}}

    {{-- UPVOTE --}}
    <md-button
            ng-init="answerCtrl.upvoteClass({{$answer->isVoted}},{{$answer->uuid}})"

            {{-- what button should do when click--}}
            @if(Auth::user())
                ng-click="answerCtrl.upvote({{ $answer->uuid }})"
            @else
                ng-href="/login"
            @endif

            ng-class="answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]">

            <md-icon
                    ng-class="answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]">
                 <i class="material-icons md-18">thumb_up</i>
            </md-icon>

            @{{ 'KEY_UPVOTE' | translate  }}
    </md-button>


    {{-- DOWNVOTE --}}
    <md-button
            ng-init="answerCtrl.downvoteClass({{$answer->isVoted}},{{$answer->uuid}})"

            {{-- what button should do when click--}}
            @if(Auth::user())
            ng-click="answerCtrl.downvote({{ $answer->uuid }})"
            @else
            ng-href="/login"
            @endif

            ng-class="answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]">

        <md-icon
                ng-class="answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]">
            <i class="material-icons md-18">thumb_down</i>
        </md-icon>

        @{{ 'KEY_DWN_VOTE' | translate  }}
    </md-button>

    <md-button ng-href="/answer/{{ $answer->uuid }}">
        <md-icon>
            <i class="material-icons">question_answer</i>
        </md-icon>
        @{{ 'KEY_TALKBOUT_ANS' | translate }}
    </md-button>

</div>