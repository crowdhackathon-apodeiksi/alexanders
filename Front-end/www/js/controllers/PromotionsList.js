angular.module('PromotionList.controllers', [])
    .controller('PromotionsCtrl', function($scope, $ionicPlatform, api, $ionicPopup, $interval) {
        $scope.promotions = []
        $ionicPlatform.ready(function(){
            api.getPromotions().then(function(data){
                    $scope.promotions = data.all_proms
            })    
        })
        

    })