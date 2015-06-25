angular.module('ScanReceipt.controllers', [])
    .controller('ScanCtrl', function($q, $scope,$stateParams, $ionicPlatform, $cordovaBarcodeScanner, $state, $ionicPopup, $ionicLoading, DB) {
        
        $scope.receipt = {};
        var toDelete = [];

        $ionicPlatform.ready(function() {
            prettyLog($stateParams);
            if($stateParams.id){
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
            }else{
                
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
                    receipt_id : $scope.receipt.id,
                    tag : tag.text
                });
            }
        }
        function final_remove_categories(){
            toDelete.forEach(function(del){
                DB.delete_receipt_from_category_name(del.receipt_id, del.tag)
                    .then(prettyLog)
                    .catch(prettyLog)
            })
            toDelete = [];
            
        }
        $scope.submit = function() {
            $scope.receipt.image = $scope.$$childHead.capturedImagePath;
            final_remove_categories();
            $scope.receipt.type = 'scanned';
            if($scope.receipt.id){
                DB.update_receipt($scope.receipt).then(onSaved)
                .catch(function(e) {
                    alert(e)
                })
            }else{
                DB.save_receipt($scope.receipt)
                .then(onSaved)
                .catch(function(e) {
                    alert(e)
                })
            }
            function onSaved(saved){
                $scope.receipt.id = $scope.receipt.id || saved.insertId;
                prettyLog(saved);
                prettyLog($scope.receipt);
                var categories = $scope.receipt.categories.map(function(x) {
                    return x.text;
                })
                DB.insert_categories_and_assign(categories, $scope.receipt.id);
                setTimeout(function(){
                    DB.get_receipt($scope.receipt.id)
                    .then(prettyLog)
                },1000)
                $ionicPopup.alert({
                    title: '<b>Information</b>',
                    template: '<p>Η απόδειξη καταχωρήθηκε με επιτυχία!</p>',
                    okText: 'Κλεισιμο',
                    okType: 'btn waves-effect waves-light'

                });
            }
            
        }
        



    })