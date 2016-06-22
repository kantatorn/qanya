@extends('layouts.app')

@section('content')

    <div layout="row" layout-align="start" class="layoutSingleColumn_compact md-padding"
         ng-controller="QuestionCtrl as questionCtrl">

        <div flex="100">

            {{--<form role="form" method="POST" action="{{ url('/question') }}">--}}
            <form ng-submit="questionCtrl.q_submit()">
                {!! csrf_field() !!}

                <md-content layout="column" layout-padding>

                    <h1 class="md-display-1">
                        @{{ 'KEY_QUESTION' | translate }}
                    </h1>

                    <div layout="row" flex>

                        {{-- Add Question title --}}
                        <md-input-container class="md-block" flex>
                            <label>@{{ 'KEY_TOPIC' | translate }}</label>
                            <input autocomplete="off" md-maxlength="140" required md-no-asterisk name="question_topic" ng-model="questionCtrl.question_topic">
                            <div ng-messages="projectForm.description.$error">
                                <div ng-message="required">This is required.</div>
                                <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                            </div>
                        </md-input-container>


                        {{-- Channel --}}
                        <md-input-container class="md-block">
                            <label>Channel</label>
                            <md-select ng-model="questionCtrl.question_channel">
                                @foreach($channels as $channel)
                                    <md-option  value="{!! $channel->id !!}">
                                        {!! $channel->name !!}
                                    </md-option>
                                @endforeach
                            </md-select>
                        </md-input-container>

                    </div>

                    {{-- Add question detail --}}
                    <md-button class="md-primary" ng-click="questionCtrl.questionDetailVisible = true">
                        @{{ 'KEY_ADD_DETAILS' | translate }}
                    </md-button>

                    {{-- DETAILS --}}
                    <div text-angular
                         ng-init="questionCtrl.questionDetailVisible = false"
                         ng-show="questionCtrl.questionDetailVisible"
                         ng-model="questionCtrl.questionDetail"></div>


                    {{-- Add Tags --}}
                    <md-chips
                            required
                            name="tagHolders"
                            md-max-chips="5"
                            ng-model="questionCtrl.tags"
                            md-separator-keys="questionCtrl.keys"
                            placeholder="เว้นด้วยลูกน้ำ (',')"
                            secondary-placeholder="@{{ 'KEY_TAGS' | translate }}"></md-chips>
                    <div class="errors" ng-messages="tagHolders.$error">
                        <div ng-message="md-max-chips">The maxmium of chips is reached.</div>
                    </div>


                    <div layout="row" flex>

                        <md-checkbox ng-init="questionCtrl.question_anon =0"
                                     ng-click="questionCtrl.anon=1;
                                               anonDetail = true"
                                     class="md-primary" name="anon" ng-model="questionCtrl.question_anon" aria-label="@{{ 'KEY_ANON' | translate }}">
                            @{{ 'KEY_ANON' | translate }}
                        </md-checkbox>

                        <div ng-show="anonDetail" ng-init="anonDetail= false">
                            ตั้งขำถามโดยไม่ออกนาม คำถามจะยังไม่ลงเวปทันที โดยที่จะถูกตรวจสอบก่อน
                        </div>

                        <span flex></span>

                        <md-button class="md-primary"
                                   type="submit">@{{ 'KEY_QUESTION' | translate }}</md-button>

                    </div>

                </md-content>

            </form>
        </div>
    </div>
@endsection
