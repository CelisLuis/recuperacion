<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <title>Hotel: Marcel</title>
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
            <form name="formHabitaciones" enctype="multipart/form-data">
                
                <div class="col">
                    <label>Nombre de la habitación:</label>
                    <select ng-options="habitacion.value for habitacion in tipoHabitaciones track by habitacion.id" name="habitacion" ng-model="selHabitacion" required>
                        <option value="">Selecciona la habitación que desees</option>
                    </select>
                </div>
                
                <div class="col">
                    <label>Tipo de cama:</label>
                    <select ng-options="cama.value for cama in tipoCamas track by cama.id" name="cama" ng-model="selCama" required>
                        <option value="">Selecciona la habitación que desees</option>
                    </select>
                </div>
                
                <div class="col">
                    <label>Cantidad de cuartos:</label>
                    <input type="number" ng-model="habitacion.numCuartos" min="1" maxlength="1" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)" required onkeydown="return event.keyCode !== 69 && event.keyCode !== 48 ">
                </div>
                
                <div class="col">
                    <label>Cantidad de camas:</label>
                    <input type="number" ng-model="habitacion.numCamas" min="1" maxlength="1" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)" required onkeydown="return event.keyCode !== 69 && event.keyCode !== 48 ">
                </div>
                
                
                <div class="col">
                    <label>Precio por habitación: $</label>
                    <input type="number" ng-model="habitacion.precioHabitacion" min="100" maxlength="5" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)" required onkeydown="return event.keyCode !== 69">
                </div>
                <div class="col">
                <br><button type="button" ng-click="guardar()" ng-disabled="!formHabitaciones.$valid" class="btn btn-outline-success">GUARDAR</button>
                 <a href="{{url('/mostrar')}}"><button type="button" class="btn btn-outline-success" id="btnMostrar">MOSTRAR DATOS</button></a>
                </div>
            </form>
        </div>
    </body>
    <script src="{{asset('js/angular.js')}}" type="text/javascript"></script>
</html>

<script>
  var app=angular.module('app',[])
    app.controller('ctrl', function($scope,$http){
        $scope.tipoHabitaciones=[
            {id:1, value:'Sencilla'},
            {id:2, value:'Junior'},
            {id:3, value:'Presidencial'}
        ]; //Arreglo con las opciones de habitaciones
        $scope.tipoCamas=[
                {id:1, value:'Individual'},
                {id:2, value:'Matrimonial'},
                {id:3, value:'Queen size'},
                {id:4, value:'King size'}
            ];  //Arreglo con las opciones de tipo de cama
        $scope.selCama = null; 
        $scope.selHabitacion = null;
        $scope.habitacion = {}; //Objeto donde se almacena la info de la habitación 
        
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


