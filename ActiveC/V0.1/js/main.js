/**
 * Main AngularJS Web Application
 */
var app = angular.module('tutorialWebApp', [
  'ngRoute'
]);
/**
 * Configure the Routes
 */
app.config(['$routeProvider', function ($routeProvider) {
  $routeProvider
      // Home
      .when("/", {templateUrl: "partials/login.php", controller: "UserNotConnected"})
      // Pages
      .when("/about", {templateUrl: "partials/about.html", controller: "PageCtrl"})
      .when("/login", {templateUrl: "partials/login.php", controller: "UserNotConnected"})
      .when("/faq", {templateUrl: "partials/faq.html", controller: "PageCtrl"})
      .when("/main", {templateUrl: "partials/main.php", controller: "PageCtrl"})
      .when("/forgot", {templateUrl: "partials/forgot.html", controller: "PageCtrl"})
	  .when("/services", {templateUrl: "partials/services.html", controller: "PageCtrl"})
      .when("/contact", {templateUrl: "partials/contact.php", controller: "PageCtrl"})
	  .when("/404", {templateUrl: "partials/404.html", controller: "PageCtrl"})
      // Blog
      .when("/blog", {templateUrl: "partials/blog.html", controller: "BlogCtrl"})
      .when("/blog/post", {templateUrl: "partials/blog_item.html", controller: "BlogCtrl"})
      // else 404
      .otherwise({redirectTo: "404"});
}]);

/**
 * Controls the Blog
 */
app.controller('BlogCtrl', function (/* $scope, $location, $http */) {
  console.log("Blog Controller reporting for duty.");
});

/**
 * Controls all other Pages
 */
app.controller('PageCtrl', function (/* $scope, $location, $http */) {
  console.log("Page Controller reporting for duty.");

  // Activates the Carousel
  $('.carousel').carousel({
    interval: 5000
  });
  $("#main_wrap").ready( function () {
    $("#show_std").toggle();
  });
  $("#std_info").click(function(){
   /* $("#show_std").toggle("slow", function() {
      // Animation complete.
    });*/
  });
  // Activates Tooltips for Social Links
  $('.tooltip-social').tooltip({
    selector: "a[data-toggle=tooltip]"
  })
});


/*




CHANGE THIS !




 */
app.controller('UserNotConnected', function ($scope, $http, $routeParams, $location, student, $rootScope) {
  "use strict";
  Company.init().success(function (data) {
    $rootScope.studentData = data;
    if ($rootScope.studentData !== false) {
      $location.path("/profile");
    }
  });

  $scope.register = function () {
    Company.register($scope.data.register).success(function (data) {
      if (data.status === 'error') {
        $scope.alerts.register = {type: 'danger', msg: data.errors.join('<br>')};
      } else {
        $scope.alerts.register = {type: 'success', msg: 'Activation mail sent'};
      }
    });
  };

  $scope.login = function () {
    console.log('login company');
    Company.login($scope.data.login).success(function (data) {
      console.log('login2 company');
      if (data.status === 'error') {
        $scope.alerts.login = {type: 'danger', msg: data.errors.join('<br>')};
      } else {
        $scope.alerts.login = {type: 'success', msg: 'Success'};
        $location.path("/profile");
      }
    });
  };

  $scope.resetPassword = function () {
    Company.resetPassword($scope.data.resetPassword.Email).success(function (data) {
      if (data.status === 'error') {
        $scope.alerts.resetPassword = {type: 'danger', msg: data.errors.join('<br>')};
      } else {
        $scope.alerts.resetPassword = {type: 'success', msg: 'A link was sent to your mail, you can reset your password with it'};
      }
    });
  };
  $scope.newPassword = function () {
    if($scope.data.newPassword.password !== $scope.data.newPassword.password2){
      $scope.alerts.newPassword = {type: 'danger', msg: 'Passwords does not match'};
    } else {
      Company.newPassword($routeParams.hash,{Password: $scope.data.newPassword.password}).success(function (data) {
        if (data.status === 'error') {
          $scope.alerts.newPassword = {type: 'danger', msg: data.errors.join('<br>')};
        } else {
          $scope.alerts.newPassword = {type: 'success', msg: 'Password changed'};
        }
      });
    }
  };

  console.log(student);
});

app.controller('UserConnected', function ($scope, $http, $routeParams, $location, student, $rootScope) {
  "use strict";
  console.log('company connected controller');
  Company.init().success(function (data) {
    $rootScope.studentData = data;
    if ($rootScope.studentData === false) {
      $location.path("/login");
    }
  });
  $scope.logOut = function () {
    Company.logOut().success(function (data) {
      console.log(data);
      if (data.status === 'success') {
        $location.path("/login");
      }
    });
  };
  $scope.changePassword = function () {
    Company.changePassword($scope.data.changePassword).success(function (data) {
      console.log(data);
      if (data.status === 'error') {
        $scope.alerts.changePassword = {type: 'danger', msg: data.errors.join('<br>')};
      } else {
        $scope.alerts.changePassword = {type: 'success', msg: 'Your password was change successfully'};
      }
    });
  };

});