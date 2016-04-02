var MyApp = angular.module("MyApp",[
    'ngRoute',
    'SuperCtrl'
    
])


            
MyApp.config(RouteConnect)

function RouteConnect($routeProvider)
{
    $routeProvider.
	    when("/login", {
                templateUrl:"addon/login.html",
           
    }).
            when("/list", {
                templateUrl:"addon/list.html",
                controller:"ListCtrl"
    }).when("/detail/:itemId", {
        templateUrl:"addon/detail.html",
        controller:"DetailCtrl"
    }).when("/forget", {
        templateUrl:"addon/forget.html",
    })
            .otherwise({
           redirectTo: "/login" 
    })
}
