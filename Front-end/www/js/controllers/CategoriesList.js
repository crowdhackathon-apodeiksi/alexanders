angular.module('CategoriesList.controllers', [])
    .controller('CategoriesCtrl', function($scope, $ionicPlatform, DB, $ionicPopup, $ionicListDelegate) {

        $scope.categories = [];
        $scope.ourt = 'a';
        $scope.show_drop_sort = false;
        $scope.show_drop_date = false;
        $ionicPlatform.ready(function() {

            //dropdown initialization
            var drop_button = $('.dropdown_custom button');
            var drop_list = $('.dropdown_custom ul');
            drop_list.css('width', drop_button.css('width'))
            drop_list.css('margin-top', '-' + drop_button.css('height'))
            $scope.sort_by_items = {
                'onoma': 'name',
                'poso': 'data.sum',
                'arithmos apod': 'data.count'
            }
            $scope.filter_by_date = {
                '1 hour': '-1 hours',
                '12 hour': '-12 hours',
                '1 day': '-1 days',
                '1 week': '-7 days',
                '1 month': '-1 month',
            }
            $scope.show_drop_sort_func = function() {
                $scope.show_drop_sort = !$scope.show_drop_sort;

            }
            $scope.show_drop_date_func = function() {
                $scope.show_drop_date = !$scope.show_drop_date;

            }
            $scope.sort_by_func = function(key, value) {
                $scope.sort_by_item_key = key;
                $scope.sort_by_item_value = value;
                $scope.show_drop_sort = false;

            }
            $scope.filter_by_date_func = function(key, value) {
                $scope.show_drop_date = false;
                $scope.filter_by_date_item_key = key;
                fetch_results(value);
            }



            $scope.edit = function(category) {
                $scope.category_name = {
                    name: category.name
                };
                $ionicPopup.show({
                    title: 'Επεξεργασια κατηγοριας',
                    template: '<input type="text" autofocus ng-model="category_name.name">',
                    scope: $scope,
                    buttons: [{
                        text: 'Cancel',
                        type: 'btn waves-effect waves-light red'

                    }, {
                        text: 'OK',
                        type: 'btn waves-effect waves-light cyan'
                    }]
                }).then(function(res) {
                    $ionicListDelegate.closeOptionButtons();
                    if ($scope.category_name.name && $scope.category_name.name != category.name) {

                        var new_name = $scope.category_name.name;
                        DB.edit_category(category.id, new_name)
                            .then(function() {
                                category.name = new_name;
                            })
                            .catch(prettyLog)
                    }
                });
            }

            function fetch_results(date_query) {
                DB.get_all_categories().then(function(data) {
                    data.map(function(x) {
                        DB.get_receipts_from_category_extended(x.id, date_query)
                            .then(function(res) {
                                x.data = res;
                            })
                            .catch(prettyLog)

                    })
                    $scope.categories = data;

                }).catch(function(err) {
                    alert(err);
                })
            }
            fetch_results();



        })

    })