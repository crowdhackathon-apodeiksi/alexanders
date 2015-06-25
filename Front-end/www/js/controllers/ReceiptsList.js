angular.module('ReceiptsList.controllers', [])
    .controller('ReceiptsCtrl', function($scope, $ionicPlatform, $ionicPopup, DB, imageToBLOB, $ionicListDelegate) {
        $ionicPlatform.ready(function() {

            //dropdown initialization
            var drop_button = $('.dropdown_custom button');
            var drop_list = $('.dropdown_custom ul');
            drop_list.css('width', drop_button.css('width'))
            drop_list.css('margin-top', '-' + drop_button.css('height'))
            $scope.sort_by_items = {
                'me eponimia': 'eponimia',
                'aukson arithmos': 'aa',
                'me afm': 'afm',
                'me poso': 'poso'
            }
            $scope.show_drop_func = function() {
                $scope.show_drop = !$scope.show_drop;
            }


            $scope.sort_by = function(item) {
                $scope.show_drop = false;
                if ($scope.sort_by_item != item) {
                    $scope.sort_by_item = item;

                    $scope.moreDataCanBeLoaded = true;
                    $scope.receipts = [];

                    offset = 0;
                    limit = 30;
                    order = 'DESC';
                    order_by = item;

                    //it will load more automatically
                    //dont call it manual it will cause duplicates!
                    $scope.loadMore();

                }

            }

            //load DB data
            $scope.moreDataCanBeLoaded = true;
            $scope.receipts = [];

            var offset = 0;
            var limit = 30;
            var order = 'DESC';
            var order_by = 'id';
            var lock = false;
            $scope.loadMore = function() {
                if (lock) return false;
                lock = true;
                DB.get_receipts(offset, limit, order_by, order).then(function(data) {
                    if (data.length == 0) $scope.moreDataCanBeLoaded = false;
                    offset += limit;
                    console.log('kano log tora')
                    //prettyLog(data);

                    $scope.receipts = $scope.receipts.concat(data);
                    $scope.$broadcast('scroll.infiniteScrollComplete');
                    lock = false;

                }).catch(function(err) {
                    alert(err);
                })


            };


            $scope.remove_receipt = function(receipt, index) {
                prettyLog(index)
                var confirmPopup = $ionicPopup.confirm({
                    title: 'DELETE',
                    template: 'Are you sure?',
                    cancelType: 'btn grey waves-effect waves-light',
                    okType: 'btn waves-effect waves-light'
                });
                confirmPopup.then(function(res) {
                    $ionicListDelegate.closeOptionButtons();
                    if (res) {
                        DB.delete_receipt(receipt.id).then(function() {
                            $scope.receipts.splice(index, 1);
                        }).catch(function() {
                            alert('db error')
                        })
                    }
                });
            }
        })

    })