angular.module('App')

    .directive('userExpertise', function () {
        return {
            controller: 'UserCtrl as userCtrl',
            restrict: 'EA',
            transclude:   true,
            templateUrl: '/js/directives/views/user-expertise.html',
            scope: {
                data: '='
            }
        }
    })

    /* CHANNELS LISTTING BUTTONS */
    .directive('channelsButton', function () {
        return {
            controller: 'AppCtrl as appCtrl',
            restrict: 'EA',
            transclude:   true,
            templateUrl: '/js/directives/views/channels-button.html'
        }
    })