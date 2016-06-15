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
