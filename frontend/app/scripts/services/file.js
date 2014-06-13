(function () {
  'use strict';

  angular.module('angGridApp')
    .factory('fileService', ['$http', '$q', function ($http, $q) {

      var url = 'http://orservice.test:8080/fileinfo';

      var makePromise = function (url, params) {
        var deferred = $q.defer();

        var config = {
          params: params
        };

        $http.get(url, config)
          .success(function (data) {
            deferred.resolve(data);
          }).error(function (reason) {
            deferred.reject(reason);
          });

        return deferred.promise;
      };

      var getFile = function (file) {
        if (file) {
          var rurl = url + '/' + file;
          return makePromise(rurl);
        }
      };

      // Public API
      return {
        getFile: getFile
      };
    }]);
})();
