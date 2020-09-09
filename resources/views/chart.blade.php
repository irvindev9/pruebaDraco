<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- Fav icon --}}
        <link rel="icon" type="image/png" href="https://img.icons8.com/small/16/000000/timer.png">
        <title>Chart</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <link rel="stylesheet" href="{{mix('css/app.css')}}">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-12 col-md-6 text-center">
                    <b>{{date('F j Y',strtotime($day->date_task))}}</b>
                </div>
            </div>
            <div class="row justify-content-center mt-1">
                <div class="col-12 col-md-6 card">
                    <canvas id="myChart"></canvas>
                </div>
                
            </div>
            <div class="row justify-content-center mt-1">
                <div class="col-12 col-md-6 text-center">
                    <b>Minutos/Día de la semana</b>
                </div>
            </div>
            <div class="row justify-content-center mt-1">
                <div class="col-8 col-md-4">
                    <img src="{{asset('img/chart.svg')}}" alt="chart" class="img-fluid">
                </div>
            </div>
        </div>
        
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7'],
                    datasets: [{
                        label: 'Tareas completadas de la ultima semana',
                        backgroundColor: 'rgb(249, 168, 38)',
                        borderColor: 'rgb(179, 115, 14)',
                        data: [{{implode(",",$data)}}]
                    }]
                },

                // Configuration options go here
                options: {}
            });
        </script>
        
    </body>
</html>