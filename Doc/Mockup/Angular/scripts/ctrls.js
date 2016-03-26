var SuperCtrl = angular.module("SuperCtrl",[])
            
SuperCtrl.controller("ListCtrl",ListCtrl)  

function ListCtrl($scope)
{
    $scope.students = json;
}

SuperCtrl.controller("DetailCtrl",DetailCtrl)  

function DetailCtrl($scope , $routeParams )
{
    $scope.students = json;
    $scope.whichItem = $routeParams.itemId
}

