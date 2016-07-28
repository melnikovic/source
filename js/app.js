/**
 * Created by Andurit-PC on 27.05.2016.
 */
'use strict';
var myApp = angular.module('myApp', ["ngRoute", 'ngCookies']);
myApp.config(function ($routeProvider) {
    $routeProvider
        .when('/login', {
            templateUrl: 'view/login.html',
            controller: 'LoginCtrl',
            isLogin: true
        })
        .when("/register", {
            templateUrl: 'view/register.html',
            controller: 'RegisterCtrl'
        })
        .when("/home", {
            templateUrl: 'view/home.html',
            controller: 'ListCtrl'
        })
        .when("/statistic", {
            templateUrl: 'view/statistic.html',
            controller: 'StatisticCtrl'
        })
        .otherwise({
            redirectTo: '/home'
        });
});
myApp.run(function($rootScope, $location, $cookies) {
    $rootScope.$on('$routeChangeStart', function (event, next) {
        var userAuthenticated = null; // Default value
        var user = $cookies.getObject('user');
        if (typeof user !== 'undefined' && user.token !== null){
            // If user login with correct credentials
            userAuthenticated = true;
        }
        if (!userAuthenticated && !next.isLogin) {
            /* You can save the user's location to take him back to the same page after he has logged-in */
            $rootScope.savedLocation = $location.url();

            $location.path('/login');
        }
    });
});