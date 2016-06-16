/**
 * Created by Andurit-PC on 27.05.2016.
 */
'use strict';
var myApp = angular.module('myApp', ['ngCookies']);
myApp.config(['$httpProvider', function ($httpProvider) {

}]);
myApp.controller('ListCtrl', ['$scope', '$cookies', '$http', function ($scope, $cookies, $http) {

    var listCtrl = {
        candidate: {},
        candidates: [],
        positions: [],
        chosenPositions: [],

        init: function () {
            listCtrl.getCandidates();
            listCtrl.getPositions();
        },
        getCandidates: function () {
            $http.get('api/v1/candidates/getCandidates.php').then(function (res) {
                listCtrl.candidates = res.data;
            });
        },
        getPositions: function () {
            $http.get('api/v1/positions/getPositions.php').then(function (res) {
                listCtrl.positions = res.data;
            });
        },
        getChosenIndex: function(position) {
            return listCtrl.chosenPositions.indexOf(position);
        },
        choosePosition: function (position) {
            $scope.focus = false;
            if (listCtrl.getChosenIndex(position) === -1) {
                listCtrl.chosenPositions.push(position);
            }
        },
        removeFromChosen: function (position) {
            var index = listCtrl.getChosenIndex(position);
            listCtrl.chosenPositions.splice(index, 1);
        },
        addCandidate: function (candidate) {
            // TODO: Add user ID
            candidate.addedBy = 1;
            candidate.positions = listCtrl.chosenPositions;
            $http.post('api/v1/candidates/addCandidate.php', candidate).then(function (res) {
                candidate.id = res.data.candidateId;
                listCtrl.candidates.unshift(candidate);
            });
        },
        setCall: function(candidate) {
            candidate.wasCalled = !candidate.wasCalled;
            var data = {id: candidate.id, value: candidate.wasCalled};
            $http.post('api/v1/candidates/updateWasCalled.php', data).then(function (res) {
                // Check answer!
            });
        },
        setGood: function(candidate) {
            candidate.wasGood = !candidate.wasGood;
            var data = {id: candidate.id, value: candidate.wasGood};
            $http.post('api/v1/candidates/updateWasGood.php', data).then(function (res) {
                // Check answer!
            });
        }

    };

    listCtrl.init();
    $scope.listCtrl = listCtrl;
}]);


