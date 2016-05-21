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
    .when("/", {templateUrl: "partials/login.html", controller: "PageCtrl"})
    // Pages
      .when("/about", {templateUrl: "partials/about.html", controller: "PageCtrl"})
      .when("/login", {templateUrl: "partials/login.html", controller: "PageCtrl"})
      .when("/faq", {templateUrl: "partials/faq.html", controller: "PageCtrl"})
      .when("/main", {templateUrl: "partials/main.php", controller: "PageCtrl"})
      .when("/forgot", {templateUrl: "partials/forgot.php", controller: "PageCtrl"})
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