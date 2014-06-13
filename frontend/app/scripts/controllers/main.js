'use strict';

angular.module('angGridApp')
  .controller('MainCtrl', ['$scope', 'fileService', function ($scope, fileService) {
    $scope.files = [
      '1Video_2Audio_2SUBs(timed text streams).mp4',
      //'container.qcif',
      'jpeg2000_mxf_first_10mb.mxf',
      'mpeg4conformance.mp4'
    ];

    $scope.update = function() {
      $scope.gdata = fileService.getFile($scope.myFile);
    }
  }]);
