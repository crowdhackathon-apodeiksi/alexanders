angular.module('App.controllers', [])

.controller('AppCtrl', function($scope, $ionicModal, $state, $ionicPlatform, DB) {
    $scope.goToReceipts = function() {
        $state.go('app.receipts');
    }
    $scope.goToCategories = function() {
        $state.go('app.categories');
    }
    $scope.goToPromotions = function() {
        $state.go('app.promotions');
    }
    $scope.goToSettings = function() {
        $state.go('app.settings');
    }
    // $ionicPlatform.ready(function() {

    //     async.series([

    //             function(callback) {
    //                 // do some stuff ...
    //                 DB.insert_category('venzina')
    //                     .then(function(res) {
    //                         callback(null, res);
    //                     })
    //                     .catch(function(err) {
    //                         callback(err);
    //                     })
    //             },
    //             function(callback) {
    //                 DB.insert_category('venzina')
    //                     .then(function(res) {
    //                         callback(null, res);
    //                     })
    //                     .catch(function(err) {
    //                         callback(err);
    //                     })
    //             },
    //             // function(callback) {
    //             //     DB.assign_receipt_to_category(200, 1)
    //             //         .then(function(res) {
    //             //             callback(null, res);
    //             //         })
    //             //         .catch(function(err) {
    //             //             callback(err);
    //             //         })
    //             // },
    //             // function(callback) {
    //             //     DB.assign_receipt_to_category(200, 2)
    //             //         .then(function(res) {
    //             //             callback(null, res);
    //             //         })
    //             //         .catch(function(err) {
    //             //             callback(err);
    //             //         })
    //             // },
    //             // function(callback) {
    //             //     DB.delete_receipt_from_category(200, 2)
    //             //         .then(function(res) {
    //             //             callback(null, res);
    //             //         })
    //             //         .catch(function(err) {
    //             //             callback(err);
    //             //         })
    //             // },
    //             // function(callback) {
    //             //     DB.get_categories_from_receipt(200)
    //             //         .then(function(res) {
    //             //             callback(null, res);
    //             //         })
    //             //         .catch(function(err) {
    //             //             callback(err);
    //             //         })
    //             // },
    //             // function(callback) {
    //             //     DB.search_category("ofim")
    //             //         .then(function(res) {
    //             //             callback(null, res);
    //             //         })
    //             //         .catch(function(err) {
    //             //             callback(err);
    //             //         })
    //             // }
    //         ],
    //         // optional callback
    //         function(err, results) {
    //             prettyLog(err);
    //             prettyLog(results);
    //             // results is now equal to ['one', 'two']
    //         });


    //     // DB.insert_category('venzina').then(function(res) {
    //     //     //prettyLog(res);
    //     // }).catch(function(err) {
    //     //     console.log("ERRR" + err)
    //     // })
    //     // DB.get_receipts().then(function(res) {
    //     //     //prettyLog(res);
    //     //     var res_id = res[0].id;
    //     //     DB.assign_receipt_to_category(res_id, 3)
    //     //         .then(function() {
    //     //             DB.get_categories_from_receipt(res_id)
    //     //                 .then(prettyLog)
    //     //                 .catch(function(e) {
    //     //                     prettyLog(e)
    //     //                 })
    //     //         })
    //     //         .catch(console.log.bind(console))
    //     // }).catch(function(err) {
    //     //     console.log("ERRR" + err)
    //     // })
    // })
    // Form data for the login modal
    // $scope.loginData = {};

    // // Create the login modal that we will use later
    // $ionicModal.fromTemplateUrl('templates/login.html', {
    //     scope: $scope
    // }).then(function(modal) {
    //     $scope.modal = modal;
    // });

    // // Triggered in the login modal to close it
    // $scope.closeLogin = function() {
    //     $scope.modal.hide();
    // };

    // // Open the login modal
    // $scope.login = function() {
    //     $scope.modal.show();
    // };

    // // Perform the login action when the user submits the login form
    // $scope.doLogin = function() {
    //     console.log('Doing login', $scope.loginData);

    //     // Simulate a login delay. Remove this and replace with your login
    //     // code if using a login system
    //     $timeout(function() {
    //         $scope.closeLogin();
    //     }, 1000);
    // };
})