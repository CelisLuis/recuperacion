<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="{{asset('js/angular.js')}}" type="text/javascript"></script>

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
            <form name="formHabitaciones" ng-show="mostrarFormAgregar" enctype="multipart/form-data">
                <h3>Agregar Habitación</h3>
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
                    <input type="number" name="cuartos" ng-model="habitacion.numCuartos" min="1" max="30" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)" required onkeydown="return event.keyCode !== 69 && event.keyCode !== 48 ">
                </div>
                
                <div class="col">
                    <label>Cantidad de camas:</label>
                    <input type="number" name="camas" ng-model="habitacion.numCamas" min="1" max="5" maxlength="1" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)" required onkeydown="return event.keyCode !== 69 && event.keyCode !== 48 ">
                </div>
                
                
                <div class="col">
                    <label>Precio por habitación: $</label>
                    <input type="number" name="precios" ng-model="habitacion.precioHabitacion" min="100" maxlength="5" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)" required onkeydown="return event.keyCode !== 69">
                </div>
                <div class="col">
                <br><button type="button" ng-click="guardar()" ng-disabled="!formHabitaciones.$valid" class="btn btn-success">GUARDAR</button>
                 <a href="{{url('/mostrar')}}"><button type="button" class="btn btn-info" id="btnMostrar">MOSTRAR DATOS</button></a>
                </div>
            </form>


            <!-- FORM PARA MOSTRAR CUANDO SE VAYA ACTUALIZAR-->
            <form name="formHabitacionesActualizar" ng-show="mostrarFormActualizar" enctype="multipart/form-data">
                <h3>Actualizar cantidad de cuartos</h3>
                <div class="col">
                    <label>Tipo de habitación:</label>
                    <input type="text" ng-model="habitacionActualizar.nombre_habitacion" disabled>
                </div>
                <div class="col">
                    <label>Tipo de camas:</label>
                    <input type="text" ng-model="habitacionActualizar.tipo_cama" disabled>
                </div>
                <div class="col">
                    <label>Cantidad de Cuartos</label>
                    <input type="text" ng-model="habitacionActualizar.cantidad_cuartos" disabled>
                </div>
                <div class="col">
                        <label>Agregar más cuartos: </label>
                        <input type="number" ng-model="habitacion.numCuartos" min="1" max="20" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)" required onkeydown="return event.keyCode !== 69 && event.keyCode !== 48 ">                    </div>
                <div class="col">
                    <label>Cantidad de Camas</label>
                    <input type="text" ng-model="habitacionActualizar.cantidad_camas" disabled>
                </div>
                <div class="col">
                    <label>Precio:</label>
                    <input type="text" ng-model="habitacionActualizar.precio_habitacion" disabled>
                </div>
                <br>
                <button type="button" ng-click="editarCuartos()" ng-disabled="!formHabitaciones.$valid" class="btn btn-success">ACTUALIZAR</button>
                <br>
                <small><b> OJO: </b> Si desea modificar otras opciones ir al apartado mostrar habitaciones</small>
            </form>
        </div>
    </body>
</html>

<script>
  var app=angular.module('app',[])
    app.controller('ctrl', function($scope,$http){
        $scope.habitacionesBD = {!! json_encode ($datos) !!};
        $scope.habitacionActualizar = {};
        $scope.habitacion = {}; //Objeto donde se almacena la info de la habitación 

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

        //Apartado mostrar cuartos 
        $scope.mostrarCantidadCuartos = false;
        $scope.mostrarFormAgregar = true;
        $scope.mostrarFormActualizar = false;
        $scope.cantidadCuartosBD = null;
        
        $scope.guardar = function() {
            $scope.habitacion.habitacion = $scope.selHabitacion.value;
            $scope.habitacion.cama = $scope.selCama.value;
            if( $scope.ejecutarValidaciones() ) {
                let resultado = confirm( 'Ya hay registro identico, ¿Desea actualizar? ');
                if ( resultado ) { 
                    $scope.mostrarFormAgregar = false;
                    $scope.mostrarFormActualizar = true;
                }
            }else {
                $http.post('/save', $scope.habitacion).then(
                function(response){
                    $scope.selCama = null;
                    $scope.selHabitacion = null;
                    $scope.habitacion = {};
                    location.reload();
                }, function (errorResponse) {
                    
                });
            }
        }

        $scope.ejecutarValidaciones = function() {
            console.log( $scope.habitacion );
            for (let i = 0; i < $scope.habitacionesBD.length; i++ ){
                if ($scope.selHabitacion.value == $scope.habitacionesBD[i].nombre_habitacion) {
                    $scope.mostrarCantidadCuartos = true;
                    $scope.cantidadCuartosBD = $scope.habitacionesBD[i].cantidad_cuartos;
                    $scope.habitacionActualizar = $scope.habitacionesBD[i];
                    return true;
                    break;
                    
                    /*if( $scope.selCama.value == $scope.habitacionesBD[i].tipo_cama) {
                        $scope.mostrarCantidadCuartos = true;
                        $scope.cantidadCuartosBD = $scope.habitacionesBD[i].cantidad_cuartos;
                        $scope.habitacionActualizar = $scope.habitacionesBD[i];
                        return true;
                        break;
                    }*/
                }
            } 
        };

        $scope.editarCuartos = function() {
            $scope.habitacionActualizar.cantidad_cuartos = $scope.habitacionActualizar.cantidad_cuartos + $scope.habitacion.numCuartos;
            console.log( $scope.habitacionActualizar.cantidad_cuartos );
            $http.post('/updateCuartos/' + $scope.habitacionActualizar.id, $scope.habitacionActualizar).then(
            function(response){
                alert("¡Registro modificado con éxito!");
                $scope.formHabitacionesActualizar.$setPristine();
                location.reload();
            },function(errorResponse){
                alert("Ha ocurrido un error al modificar");
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
*/
</script>


