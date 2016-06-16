"use strict";
myApp.controller('LoginCtrl', ['$scope', '$cookies', '$http', function ($scope, $cookies, $http) {

    var sgLogin = {
        login: function(email, password) {
            var data = {'userName':email, 'password': password};
            $http.post('api/v1/users/login.php', data).then(function (res) {
                $cookies.put('user', res.data);
                $http.defaults.headers.common.Authorization = 'Bearer '+res.data.token;
            });
        }

    };

    $scope.sgLogin = sgLogin;
}]);
