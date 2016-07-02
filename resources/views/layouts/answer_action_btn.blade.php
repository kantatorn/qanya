{{--

ACTIONABLE BUTTON FOR ANSWERS

FOR: UPVOTE, DOWNVOTE, GO TO LANDING ANSWER LANDING PAGE

--}}
{{--{{ print_r($answer) }}--}}



<md-card-actions layout="row" layout-align="start center" ng-controller="AnswerCtrl as answerCtrl">

    <span class="md-display-1">
        {{ $answer->upvote - $answer->downvote }}
    </span>

    {{-- UPVOTE --}}
    <md-button ng-init="answerCtrl.upvoteClass('{{$answer->voteActivity}}',{{$answer->uuid}})"
               class="md-icon-button"
            {{-- what button should do when click--}}
               @if(Auth::user())

               ng-click="answerCtrl.upvote({{ $answer->uuid }});
                          answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]=''"
               @else
               ng-href="/login"
               @endif

               ng-class="answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]">

        <md-tooltip md-direction="top">
            i like this answer
        </md-tooltip>

        <md-icon ng-class="answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]" flex>
            <i class="material-icons md-18">thumb_up</i>
        </md-icon>

    </md-button>


    {{-- DOWNVOTE --}}
    <md-button ng-init="answerCtrl.downvoteClass('{{$answer->voteActivity}}',{{$answer->uuid}})"
               class="md-icon-button"
            {{-- what button should do when click--}}
               @if(Auth::user())
               ng-click="answerCtrl.downvote({{ $answer->uuid }});
                          answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]=''"
               @else
               ng-href="/login"
               @endif

               ng-class="answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]">

        <md-tooltip md-direction="top">
            i don't like this answer
        </md-tooltip>

        <md-icon ng-class="answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]">
            <i class="material-icons md-18">thumb_down</i>
        </md-icon>

    </md-button>


    {{-- Replies tally --}}
    <md-button ng-href="/answer/{{ $answer->uuid }}">

        <md-icon>
            <i class="material-icons md-18">question_answer</i>
        </md-icon>

        <md-tooltip md-direction="top">
            @{{ 'KEY_TALKBOUT_ANS' | translate }}
        </md-tooltip>
        {{ $answer->replies_count }}

    </md-button>



</md-card-actions>