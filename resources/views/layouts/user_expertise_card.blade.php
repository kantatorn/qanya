{{--

USER INTEREST CARD
ABOUT: DISPLAY LISTING AND ADD NEW INTEREST

--}}

@if(Auth::user())
    <md-card ng-controller="UserCtrl as userCtrl">

        <md-list ng-init="userCtrl.expertiseList('{{  Auth::user()->uuid }}')">

            <md-subheader class="md-no-sticky" layout-align="center center" layout="row">

                @{{ 'KEY_INTEREST_ADD' | translate }}

                <md-button class="md-accent md-hue-2 md-icon-button md-fab md-mini"
                           ng-click="showAddExpertise = true">
                    <i class="material-icons">create</i>
                </md-button>

            </md-subheader>

            <form
                    ng-init="showAddExpertise = false"
                    ng-show="showAddExpertise"
                    ng-submit="userCtrl.addExpertise('{{ Auth::user()->uuid }}')" layout-padding="">
                <md-input-container class="md-block" md-no-float>
                    <label>@{{ 'KEY_INTEREST_IN' | translate }}</label>
                    <input ng-model="userCtrl.expertise" type="text" autocomplete="off">
                </md-input-container>

                <md-input-container class="md-block" ng-if="userCtrl.expertise">
                    <label>details</label>
                                <textarea ng-model="userCtrl.expertise_body"
                                          md-maxlength="150" rows="5"
                                          placeholder="optional"
                                          md-select-on-focus></textarea>
                </md-input-container>

                <md-button
                        ng-if="userCtrl.expertise"
                        class="md-primary md-raised md-fab md-mini"
                        type="submit">
                    <i class="material-icons">send</i>
                </md-button>
            </form>


            <md-list-item layout-padding ng-repeat="expertise in userCtrl.expertiseArray">

                <div layout="row">
                    <div class="md-list-item-text" layout="column">

                        <div>
                            @{{ expertise.endorsed}}

                            <a href="/tag/@{{ expertise.title | htmlToPlaintext}}">
                                @{{ expertise.title | htmlToPlaintext}}
                            </a>
                            <p class="md-caption" ng-if="expertise.text">
                                @{{ expertise.text }}
                            </p>
                        </div>

                        <div layout="row"
                             ng-show="expertiseVisible[expertise.id]"
                             ng-init="expertiseVisible[expertise.id] = false">
                            <md-input-container md-no-float >
                                <input ng-model="user.address" type="text"
                                       md-maxlength="150"
                                       placeholder="Address" >
                            </md-input-container>
                            <md-button>
                                <i class="material-icons">create</i>
                            </md-button>
                        </div>

                    </div>

                    <div class="md-secondary">
                        <md-menu>
                            <md-button class="md-icon-button" ng-click="userCtrl.openMenu($mdOpenMenu, $event)">
                                <md-icon>
                                    <i class="material-icons">more_vert</i>
                                </md-icon>
                            </md-button>

                            <md-menu-content width="4">
                                <md-menu-item>
                                    <md-button ng-click="expertiseVisible[expertise.id] = true">
                                        @{{ 'KEY_ADD_DETAILS' | translate }}
                                    </md-button>
                                </md-menu-item>
                                <md-menu-item>
                                    <md-button>
                                        @{{ 'KEY_REMOVE' | translate }}
                                    </md-button>
                                </md-menu-item>
                            </md-menu-content>
                        </md-menu>
                    </div>
                </div>

            </md-list-item>

        </md-list>
    </md-card>
@endif