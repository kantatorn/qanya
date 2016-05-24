@extends('layouts.app')

@section('content')
    <div layout="row" layout-align="center" class="layoutSingleColumn md-padding" ng-controller="QuestionCtrl as questionCtrl">
        <div flex="100">
            <md-content>
                <h1 class="md-display-1">
                    @{{ 'KEY_QUESTION' | translate }}
                </h1>

                {{-- Add Question title --}}
                <md-input-container class="md-block">
                    <label>@{{ 'KEY_TOPIC' | translate }}</label>
                    <input md-maxlength="140" required md-no-asterisk name="description" ng-model="project.description">
                    <div ng-messages="projectForm.description.$error">
                        <div ng-message="required">This is required.</div>
                        <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                    </div>
                </md-input-container>


                {{-- Add question detail --}}
                <md-button class="md-primary" ng-click="">@{{ 'KEY_ADD_DETAILS' | translate }}</md-button>


                <div contenteditable="true" ng-show=""> details here</div>

                <div layout-align="center end">
                    <md-button class="md-hue-1 md-raised">Ask</md-button>
                    <md-button class="md-hue-1 md-raised">Ask</md-button>
                </div>

            </md-content>
        </div>
    </div>
@endsection
