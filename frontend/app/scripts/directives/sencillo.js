'use strict';

angular.module('angGridApp')
  .directive('sencillo', function () {
    return {
      template: '<div hamster="hamster"></div>',
      restrict: 'E',
      link: function postLink(scope, element, attrs) {
        element.text("Text:" + scope.hamster);
      }
    };
  });
