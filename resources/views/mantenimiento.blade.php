<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <title>Habitaciones en mantenimiento</title>
        <style type="text/css">
            a:link{text-decoration:none;}
            .danger{color: red;}
            .top{
                padding-top: 40px;
            }
        </style>
    </head>
    <body>
        <div ng-controller="ctrl" class="container top">
            <form name="formMantenimientos" enctype="multipart/form-data">
            
                <div class="col">
                    <label>Id de la habitación:</label>
                    <input type="text" ng-disabled="true" required>
                </div>
                
                <div class="col">
                    <label>Nombre de la habitación:</label>
                    <input type="text" ng-disabled="true" required>
                </div>
                
                <div class="col">
                    <label>Cantidad de cuartos:</label>
                    <input type="number" ng-disabled="true" required>
                </div>
                
                <div class="col">
                    <label>Ingrese la cantidad de cuartos que irán a mantenimiento:</label>
                    <input type="number" ng-model="habitacion.numCuartos" min="1" maxlength="1" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)" required onkeydown="return event.keyCode !== 69 && event.keyCode !== 48" ng-required="true">
                </div>
                
                
                <div class="col">
                <br><button type="button" ng-click="guardar()" ng-disabled="!formMantenimientos.$valid" class="btn btn-success">GUARDAR</button>
                 <a href="{{url('/mostrar')}}"><button type="button" class="btn btn-info" id="btnMostrar">MOSTRAR DATOS</button></a>
                </div>
            </form>
        </div>
    </body>
    <script src="{{asset('js/angular.js')}}" type="text/javascript"></script>
</html>

<script>
  var app=angular.module('app',[])
    app.controller('ctrl', function($scope,$http){
        $scope.mantenimiento = {}; //Objeto donde se almacena la info del mantenimineto 
        
        $scope.guardar = function() {
            $scope.habitacion.habitacion = $scope.selHabitacion.value;
            $scope.habitacion.cama = $scope.selCama.value;
            $http.post('/save', $scope.habitacion).then(
                function(response){
                    $scope.selCama = null;
                    $scope.selHabitacion = null;
                    $scope.habitacion = {};
                }, function (errorResponse) {
                    
                });
        }

    });
</script>


