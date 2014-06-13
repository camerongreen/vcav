'use strict';

angular.module('angGridApp', ['ngGrid'])
  .config(function ($routeProvider, $httpProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });

    delete $httpProvider.defaults.headers.common['X-Requested-With'];
  });
