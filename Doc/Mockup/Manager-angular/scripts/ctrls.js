var SuperCtrl = angular.module("SuperCtrl",[])
            

SuperCtrl.controller("StudCtrl",StudCtrl)  

function StudCtrl($scope)
{
    $scope.students = Studjson;
}

SuperCtrl.controller("CompCtrl",CompCtrl)  

function CompCtrl($scope)
{
    $scope.companies = Compjson;
}

SuperCtrl.controller("UserCtrl",UserCtrl)  

function UserCtrl($scope)
{
    $scope.users = Userjson;
}
