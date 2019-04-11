<!DOCTYPE html>
<html ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="{{asset('js/angular.js')}}" type="text/javascript"></script>

        <title>Reservaciones</title>
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
            <form name="formReservaciones" enctype="multipart/form-data">
                <h3>Nueva reservación</h3>
                <div class="col">
                    <label>Nombre(s):</label>
                    <input type="text" required maxlength="50" ng-model="reservacion.nombre">
                </div>
                <div class="col">
                    <label>Apellido(s):</label>
                    <input type="text" required maxlength="50" ng-model="reservacion.nombre">
                </div>
                <div class="col">
                    <label>Fecha de nacimiento:</label>
                    <input type="date" required ng-model="reservacion.fechaNac">
                </div>
                <div class="col">
                    <label>Edad:</label>
                    <input type="number" required disabled maxlength="3" ng-model="reservacion.edad">
                </div>
                <div class="col">
                    <label>Inicio de reservación:</label>
                    <input type="date" required ng-model="reservacion.fechaInicio">
                </div>
                <div class="col">
                    <label>Fin de reservación:</label>
                    <input type="date" required ng-model="reservacion.fechaFinal">
                </div>
                <div class="col">
                    <label>Habitaciones:</label>
                    <select ng-options="habitacion.value for habitacion in tipoHabitaciones track by habitacion.id" name="habitacion" ng-model="selHabitacion" required>
                        <option value="">Selecciona la habitación que desees</option>
                    </select>
                </div>
            </form>
        </div>
    </body>
</html>