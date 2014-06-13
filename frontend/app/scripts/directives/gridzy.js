'use strict';

angular.module('angGridApp')
  .directive('gridzy', function ($compile) {
    return {
      template: '<div></div>',
      replace: true,
      restrict: 'E',
      link: function (scope, element, attrs) {
        function makeSubDir(gdata) {
          scope.gdata = gdata;
          scope.gopts = {data: "gdata"};
          element.append('<div ng-grid="gopts"></div>');
          $compile(element.contents())(scope);
        }

        scope.$watch("gdata", function (gdata) {
          if (angular.isArray(gdata)) {
            makeSubDir(gdata);
          }
        });
      }
    };
  });
