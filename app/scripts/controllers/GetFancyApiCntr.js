app.controller('GetFancyApiCntr', function ($scope, $http, $stateParams, Dialog, $rootScope, sessionService,$filter) {
    $scope.MatchId=$stateParams.MatchId;
    $scope.GetFancy=function(){
        $http.get("http://13.234.26.15:8080/fancy?sportid=4"+ "&eventid=" +$stateParams.MatchId).then(function successCallback(response){
            debugger;
            $scope.apiFancy = response.data.result;
        }).then(function(apiFancy){
            $http.get("Lstsavemstrcontroller/GetFancyOnHeader/"+$stateParams.MatchId).then(function successCallback(response){
                debugger;
                $scope.fancyFromDb = response.data.getFancy;
                $scope.apiFancy.find(function(item,index){
                    if($scope.fancyFromDb.length >0){
                        var fileterVal = $filter('filter')($scope.fancyFromDb, { marketId: item.id })[0];
                        if(fileterVal != angular.isUndefinedOrNull){
                            item.selected=true;
                        }else{
                            item.selected=false;
                            if(item.btype == "LINE") {
                                $scope.saveFancyInit(item).then(function(msg) {
                                    item.selected = true;
                                });
                            }
                        }
                    }else{
                        item.selected=false;
                        if(item.btype == "LINE") {
                            $scope.saveFancyInit(item).then(function(msg) {
                                item.selected = true;
                            });
                        }
                    }
                });
            });

        });
    }
    $scope.GetFancy();
    $scope.saveFancy = function (FancyData) {
        debugger;
        if(FancyData.runners[0].back[0].price==100){
            var PointDiff=10;
        }else{
            var PointDiff= 100 - parseInt(FancyData.runners[0].back[0].price);
        }
        var formData = {
            HeadName: FancyData.name,
            remarks: 'N/A',
            mid: $stateParams.MatchId,
            fancyType: 2,
            date: FancyData.lastUpdateTime,
            time: FancyData.lastUpdateTime,
            inputYes: FancyData.runners[0].back[0].line,
            inputNo: FancyData.runners[0].lay[0].line,
            sid:FancyData.eventTypeId,
            NoLayRange:FancyData.runners[0].lay[0].price,
            YesLayRange:FancyData.runners[0].back[0].price,
            RateDiff:1,
            MaxStake:9999999999999,
            PointDiff:PointDiff,
            marketId: FancyData.id,
            isApi : 1,
        }
        var url = BASE_URL + "Createmastercontroller/SaveFancy";
        $http.post(url, formData).success(function (response) {
            $scope.message= response.message;
            alert(response.message);
            $scope.GetFancy();
        });

    }

    $scope.saveFancyInit = function (FancyData) {
        debugger;
        if(FancyData.runners[0].back.length == 0 || FancyData.runners[0].back[0].price==100){
            var PointDiff=10;
        }else{
            var PointDiff= 100 - parseInt(FancyData.runners[0].back[0].price);
        }

        var ipYes = 100;
        var rangeYes = 100;
        if(FancyData.runners.length > 0) {
            if(FancyData.runners[0].back.length > 0) {
                ipYes = FancyData.runners[0].back[0].line;
                rangeYes = FancyData.runners[0].back[0].price;
            }
        }

        var ipNo = 100;
        var rangeNo = 100;
        if(FancyData.runners.length > 0) {
            if(FancyData.runners[0].lay.length > 0) {
                ipNo = FancyData.runners[0].lay[0].line;
                rangeNo = FancyData.runners[0].lay[0].price;
            }
        }

        var formData = {
            HeadName: FancyData.name,
            remarks: 'N/A',
            mid: $stateParams.MatchId,
            fancyType: 2,
            date: FancyData.lastUpdateTime,
            time: FancyData.lastUpdateTime,
            inputYes: ipYes,
            inputNo: ipNo,
            sid:FancyData.eventTypeId,
            NoLayRange: rangeNo,
            YesLayRange: rangeYes,
            RateDiff:1,
            MaxStake:9999999999999,
            PointDiff:PointDiff,
            marketId: FancyData.id,
            isApi : 1,
        }
        var url = BASE_URL + "Createmastercontroller/SaveFancy";
        return $http.post(url, formData).success(function (response) {
            return response.message;
        });

    }
});