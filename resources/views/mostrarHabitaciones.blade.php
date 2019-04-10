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
                    <th scope="col">Acciones</th>
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
                    <td><a href="{{ route('habitacion.edit', $habitacion -> id) }}"><button class="btn btn-warning" id="btnEditarHabitacion">Editar</button> </a><a href="{{url('/mantenimiento')}}"><button class="btn btn-danger" id="btnManetnimiento">Mantenimiento</button></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
          <a href="{{url('/addHabitacion')}}"><button id="btnVolver" class="btn btn-info">Volver</button></a>
    </div>
</body>
    <script>
        var app=angular.module('app',[])
        app.controller('ctrl', function($scope,$http){
           $scope.habitaciones = {!! json_encode ($datos->toArray()) !!};
        });
    </script>
</html>