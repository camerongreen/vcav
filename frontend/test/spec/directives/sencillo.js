'use strict';

describe('Directive: sencillo', function () {

  // load the directive's module
  beforeEach(module('angGridApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<sencillo></sencillo>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the sencillo directive');
  }));
});
