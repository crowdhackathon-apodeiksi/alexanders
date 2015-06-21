// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['ionic',
    'ngCordova',
    'LocalStorageModule',
    'App.controllers',
    'Settings.controllers',
    'HomePage.controllers',
    'ScanReceipt.controllers',
    'ReceiptsList.controllers',
    'CategoriesList.controllers',
    'CaptureImage.controllers',
    'PromotionList.controllers',
    'ManualEntryReceipt.controllers',
    'starter.services',
    'ngTagsInput'
])
.constant('API_URL','http://apodeiksi.tk/')

.run(function($ionicPlatform, DB,$interval,api,$state,$ionicPopup,$cordovaLocalNotification) {
    window.prettyLog = function(d) {
        console.log(JSON.stringify(d, null, 2))
    }
    window.iiid = 1;
    $ionicPlatform.ready(function() {
                        window.localStorage.clear();
                        console.log('noti')
                        prettyLog($cordovaLocalNotification.schedule)
                        
        // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
        // for form inputs)
        if (window.cordova && window.cordova.plugins.Keyboard) {
            cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
        }
        if (window.StatusBar) {
            // org.apache.cordova.statusbar required
            StatusBar.styleDefault();
        }
        //DB.seed();
                api.getPromotions().then(function(data){
                    if(data.new_proms.length){
                        var x = data.new_proms[0];
                        cordova.plugins.notification.local.schedule({
                            id: ++window.iiid,
                            title: "Νεα προσφορα απο Cafe Bar",
                            text: x.title
                        });
                        $ionicPopup.show({
                            template: '<img src=""> <p>'+x.title+'</p>',
                            title: 'Νεα προσφορα απο Cafe Ba',
                            cssClass: 'custom-popup animated-popup rubberBand-popup',
                            buttons: [
                                { text: 'OK',type: 'btn-floating btn-large waves-effect waves-light'}
                            ]
                        });
                        $state.go('app.promotions')
                    }
                })    

    });
})

.config(function($stateProvider, $urlRouterProvider, $compileProvider, $httpProvider) {

    $compileProvider.imgSrcSanitizationWhitelist(/^\s*(https?|file|blob|cdvfile):|data:image\//);
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
    $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded';

    var param = function(obj) {
        var query = '',
            name, value, fullSubName, subName, subValue, innerObj, i;

        for (name in obj) {
            value = obj[name];

            if (value instanceof Array) {
                for (i = 0; i < value.length; ++i) {
                    subValue = value[i];
                    fullSubName = name + '[' + i + ']';
                    innerObj = {};
                    innerObj[fullSubName] = subValue;
                    query += param(innerObj) + '&';
                }
            } else if (value instanceof Object) {
                for (subName in value) {
                    subValue = value[subName];
                    fullSubName = name + '[' + subName + ']';
                    innerObj = {};
                    innerObj[fullSubName] = subValue;
                    query += param(innerObj) + '&';
                }
            } else if (value !== undefined && value !== null)
                query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
        }

        return query.length ? query.substr(0, query.length - 1) : query;
    };

    // Override $http service's default transformRequest
    $httpProvider.defaults.transformRequest = [

        function(data) {
            return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
        }
    ];

    $httpProvider.interceptors.push('APIInterceptor');

    $stateProvider

    .state('app', {
        url: "/app",
        abstract: true,
        templateUrl: "templates/menu.html",
        controller: 'AppCtrl'
    })

    .state('app.home', {
        url: "/home",
        views: {
            'menuContent': {
                templateUrl: "templates/home.html",
                controller: 'HomeCtrl'
            }
        }
    })
        .state('app.settings', {
            url: "/home/settings",
            views: {
                'menuContent': {
                    templateUrl: "templates/settings.html",
                    controller: 'SettingsCtrl'
                }
            }
        })

    .state('app.manual_entry', {
        url: "/home/manual_entry/:type:id",
        views: {
            'menuContent': {
                templateUrl: "templates/manual_entry.html",
                controller: 'ManualEntryCtrl'
            }
        }
    })

    .state('app.receipts', {
        url: "/home/receipts",
        views: {
            'menuContent': {
                templateUrl: "templates/receipts.html",
                controller: 'ReceiptsCtrl'
            }
        }
    })
    .state('app.categories', {
        url: "/home/categories",
        views: {
            'menuContent': {
                templateUrl: "templates/categories.html",
                controller: 'CategoriesCtrl'
            }
        }
    })
    .state('app.promotions', {
        url: "/home/promotions",
        views: {
            'menuContent': {
                templateUrl: "templates/promotions.html",
                controller: 'PromotionsCtrl'
            }
        }
    });



    // if none of the above states are matched, use this as the fallback
    $urlRouterProvider.otherwise('/app/home');
});