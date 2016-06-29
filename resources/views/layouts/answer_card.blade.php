{{-- ANSWER CARD--}}

@if(Auth::user())

    <md-card class="md-padding" ng-show="questionCtrl.answerForm"
             ng-init="questionCtrl.answerForm = false">

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
                    <md-button class="md-primary md-mini"
                               ng-click="questionCtrl.userExpertiseShow = true">
                        <md-icon>
                            <i class="material-icons">account_box</i>
                        </md-icon>
                        @{{ 'KEY_EXPERIENCE' | translate }}
                    </md-button>
                </span>
            </md-card-header-text>
        </md-card-header>

        <br>

        {{-- User Expertise --}}
        <md-radio-group ng-model="questionCtrl.userExpertId"
                        ng-controller="UserCtrl as userCtrl"
                        ng-init="questionCtrl.userExpertiseShow = false"
                        ng-show="questionCtrl.userExpertiseShow"
                        class="md-primary"
                        >

            @foreach(explode(",",$topic->tags) as $key=>$tag)

                <form ng-submit="userCtrl.updateExpertise({{ $key }},'{{ $tag }}')">
                    <div layout="column" layout-padding style="display:inline-block;">
                        <div layout="row" layout-align="start center">
                            <md-radio-button
                                @foreach($userExperts as $expert)
                                        {{ $expert->title }} {{ $tag }}
                                    @if(strip_tags($expert->title) == $tag)
                                        ng-value="{{ $expert->id }}"
                                    @endif
                                @endforeach
                                flex>
                                <span layout-align="center center">
                                    {{ $tag }}
                                </span>
                            </md-radio-button>


                            <md-input-container md-no-float class="md-block">

                                <input ng-model="userCtrl.expText[{{ $key }}]"
                                       type="text"
                                       required
                                        @foreach($userExperts as $expert)
                                            @if(strip_tags($expert->title) == $tag)
                                            placeholder="{{ strip_tags($expert->text) }} "
                                            @endif
                                        @endforeach>
                            </md-input-container>

                            <md-button class="md-primary" type="submit">
                                <md-icon class="md-secondary">
                                    <i class="material-icons" style="display:inline-block;">send</i>
                                </md-icon>
                            </md-button>
                        </div>
                    </div>
                </form>
            @endforeach
        </md-radio-group>


        <div text-angular ng-model="questionCtrl.answer_text"></div>

        <md-button  type="submit"
                    ng-show="questionCtrl.answer_text.length"
                    ng-disabled="questionCtrl.answerBtnStatus"
                    class="md-primary md-raised"
                    ng-click="questionCtrl.answer_submit('{{$topic->uuid}}');
                                          questionCtrl.answerBtnStatus=true">
            @{{ 'KEY_REPLY' | translate }}</md-button>
    </md-card>
@endif