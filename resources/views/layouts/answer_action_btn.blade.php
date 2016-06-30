{{--

ACTIONABLE BUTTON FOR ANSWERS

FOR: UPVOTE, DOWNVOTE, GO TO LANDING ANSWER LANDING PAGE

--}}

<div layout="row" ng-controller="AnswerCtrl as answerCtrl">

{{--    {{ print_r($answer) }}--}}
    <span layout-align="center" layout="row">
        <md-icon ng-class="answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]" layout-align="center">
            <i class="material-icons md-14">thumb_up</i>
        </md-icon>

                {{ $answer->upvote }}
         {{--@{{ 'KEY_UPVOTE' | translate  }}--}}
            </span>

    {{-- UPVOTE --}}
    <md-button layout="row"
            ng-init="answerCtrl.upvoteClass('{{$answer->voteActivity}}',{{$answer->uuid}})"

            {{-- what button should do when click--}}
            @if(Auth::user())
                ng-click="answerCtrl.upvote({{ $answer->uuid }});
                          answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]=''"
            @else
                ng-href="/login"
            @endif

            ng-class="answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]">

            <md-icon ng-class="answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]" layout-align="center">
                 <i class="material-icons md-14">thumb_up</i>
            </md-icon>


            <span layout-align="center" layout="row">
                {{ $answer->upvote }}
                {{--@{{ 'KEY_UPVOTE' | translate  }}--}}
            </span>
    </md-button>


    {{-- DOWNVOTE --}}
    <md-button layout="row"
            ng-init="answerCtrl.downvoteClass('{{$answer->voteActivity}}',{{$answer->uuid}})"

            {{-- what button should do when click--}}
            @if(Auth::user())
                ng-click="answerCtrl.downvote({{ $answer->uuid }});
                          answerCtrl.upvoteStatusClass[{{ $answer->uuid }}]=''"
            @else
            ng-href="/login"
            @endif

            ng-class="answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]">

        <md-icon
                ng-class="answerCtrl.downvoteStatusClass[{{ $answer->uuid }}]">
            <i class="material-icons md-14">thumb_down</i>
        </md-icon>

         <span layout-align="center" layout="row">
                {{ $answer->downvote }}
             {{--@{{ 'KEY_UPVOTE' | translate  }}--}}
            </span>
{{--        @{{ 'KEY_DWN_VOTE' | translate  }}--}}
    </md-button>

    <md-button ng-href="/answer/{{ $answer->uuid }}" class="md-subhead md-mini">
        <md-icon>
            <i class="material-icons md-14">question_answer</i>
        </md-icon>
        @{{ 'KEY_TALKBOUT_ANS' | translate }}
    </md-button>

</div>