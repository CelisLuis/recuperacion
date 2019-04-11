<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="{{asset('js/angular.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/moment.min.js')}}" type="text/javascript"></script>

        <title>Reservaciones</title>
        <style type="text/css">
            a:link{text-decoration:none;}
            .danger{color: red;}
            .top{
                padding-top: 40px;
            }
        </style>
    </head>
    <body ng-controller="ctrl">
        <div  class="container top">
            <form name="formReservaciones" enctype="multipart/form-data">
                <h3>Nueva reservación</h3>
                <div class="col">
                    <label>Nombre(s):</label>
                    <input type="text" required maxlength="50" ng-model="nuevaReserva.nombre_cliente">
                </div>
                <div class="col">
                    <label>Apellido(s):</label>
                    <input type="text" required maxlength="50" ng-model="nuevaReserva.apellido_cliente">
                </div>
                <div class="col">
                    <label>Fecha de nacimiento:</label>
                <input type="date" min="1869-01-01" max="{{ Date('Y-m-d')}}" ng-change="calcularEdad()" required ng-model="nuevaReserva.fecha_nacimiento">
                </div>
                <div class="col">
                    <label>Edad:</label>
                    <input type="number" disabled maxlength="3" ng-model="mostrarEdad">
                </div>
                <div class="col">
                    <label>Inicio de reservación:</label>
                <input type="date" min="{{Date('Y-m-d')}}" max="2020-01-01" required ng-model="nuevaReserva.inicio_reserva">
                </div>
                <div class="col">
                    <label>Fin de reservación:</label>
                    <input type="date" min="{{Date('Y-m-d')}}" max="2020-01-01" ng-change="cambioFechaFin()" required ng-model="nuevaReserva.fin_reserva">
                </div>
                <div class="col">
                    <label>Habitaciones:</label>
                    <select ng-options="habitacion.value for habitacion in tipoHabitaciones track by habitacion.id" name="habitacion" ng-change="verificarHabitacion()" ng-model="selHabitacion" required>
                        <option value="">Selecciona la habitación que desees</option>
                    </select>
                </div>
                <div class="col">
                    <label>Total $: </label>
                    <input type="number" disabled maxlength="5" ng-model="nuevaReserva.totalPagar">
                </div>
                <div class="col">
                <br>
                <button type="button" ng-click="guardar()" ng-disabled="!formReservaciones.$valid" class="btn btn-success">GUARDAR</button>
                <a href="{{url('/mostrarReservaciones')}}"><button type="button" class="btn btn-info" id="btnMostrar">Reservaciones</button></a>
                </div>
            </form>
        </div>
    </body>


    <script>
  var app=angular.module('app',[])
    app.controller('ctrl', function($scope,$http){
        $scope.reservasBD = {!! json_encode ($datos) !!};

        $scope.habitacionBD = {};
        $scope.tipoHabitaciones=[
            {id:1, value:'Sencilla'},
            {id:2, value:'Junior'},
            {id:3, value:'Presidencial'}
        ];
        $scope.nuevaReserva = {};
        //$scope.nuevaReserva.inicio_reserva = new Date();
        //$scope.nuevaReserva.fin_reserva = new Date();
        $scope.precioHabitacion = 0;
        $scope.mostrarEdad = null;
        $scope.isLegal = false;
        $scope.isReservable = false;
        $scope.selHabitacion = null;
        console.log($scope.reservasBD);


        $scope.calcularEdad = function() {
            console.log($scope.nuevaReserva.fecha_nacimiento);
            $scope.mostrarEdad = moment().diff($scope.nuevaReserva.fecha_nacimiento, 'years');
            $scope.isLegal = ($scope.mostrarEdad >= 18);
            console.log($scope.isLegal);
        }

        $scope.cambioFechaFin = function() {
            $scope.calcularPago();
        }

        $scope.calcularPago = function(){
            let fecha1 = moment($scope.nuevaReserva.inicio_reserva);
            let fecha2 = moment($scope.nuevaReserva.fin_reserva);
            $scope.diferenciaDias = fecha2.diff(fecha1, 'days');
            if ( $scope.diferenciaDias == 0) {
                $scope.nuevaReserva.totalPagar = $scope.precioHabitacion;
            }else {
                $scope.nuevaReserva.totalPagar = $scope.diferenciaDias * $scope.precioHabitacion;
            }
            
        }
        
        $scope.verificarHabitacion = function() {
            console.log($scope.selHabitacion.id);
            $http.get('/mostrarHabitaciones/' + $scope.selHabitacion.id).then(
                function( response ){
                    console.log(response.data);
                    $scope.habitacionBD.id = response.data.id;
                    $scope.habitacionBD.cantidad_cuartos = response.data.cantidad_cuartos;
                    $scope.precioHabitacion = response.data.precio_habitacion;
                    $scope.calcularPago();
                    if( response.data.cantidad_cuartos > 0 ){
                        $scope.isReservable = true;
                        console.log( 'entro ');
                    }
                }, function( errorResponse) {

                }
            );
        }

        $scope.sacarFecha = function( fecha ) {
            let dia = fecha.getDate();
            let mes = fecha.getMonth() + 1;
            let anio = fecha.getFullYear();
            return anio + '/' + mes + '/' + dia;
        }

        $scope.guardar = function() {
            $scope.nuevaReserva.id_habitacion = $scope.selHabitacion.id;
            $scope.nuevaReserva.inicio_reserva = $scope.sacarFecha( $scope.nuevaReserva.inicio_reserva );
            $scope.nuevaReserva.fin_reserva = $scope.sacarFecha( $scope.nuevaReserva.fin_reserva );
            $scope.nuevaReserva.fecha_nacimiento = $scope.sacarFecha( $scope.nuevaReserva.fecha_nacimiento );


            console.log($scope.nuevaReserva.inicio_reserva);
            if ( $scope.isReservable && $scope.isLegal ){
                console.log($scope.nuevaReserva);
                $http.post('/reservar', $scope.nuevaReserva).then(
                    function(response){
                        $scope.habitacionBD.cantidad_cuartos = $scope.habitacionBD.cantidad_cuartos - 1;
                        $http.post('/updateCuartos/' + $scope.habitacionBD.id, $scope.habitacionBD).then(
                        function(response){
                            location.reload();
                        },function(errorResponse){
                            alert("Ha ocurrido un error al modificar");
                        });
                    }, function(errorResponse){
                        
                    }
                )
            }else if ( !$scope.isLegal ) {
                alert('Debes ser mayor de edad');
                location.reload();
                return;
            }else {
                alert('Habitaciones sin disponibilidad');
                location.reload();
                return;
            }
        }
    });
    
</script>
</html>