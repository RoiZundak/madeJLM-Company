var MyApp = angular.module("MyApp",[
    'ngRoute',
    'SuperCtrl'
    
])


            
MyApp.config(RouteConnect)

function RouteConnect($routeProvider)
{
    $routeProvider.
	    when("/main", {
                templateUrl:"addon/main.html",
           
    }).
            when("/list", {
                templateUrl:"addon/list.html",
               
    })
	.when("/forget", {
        templateUrl:"addon/forget.html",
    })
	.when("/compList", {
        templateUrl:"addon/compList.html",
		 controller:"CompCtrl"
    })
	.when("/studList", {
        templateUrl:"addon/studList.html",
		controller:"StudCtrl"

    })
	.when("/userList", {
        templateUrl:"addon/userList.html",
		controller:"UserCtrl"
    })
            .otherwise({
           redirectTo: "/main" 
    })
}