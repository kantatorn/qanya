@extends('layouts.app')

@section('content')

    {{--{{ print_r($user) }}--}}

    <div layout="column" layout-align="center"
         style="width:600px"
         class="layoutSingleColumn_compact md-padding" ng-controller="QuestionCtrl as questionCtrl" ng-cloak="">

        <div layout-align="center center" layout="column">
            <img src="{{ $user->avatar }}"
                 class="img-fluid img-circle"
                 width="80px" flex="20">
            <div flex>
                <a href="/profile/{{ $user->displayname }}">
                    {{ $user->firstname }} {{ $user->lastname }}
                </a>
            </div>
        </div>

        <md-content>

            <md-tabs md-dynamic-height md-border-bottom layout-align="center" layout="column">

            {{-- EDIT PROFILE--}}
            <md-tab label="Edit profile">
                <md-content class="md-padding" ng-controller="UserCtrl as userCtrl">

                    <form ng-submit="userCtrl.updateInfo()">
                    <div layout-gt-xs="row">
                        <md-input-container class="md-block" flex-gt-xs>
                            <label>@{{ 'KEY_FIRSTNAME' | translate }}</label>
                            <input  ng-init="userCtrl.editForm.firstname = '{{ $user->firstname }}'"
                                    ng-model="userCtrl.editForm.firstname" placeholder="{{ $user->firstname }}">
                        </md-input-container>

                        <md-input-container class="md-block" flex-gt-xs>
                            <label>@{{ 'KEY_LASTNAME' | translate }}</label>
                            <input  ng-init="userCtrl.editForm.lastname = '{{ $user->lastname }}'"
                                    ng-model="userCtrl.editForm.lastname" placeholder="{{ $user->lastname }}">
                        </md-input-container>
                    </div>

                        {{--<md-input-container class="md-block" flex-gt-xs>
                            <label>Website</label>
                            <input ng-model="userCtrl.website" placeholder="{{ $user-> }}">
                        </md-input-container>--}}

                        <md-input-container class="md-block">
                            <label>Biography</label>
                            <textarea md-maxlength="250" rows="5"
                                      md-select-on-focus
                                      ng-init="userCtrl.editForm.description = '{{ $user->description }}'"
                                      ng-model="userCtrl.editForm.description"
                                      placeholder="{{ $user->description }}"></textarea>
                        </md-input-container>

                        <md-input-container class="md-block" flex-gt-xs>
                            <label>@{{ 'KEY_EMAIL' |translate }}</label>
                            <input ng-init="userCtrl.editForm.email = '{{ $user->email }}'"
                                   ng-model="userCtrl.editForm.email"
                                   placeholder="{{ $user->email }}">
                        </md-input-container>

                        <md-button type="submit">@{{ 'KEY_SAVE' | translate }}</md-button>
                    </form>

                </md-content>
            </md-tab>


            {{-- CHANGE PASSWORD --}}
            <md-tab label="Change Password">
                <md-content class="md-padding" ng-controller="UserCtrl as userCtrl">

                    <form ng-submit="userCtrl.changePass()">

                        <md-input-container class="md-block" flex-gt-xs>
                            <label>@{{ 'KEY_OLD_PWD' | translate }}</label>
                            <input ng-model="userCtrl.pwdForm.oldPass" type="password">
                        </md-input-container>

                        <md-input-container class="md-block" flex-gt-xs>
                            <label>@{{ 'KEY_NEW_PWD' | translate }}</label>
                            <input ng-model="userCtrl.pwdForm.newPass" type="password">
                        </md-input-container>

                        <md-input-container class="md-block" flex-gt-xs>
                            <label>@{{ 'KEY_NEW_PWD_C' | translate }}</label>
                            <input ng-model="userCtrl.pwdForm.confirmNewPass" type="password">
                        </md-input-container>

                        <md-button type="submit"
                                   ng-if="(userCtrl.pwdForm.newPass == userCtrl.pwdForm.confirmNewPass) && userCtrl.pwdForm.newPass">
                            @{{ 'KEY_CHG_PWD' | translate }}</md-button>

                    </form>

                </md-content>
            </md-tab>


            {{-- CONNECT SOCIAL --}}
            <md-tab label="Social">
                <md-content>test</md-content>
            </md-tab>
            <md-tab label="Email">
                <md-content>test</md-content>
            </md-tab>
        </md-tabs>
        </md-content>

    </div>
@endsection