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
        </style>
    </head>
    <body>
        <div ng-controller="ctrl" class="container">
            <form name="formPacientes" enctype="multipart/form-data">
                <div class="col">
                    <label>Nombre de la habitación</label>
                    <select ng-options="habitacion.value for habitacion in tipoHabitaciones track by habitacion.id" name="habitacion" ng-model="habitacion" required>
                <option value="">Selecciona la habitación que desees</option></select>
                </div>
                <div class="col">
                    <label>Tipo de cama</label>
                    <select ng-options="cama.value for cama in tipoCamas track by cama.id" name="cama" ng-model="cama" required>
                <option value="">Selecciona la habitación que desees</option></select>
                </div>
                <div class="col">
                    <label>Cantidad de camas</label>
                    <input type="number" ng-model="numCamas" maxlength="1">
                </div>
                <div class="col">
                    <label>Cantidad de cuartos</label>
                    <input type="number" ng-model="numCuartos" maxlength="1">
                </div>
                <div class="col">
                    <label>Precio por habitación</label>
                    <input type="number" ng-model="precioHabitacion" maxlength="6">
                </div>
                <div class="col">
                <br><button type="button" ng-click="guardar()" ng-disabled="!formPacientes.$valid" class="btn btn-outline-success">GUARDAR</button>
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
        ]; 
      $scope.tipoCamas=[
            {id:1, value:'Individual'},
            {id:2, value:'Matrimonial'},
            {id:3, value:'Queen size'},
            {id:4, value:'King size'}
        ];
      
    $scope.guardar=function(){
        $http.post('/save',$scope.paciente).then(
            function(response){
                alert("Registro completado");
                $scope.limpiar();
            },function(errorResponse){

            });
        } 
    
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

});
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


