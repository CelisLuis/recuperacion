<!DOCTYPE html>
<html lang="es" ng-app="app">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="{{asset('js/angular.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/moment.min.js')}}" type="text/javascript"></script>

    <title>Hotel: Marcel</title>
</head>
<body ng-controller="ctrl">
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID de la habitación</th>
                    <th scope="col">Nombre(s)</th>
                    <th scope="col">Apellido(s)</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Inicio de reserva</th>
                    <th scope="col">Final de reserva</th>
                    <th scope="col">Costo</th>
                    <th scope="col">Aciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $reserva)
                <tr>
                    <th>{{ $reserva->id }}</th>
                    <td>{{ $reserva->id_habitacion }}</td>                    
                    <td>{{ $reserva->nombre_cliente }}</td>                    
                    <td>{{ $reserva->apellido_cliente }}</td>                    
                    <td>{{\Carbon\Carbon::parse($reserva->fecha_nacimiento)->diff(\Carbon\Carbon::now())->format('%y') }}</td>
                    <td>{{ $reserva->inicio_reserva }}</td>                    
                    <td>{{ $reserva->fin_reserva }}</td>                                                           
                    <td class="text-success">$ {{ $reserva->costo }}</td>                    
                    <td><a href="{{ route('reserva.edit', $reserva -> id) }}"><button class="btn btn-warning" id="btnEditarReserva">Editar</button> </a></td>
                    <td><a><button class="btn btn-danger" id="btnCancelar" ng-click="bajaReserva( {{ $reserva }} )">Cancelar</button></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
          <a href="{{url('/addReservas')}}"><button id="btnVolver" class="btn btn-info">Volver</button></a>
    </div>

    
</body>
    <script>
        var app=angular.module('app',[])
        app.controller('ctrl', function($scope,$http, $filter){
           $scope.habitaciones = {!! json_encode ($datos->toArray()) !!};
           $scope.habitacionUpdate = {};
           $scope.minimaCuartos = 2;
            
           $scope.bajaReserva = function( objetoReserva ) {
               console.log( objetoReserva );
               let fechaActual = new Date();
               let inicioReserva = new Date($filter('date')(objetoReserva.inicio_reserva));
               let finReserva = new Date($filter('date')(objetoReserva.fin_reserva));

               if( inicioReserva < fechaActual ) {
                   if( confirm('¿Desea cancelar?') ) {
                        $http.get('/mostrarHabitacion/' + objetoReserva.id_habitacion).then(
                        function( response ){
                            console.log(response.data);
                            let fecha1 = moment(objetoReserva.inicio_reserva);
                            let fecha2 = moment(fechaActual);
                            $scope.diferenciaDias = fecha2.diff(fecha1, 'days');
                            if( $scope.diferenciaDias > 0) {
                                objetoReserva.totalPagar = $scope.diferenciaDias * response.data.precio_habitacion;
                                console.log($scope.diferenciaDias, objetoReserva.totalPagar);
                                let cantidadPagar = prompt('Total a pagar: '+ objetoReserva.totalPagar);
                                if(!isNaN(cantidadPagar) && cantidadPagar != null && cantidadPagar != ""){
                                    if( cantidadPagar == objetoReserva.totalPagar ) {
                                        alert('Gracias por su visita');
                                        $scope.updateDelete( response.data, objetoReserva );
                                        return;
                                    }else {
                                        objetoReserva.totalPagar = objetoReserva.totalPagar - cantidadPagar;
                                        cantidadPagar = prompt('Falta pagar: '+ objetoReserva.totalPagar);
                                        objetoReserva.totalPagar = objetoReserva.totalPagar - cantidadPagar;
                                        if ( objetoReserva.totalPagar == 0 ){
                                            alert('Gracias por su visita');
                                            $scope.updateDelete( response.data, objetoReserva );
                                            location.reload();
                                            return;
                                        }
                                    }
                                    }else{
                                        alert('Favor de ingresar un número válido');
  	                                 }
                                }else {
                                    alert( 'No se puede cancelar el mismo día' );
                                    return;
                            }
                        }, function( errorResponse) {

                        })
                   } 
               } else {
                    console.log("else");
                    if ( confirm('No tiene costo, ¿Desea cancelar?')) {
                        $http.get('/mostrarHabitacion/' + objetoReserva.id_habitacion).then(
                        function( response ) {
                            console.log( response.data );
                            alert('Gracias por su visita');
                            $scope.updateDelete( response.data, objetoReserva );
                            return;
                        }, function( errorResponse ) {

                        })
                    }
                    
               }
           }

           $scope.updateDelete = function( habitacionUpdate, reservaDelete ) {
               
                console.log( habitacionUpdate, reservaDelete );
                $http.post('/borrarReserva/' + reservaDelete.id).then(
                function(response){
                    habitacionUpdate.cantidad_cuartos = habitacionUpdate.cantidad_cuartos + 1;
                    $http.post('/updateCuartos/' + habitacionUpdate.id, habitacionUpdate).then(
                    function(response){
                        location.reload();
                    },function(errorResponse){
                        alert("Ha ocurrido un error al modificar");
                    });
                }, function(errorResponse){
                    
                })
           }
        });
    </script>
</html>