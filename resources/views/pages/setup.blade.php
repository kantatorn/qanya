@extends('layouts.app')

@section('content')
    <div layout="row" layout-align="center" class="layoutSingleColumn"
         style="max-width:600px"
         ng-controller="UserCtrl as userCtrl">

        <div flex="100">

            {{-- CREATE NAME--}}
            @if(!Auth::user()->displayname)
            <md-card
                     ng-hide ="userCtrl.nameSave"
                     ng-class="userCtrl.createNameCard"
                     ng-init ="userCtrl.createNameCard = userCtrl.cardEnter">
                <md-card-title>
                    <md-card-title-text>
                        <span class="md-headline">
                            @{{ 'KEY_NAME_CREATE' | translate }}
                        </span>
                        <span class="md-subhead md-warn md-hue-1">
                            @{{ 'KEY_NAME_CHG_ONCE' | translate }}
                        </span>
                    </md-card-title-text>
                </md-card-title>

                <md-card-content>


                <md-input-container class="md-block">
                    <label>@{{ 'KEY_USERNAME' | translate }}</label>
                    <input md-maxlength="30" required md-no-asterisk
                           name="description"
                           autocomplete="off"
                           ng-keyup="userCtrl.nameVerified = false"
                           ng-model="userCtrl.username">
                    <div ng-messages="projectForm.description.$error">
                        <div ng-message="required">This is required.</div>
                        <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                    </div>
                </md-input-container>

                {{-- Spinner --}}
                <span ng-show="userCtrl.isloading" ng-init="userCtrl.isloading = false">
                    <i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </span>

                {{-- Check user name button --}}
                <md-button
                        ng-click="userCtrl.checkUserName()"
                        ng-if="userCtrl.username"
                        class="md-accent md-raised">
                    @{{ 'KEY_CHECK' | translate }}
                </md-button>

                {{-- Save username--}}
                <md-button
                        ng-show="userCtrl.nameVerified"
                        ng-iint="userCtrl.nameVerified = false"
                        ng-click="userCtrl.saveUsername();
                                  userCtrl.nameSave = true;
                                  userCtrl.createNameCard = userCtrl.cardLeave
                                  "
                        class="md-primary md-raised">
                    @{{ 'KEY_SAVE' | translate }}
                </md-button>

                </md-card-content>

            </md-card>
            @endif


            {{-- Channel List --}}
            <md-card
                    ng-show ="userCtrl.channelVisible"
                    ng-hide ="userCtrl.channelSave"
                    ng-class="userCtrl.createChannelCard"
                    ng-init ="userCtrl.createChannelCard = userCtrl.cardEnter;
                              userCtrl.isUsername('{{Auth::user()->displayname}}')">
                <md-card-title>
                    <md-card-title-text>
                        <span class="md-headline">
                            เลือกหัวข้อที่คุณสนใจ
                        </span>
                        <span class="md-subhead md-warn md-hue-1">
                            เลือกอย่างน้อยสอง
                        </span>
                    </md-card-title-text>
                </md-card-title>

                <md-list ng-cloak>
                    <?php $index = 0 ?>
                    @foreach($channels as $channel)

                        <md-list-item>
                            <p> {{ $channel->name }} </p>
                            <md-checkbox class="md-secondary"
                                         ng-model="userCtrl.channelSelect[{{ $channel->id }}]"></md-checkbox>
                        </md-list-item>
                        <?php $index++ ?>
                    @endforeach
                </md-list>

                <md-button
                        class="md-primary md-raised"
                        ng-click="userCtrl.saveChannel();
                                  userCtrl.createChannelCard=userCtrl.cardLeave;
                                  userCtrl.channelSave = true;"
                        ng-if="userCtrl.channelSelect">
                        @{{ 'KEY_SAVE' | translate }}
                </md-button>

            </md-card>



            {{-- What Interest you--}}
            <md-card
                    ng-show ="userCtrl.expertsVisible"
                    ng-hide ="userCtrl.expertsSave"
                    ng-class="userCtrl.createExpertCard"
                    ng-init ="userCtrl.createExpertCard = userCtrl.cardEnter">

                <md-card-title>
                    <md-card-title-text>
                        <span class="md-headline">
                          คุณสนใจเรื่องอะไรมั่ง
                        </span>
                        <span class="md-subhead md-warn md-hue-1">
                            ใส่แทกที่สนใจ กด enter เพื่อสร้างคำใหม่
                        </span>
                    </md-card-title-text>
                </md-card-title>

                <md-card-content>

                    <md-chips
                            required
                            name="tagHolders"
                            md-max-chips="5"
                            ng-model="userCtrl.tagExpertiseList"
                            placeholder="เว้นด้วยลูกน้ำ (',')"
                            md-separator-keys="userCtrl.keys"
                            secondary-placeholder="@{{ 'KEY_TAGS' | translate }}"></md-chips>

                </md-card-content>

                <md-button
                        class="md-primary md-raised"
                        ng-click="userCtrl.addExpertiseList();
                                  userCtrl.expertsSave = true;
                                  userCtrl.profileCardVisible = true;
                                  userCtrl.createExpertCard = userCtrl.cardLeave"
                        ng-if="userCtrl.tagExpertiseList.length > 0">
                        @{{ 'KEY_SAVE' | translate }}
                </md-button>

            </md-card>



            {{-- Complete and done --}}
            <md-card layout="column" layout-align="center center"
                     ng-show="userCtrl.profileCardVisible"
                     ng-class="userCtrl.profileCard"
                     ng-init ="userCtrl.profileCard = userCtrl.cardEnter;">
                <md-card-title layout-align="center center">
                    <md-card-title-text>
                        <span class="md-headline">
                            เรียบร้อย ยินดีต้อนรับ
                            {{ Auth::user()->firstname }}
                            {{ Auth::user()->lastname }}
                        </span>
                    </md-card-title-text>

                    <md-card-title-media>

                    </md-card-title-media>
                </md-card-title>

                <div class="md-media-lg card-media">
                    <img ng-src="{{ Auth::user()->avatar}}?'http://xacatolicos.com/app/images/avatar/icon-user.png'"
                         id="profilePhoto"
                         class="img-fluid img-circle"
                         width="150px">
                </div>
                <div flow-init
                     flow-name="uploader.flow"
                     flow-files-added="userCtrl.addProfileImage($files)"
                     layout-align="center center">
                    <md-button flow-btn type="file" name="image">
                        @{{ 'KEY_UPLOAD_PHOTO' | translate }}
                    </md-button>
                </div>

                <md-card-actions layout="row" layout-align="center center">
                    <md-button class="md-primary md-raised"
                               ng-href="/init_complete"
                               ng-click="userCtrl.profileCard = userCtrl.cardLeave;">
                        @{{ 'KEY_LOGIN' | translate }}
                    </md-button>
                </md-card-actions>

            </md-card>

        </div>
    </div>
@endsection