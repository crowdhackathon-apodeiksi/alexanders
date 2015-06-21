angular.module('Settings.controllers', [])

.controller('SettingsCtrl', function($scope, $ionicPlatform, User, $state, api) {
    $scope.logged = false;
    $scope.go_go = function() {
        //api.login().then(api.synchronize)
        api.synchronize()
    }
    $ionicPlatform.ready(function() {
        var data = User.get_credentials();
        if (data) {
            $scope.email = data.email;
            $scope.password = data.password;
            $scope.logged = data.logged;
        }
    })

    $scope.$watch('logged', function() {
        console.log('change')
        $('.validate').parent().find('label').addClass('active')

    })
    $scope.sign_in = function() {
        console.log($scope)
        if ($scope.email && $scope.password) {
            api.login($scope.email, $scope.password).success(function() {
                $scope.logged = true;
            }).error(function() {
                alert('Login error')
            })
        }
    }
    $scope.logout = function() {
        console.log($scope.email);
        User.logout();
        $scope.email = undefined;
        $scope.password = undefined;
        $scope.logged = false;
    }
    $scope.go_to_register = function() {
        $scope.email = undefined;
        $scope.password = undefined;
        $scope.retype_password = undefined;
        $scope.register_state = true;
    }
    $scope.go_to_login = function() {
        $scope.email = undefined;
        $scope.password = undefined;
        $scope.retype_password = undefined;
        $scope.register_state = false;
        $scope.logged = false;
    }
    $scope.register = function() {
        if ($scope.email && $scope.password) {
            api.register($scope.email, $scope.password);
            $scope.register_state = false;
            $scope.logged = true;
            console.log('sucess')
        }
    }
})

.directive("compareTo", function() {
    return {
        require: "ngModel",
        scope: {
            otherModelValue: "=compareTo"
        },
        link: function(scope, element, attributes, ngModel) {

            ngModel.$validators.compareTo = function(modelValue) {
                return modelValue && scope.otherModelValue && modelValue == scope.otherModelValue;
            };

            scope.$watch("otherModelValue", function() {
                ngModel.$validate();
            });
        }
    };
})