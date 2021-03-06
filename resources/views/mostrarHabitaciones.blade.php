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
                    <td>{{ $habitacion->nombre_habitacion}}</td>                    
                    <td>{{ $habitacion->tipo_cama }}</td>                    
                    <td>{{ $habitacion->cantidad_camas }}</td>                    
                    <td>{{ $habitacion->cantidad_cuartos }}</td>                    
                    <td class="text-success">$ {{ $habitacion->precio_habitacion }}</td>                    
                    <td><a href="{{ route('habitacion.edit', $habitacion -> id) }}"><button class="btn btn-warning" id="btnEditarHabitacion">Editar</button> </a></td>
                    <td><a><button class="btn btn-danger" id="btnManetnimiento" ng-click="mandarMantenimiento(  {{ $habitacion }} )">Eliminar</button></a></td>
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
           $scope.minimaCuartos = 2;
           $scope.mostrarBaja = false; //apartado para dar de baja
            
           $scope.mandarMantenimiento = function( objetoRecibido ) {
               let cantidadBajar = prompt ( '¿Cuantos cuartos desea dar de baja?' );
               if(!isNaN(cantidadBajar) && cantidadBajar != null && cantidadBajar != ""){
                   prompt( 'Describe el motivo: ');
                   let confirmacion = confirm( '¿Esta seguro de quitar ' + cantidadBajar + ' cuartos?');
                   console.log( cantidadBajar );
                   if( confirmacion ) {
                       objetoRecibido.cantidad_cuartos = objetoRecibido.cantidad_cuartos - cantidadBajar;
                       if ( objetoRecibido.cantidad_cuartos < $scope.minimaCuartos ){
                           alert ( 'No se puede quitar todos los cuartos' );
                           return;
                       }else {
                            $http.post('/updateCuartos/' + objetoRecibido.id, objetoRecibido).then(
                            function(response){
                                alert("¡Registro modificado con éxito!");
                                location.reload();
                            },function(errorResponse){
                                alert("Ha ocurrido un error al modificar");
                            });
                       }
                   }  
  	           }else{
                   alert('Favor de ingresar un número válido');
  	           }
               if ( !cantidadBajar ){
                   return;
               }
           }
        });
    </script>
</html>