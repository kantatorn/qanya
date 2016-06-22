{{-- ANSWER CARD--}}

@if(Auth::user())

    <md-card class="md-padding" ng-show="questionCtrl.answerForm" ng-init="questionCtrl.answerForm = false">

        <md-card-header>
            <md-card-avatar>
                <img class="md-user-avatar"
                     src="{{ Auth::user()->avatar }}"/>
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

        <div text-angular ng-model="questionCtrl.answer_text"></div>

        <md-button  type="submit"
                    ng-show="questionCtrl.answer_text.length"
                    ng-disabled="questionCtrl.answerBtnStatus"
                    class="md-accent md-raised"
                    ng-click="questionCtrl.answer_submit('{{$topic->uuid}}');
                                          questionCtrl.answerBtnStatus=true">
            @{{ 'KEY_REPLY' | translate }}</md-button>
    </md-card>
@endif