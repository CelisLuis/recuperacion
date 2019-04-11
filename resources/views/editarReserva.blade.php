<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
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
                    <input type="date" ng-model="reserva.inicio_reserva" required>
                </div>

                <div class="col">
                    <label>Fin de la reserva:</label>
                    <input type="date" ng-model="reserva.fin_reserva" required>
                </div>

                <div class="col">
                    <label>Nombre de la habitación:</label>
                    <select ng-options="habitacion.value for habitacion in tipoHabitaciones track by habitacion.id" name="habitacion" ng-model="selHabitacion" required>
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
        $scope.reserva = {!! json_encode($reservaEdit->toArray()) !!}; //Objeto donde se almacena la info de la habitación 
        $scope.reservaBD={!! json_encode($reservaEdit) !!};//Carga datos en los inputs
        $scope.reserva.inicio_reserva = new Date ($filter('date')($scope.reserva.inicio_reserva));
        $scope.reserva.fin_reserva = new Date ($filter('date')($scope.reserva.fin_reserva));
      
        
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


