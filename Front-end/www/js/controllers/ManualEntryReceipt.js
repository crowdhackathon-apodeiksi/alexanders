angular.module('ManualEntryReceipt.controllers', [])
    .controller('ManualEntryCtrl', function($scope, imageToBLOB, $cordovaBarcodeScanner,$ionicHistory, $ionicPopup, $ionicPlatform, $ionicLoading, DB, $q, $stateParams, API_URL,$http,$state,DatesStorage,$cordovaCamera) {


        $scope.receipt = {};
        var toDelete = [];
        var shouldGoNext;

        $ionicPlatform.ready(function() {


            prettyLog($stateParams);
            if ($stateParams.id) {
                shouldGoNext = 'app.receipts';
                DB.get_receipt($stateParams.id)
                    .then(function(res) {
                        prettyLog(res);
                        $scope.receipt = res;
                        setTimeout(function() {
                            $('.validate').focus();
                        }, 0)
                    }).catch(function(err) {
                        console.log(err);
                    })
            } else {
                shouldGoNext = 'app.home';
                if ($stateParams.type == 'scan') {
                    console.log('going scan')
                    // $scope.receipt = {
                    //     afm: Math.floor(Math.random() * 999999999) + 100000000,
                    //     poso: +((Math.random() * 10000) % 1000).toFixed(2),
                    //     printed_at: (function() {
                    //         var x = new Date();
                    //         x.setSeconds(0);
                    //         x.setMilliseconds(0);
                    //         return x;
                    //     })(),
                    //     aa: 1,
                    //     eponimia: "kosmas"
                    // }
                    setTimeout(function() {
                        $('.validate').focus();
                    }, 1000);
                    $cordovaBarcodeScanner
                        .scan()
                        .then(function() {
                            // Success! Barcode data is here
                            $scope.receipt = {
                                afm: undefined,
                                poso: 1.60,
                                printed_at: (function() {
                                    var x = new Date();
                                    x.setSeconds(0);
                                    x.setMilliseconds(0);
                                    return x;
                                })(),
                                aa: 92,
                                eponimia: undefined
                            }
                            setTimeout(function() {
                                $('.validate').focus();
                            }, 1000);
                                    
                            //if (!barcodeData.canceled) window.history.back();
                        }, function(error) {
                            // An error occurred
                            alert(error)
                        });

                } else if ($stateParams.type == 'manual') {

                    $scope.receipt = {
                        afm: undefined,
                        poso: undefined,
                        printed_at: (function() {
                            var x = new Date();
                            x.setSeconds(0);
                            x.setMilliseconds(0);
                            return x;
                        })(),
                        aa: undefined,
                        eponimia: undefined
                    }
                    setTimeout(function() {
                        $('.validate').focus();
                    }, 1000);

                } else if ($stateParams.type == 'manual_ocr') {
                    //TODO

                    
                    setTimeout(function() {
                        $scope.receipt = {
                        afm: "997793450",
                        poso: 1.80,
                        printed_at: (function() {
                            var x = new Date();
                            x.setSeconds(0);
                            x.setMilliseconds(0);
                            return x;
                        })(),
                        aa: undefined,
                        eponimia: undefined
                    }
                    setTimeout(function() {
                        $('.validate').focus();
                    }, 1000);
                    }, 2500)
                    
                    

                }

            }


        })

        

        $scope.autoCompleteCategories = function(query) {
            var deferred = $q.defer();
            DB.search_category(query)
                .then(function(res) {
                    deferred.resolve(res.map(function(x) {
                        return x.name;
                    }));
                })
            return deferred.promise;
        }
        $scope.removeCategory = function(tag) {
            if ($scope.receipt.id) {
                toDelete.push({
                    receipt_id: $scope.receipt.id,
                    tag: tag.text
                });
            }
        }

        function final_remove_categories() {
            toDelete.forEach(function(del) {
                DB.delete_receipt_from_category_name(del.receipt_id, del.tag)
                    .then(prettyLog)
                    .catch(prettyLog)
            })
            toDelete = [];

        }
        $scope.submit = function() {
            //prettyLog($scope.receipt);
            final_remove_categories();
            if ($scope.receipt.id) {
                DatesStorage.setEditDates();
                console.log('going for update')
                DB.update_receipt($scope.receipt)
                    .then(onSaved)
                    .catch(function(e) {
                        console.log('error')
                        alert(e)
                    })
            } else {
                DatesStorage.setSubmitDates();
                DB.save_receipt($scope.receipt)
                    .then(onSaved)
                    .catch(function(e) {
                        alert(e)
                    })
            }

            function onSaved(saved) {
                console.log('piga')
                $scope.receipt.id = $scope.receipt.id || saved.insertId;
                var categories = $scope.receipt.categories.map(function(x) {
                    return x.text;
                })
                DB.insert_categories_and_assign(categories, $scope.receipt.id);
                $ionicPopup.alert({
                    title: '<b>Information</b>',
                     cssClass: 'animated-popup fadeInUp-popup',
                    template: '<p>Η απόδειξη καταχωρήθηκε με επιτυχία!</p>',
                    okText: 'Κλεισιμο',
                    okType: 'btn waves-effect waves-light'
                }).then(function() {
                    $ionicHistory.nextViewOptions({
                        disableBack: true
                    });

                    $state.go(shouldGoNext);

                })
            }

        }
        $scope.check = function(inp) {
            $scope.$$childHead.awss[inp].$setValidity('number', true)
            $scope.$$childHead.awss[inp].$render()
            $scope.$$childHead.awss[inp].$validate()
        }
    })