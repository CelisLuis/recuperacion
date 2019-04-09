<!DOCTYPE html>
<html lang="es" ng-app="app">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <script src="{{asset('js/angular.js')}}" type="text/javascript"></script>
    <title>Hotel: Marcel</title>
</head>
<body ng-controller="ctrl">
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Habitación</th>
                    <th scope="col">Tipo Cama</th>
                    <th scope="col">Cantidad Camas</th>
                    <th scope="col">Cantidad Cuartos</th>
                    <th scope="col">Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $habitacion)
                <tr>
                    <th>{{ $habitacion->id }}</th>
                    <td>{{$habitacion->tipo_habitacion}}</td>                    
                    <td>{{$habitacion->tipo_cama}}</td>                    
                    <td>{{$habitacion->cantidad_camas}}</td>                    
                    <td>{{$habitacion->cantidad_cuartos}}</td>                    
                    <td>{{$habitacion->precio_habitacion}}</td>                    
                    <td><a href="{{ route('habitacion.edit', $habitacion -> id) }}"><button class="btn btn-primary" id="btnEditarUsuario">Editar</button></a></td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
    <script>
        var app=angular.module('app',[])
        app.controller('ctrl', function($scope,$http){
           $scope.habitaciones = {!! json_encode ($datos->toArray()) !!};
           console.log($scope.habitaciones)
        });
    </script>
</html>