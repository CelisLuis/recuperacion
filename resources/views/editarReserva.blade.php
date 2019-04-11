<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="{{asset('js/moment.min.js')}}" type="text/javascript"></script>
        <title>Modificar habitaciones</title>
        <style type="text/css">
            a:link{text-decoration:none;}
            .danger{color: red;}
            .top{
                padding-top: 40px;
            }
        </style>
    </head>
    <body ng-controller="ctrl" class="container">
        <div class="container top">
            <form name="formEditReservas" enctype="multipart/form-data">    
            <h1>Editar habitación</h1>
                
                <div class="col">
                    <label>Inicio de la reserva:</label>
                    <input type="date" min="{{date('Y-m-d')}}" max="2020-01-01" ng-model="reservaBD.inicio_reserva" ng-disabled="noEditable" required>
                </div>

                <div class="col">
                    <label>Fin de la reserva:</label>
                    <input type="date"  min="{{date('Y-m-d')}}" max="2020-01-01" ng-model="reservaBD.fin_reserva" ng-change="cambioFechaFin()" required>
                </div>

                <div class="col">
                    <label>Nombre de la habitación:</label>
                    <select ng-options="habitacion.value for habitacion in tipoHabitaciones track by habitacion.id" ng-change="verificarHabitacion()" name="habitacion" ng-model="selHabitacion" required>
                        <option value="">Selecciona la habitación que desees</option>
                    </select>
                </div>
                
                <div class="col">
                    <br><button type="button" ng-click="editar()" ng-disabled="!formEditReservas.$valid" class="btn btn-outline-success">EDITAR</button>
                    <a href="{{url('/mostrarReservas')}}"><button type="button" class="btn btn-outline-success" id="btnMostrar">MOSTRAR DATOS</button></a>
                </div>
                
            </form>
        </div>
    </body>
    <script src="{{asset('js/angular.js')}}" type="text/javascript"></script>
</html>

<script>
  var app = angular.module('app', []);
    app.controller('ctrl', function($scope,$http, $filter){
        $scope.tipoHabitaciones=[
            {id:1, value:'Sencilla'},
            {id:2, value:'Junior'},
            {id:3, value:'Presidencial'}
        ]; //Arreglo con las opciones de habitaciones
        $scope.reservaBD={!! json_encode($reservaEdit) !!};//Carga datos en los inputs
        $scope.habitacionBD = {};

        $scope.noEditable = false;
        $scope.precioHabitacion = 0;
        $scope.isReservable = false;
        $scope.alertReserva = false;

        
        $scope.reservaBD.inicio_reserva = new Date ($filter('date')($scope.reservaBD.inicio_reserva));
        $scope.reservaBD.fin_reserva = new Date ($filter('date')($scope.reservaBD.fin_reserva));

        let fecha1 = moment($scope.reservaBD.inicio_reserva);
        let fechaActual = moment();
        $scope.diferenciaDias = fechaActual.diff(fecha1, 'days');
        console.log( moment($scope.reservaBD.inicio_reserva).isSame(fechaActual, 'year') );
        console.log( fechaActual );



        $scope.cambioFechaFin = function() {
            if ( $scope.alertReserva ) {
                alert('Fin de reseravción debe ser mayor a la reserva inicial');
                $scope.alertReserva = false;
            } else {
                $scope.calcularPago();
            }
        }

        $scope.calcularPago = function(){
            let fecha2 = moment($scope.reservaBD.inicio_reserva);
            let fecha3 = moment($scope.reservaBD.fin_reserva);
            $scope.diferenciaDias2 = fecha3.diff(fecha2, 'days');
            console.log($scope.diferenciaDias2);
            if ( $scope.diferenciaDias2 < 0) {
                $scope.reservaBD.fin_reserva = null;
                $scope.alertReserva = true;
            }else if ( $scope.diferenciaDias2 == 0) {
                $scope.reservaBD.costo = $scope.precioHabitacion;
            }else {
                $scope.reservaBD.costo = $scope.diferenciaDias2 * $scope.precioHabitacion;
            }
            
        }
        
        $scope.verificarHabitacion = function() {
            console.log($scope.selHabitacion.id);
            $http.get('/mostrarHabitacion/' + $scope.selHabitacion.id).then(
                function( response ){
                    console.log(response.data);
                    $scope.reservaBD.id_habitacion = $scope.selHabitacion.id;
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
        
        $scope.editar = function() {
            if( $scope.isReservable ) {
                $scope.reservaBD.inicio_reserva = $scope.sacarFecha( $scope.reservaBD.inicio_reserva );
                $scope.reservaBD.fin_reserva = $scope.sacarFecha( $scope.reservaBD.fin_reserva );
                console.log( $scope.reservaBD );
                $http.post('/updateReservas/' + $scope.reservaBD.id, $scope.reservaBD).then(
                    function( response ) {
                    window.location.href="{{url('/mostrarReservas')}}";
                    $scope.habitacion.inicio_reserva=null;
                    $scope.habitacion.fin_reserva=null;
                    }, function( errorResponse ) {

                    }
                )
            }
        }
    });
    
    /*
    //guardar registros
    //Función para vlidar que sólo se ingresen letras
    $scope.limpiar=function(){ //limpia campos despues de agregar 
        $scope.paciente.nombre=null;
        $scope.paciente.apellidos=null;
        $scope.paciente.fechaNac=null;
        $scope.paciente.fechaCita=null;
        $scope.paciente.horario=null;
        $scope.paciente.calcularEdad=null;
        $scope.formPacientes.$setPristine();
    } //limpiar inputs
    $scope.calcularEdad = function clcularEdad(edad) { 
        var ageDifMs = Date.now() - edad.getTime();
        var ageDate = new Date(ageDifMs);
            return Math.abs(ageDate.getUTCFullYear() - 1970);
    }//Calcula la edad a partir de la fecha de nac


function inputLetras(e){ 
       letrasAdmit = " áéíóúabcdefghijklmnñopqrstuvwxyz";//Teclas que se pondrán presionar
       exepciones = "8-32-39-46"; //(BackSpace , flecha izquierda, flecha derecha, Supr).
       tecla_especial = false;
       key = e.keyCode || e.which;
       teclaPress = String.fromCharCode(key).toLowerCase();
       for(var i in exepciones){
            if(key == exepciones[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letrasAdmit.indexOf(teclaPress)==-1 && !tecla_especial){
            console.log("Tecla no admitida");
            return false;
        }
    }

*/
</script>


