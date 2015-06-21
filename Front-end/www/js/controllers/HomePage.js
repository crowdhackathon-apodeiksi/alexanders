angular.module('HomePage.controllers', [])

.controller('HomeCtrl', function($scope, $ionicPopup, $state, DB, Achievements,User,$interval, $ionicPlatform,api) {

    //api.getPromotions();
    // $ionicPopup.alert({
    //              title: 'Συγχαρητηρια',
    //              cssClass: 'animated tada',
    //              template: 'sadsd',
    //              okType: 'btn-floating btn-large waves-effect waves-light'
    //            })
    $ionicPlatform.ready(function() {


            DB.get_user_level().then(function(data){
                $scope.level = data;
            });
            DB.get_receipts_sum().then(function(data){
                $scope.sum = data;
            });

            DB.get_receipts_count().then(function(data){
                $scope.count = data;
            });
            $scope.logged = User.get_credentials().logged;
            Achievements.check_completed_achievements().then(function(achievements){
                function showPopup(){
                    var text = achievements[++index];
                    if(!text) return;
                    $ionicPopup.show({
                        title: 'Συγχαρητηρια',
                        scope: $scope,
                        cssClass: 'animated-popup tada-popup',
                        template: text,
                        buttons: [
                          { text: 'OK',type: 'btn-floating btn-large waves-effect waves-light'},
                          {
                            text: 'Share',
                            type: 'btn-floating btn-large waves-effect waves-light',
                            
                          }
                        ]
                    })
                }

                
                var index = -1;
                showPopup()
            })
        
    })

    setTimeout(function() {
        //api.login().then(api.synchronize)
    }, 1000)
    var popup;
    $scope.ss = function() {
        alert()
    }
    $scope.showPopup = function() {
        popup = $ionicPopup.show({
            template: '<button ng-click="goToScan()"  class="btn  waves-effect waves-teal">Barcode</button><br>' +
                '<button ng-click="goToManualOCR()" class="btn waves-effect waves-teal">OCR</button><br>'+
                '<button ng-click="goToManual()" class="btn waves-effect waves-teal">Χειροκινητα</button><br>',
            title: 'Μεθοδος Καταχωρησης',
            cssClass: 'custom-popup animated-popup rubberBand-popup',
            scope: $scope
        });



    }
    $scope.goToScan = function() {
        $state.go('app.manual_entry', {
            type: 'scan'
        });
        popup.close();
    }
    $scope.goToManualOCR = function() {
        $state.go('app.manual_entry', {
            type: 'manual_ocr'
        });
        popup.close();
    }
    $scope.goToManual = function() {
        $state.go('app.manual_entry', {
            type: 'manual'
        });
        popup.close();
    }
})