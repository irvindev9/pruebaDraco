<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 my-1">
                <a class="btn btn-light px-2 border">
                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/plus-math.png"/> Agregar tarea
                </a>
            </div>
            <div class="col-md-5 my-1 text-right">
                <button class="btn btn-light border">
                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/report-card.png"/>
                </button>
                <button class="btn btn-light border">
                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/statistics.png"/>
                </button>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-light border">
                        <img src="https://img.icons8.com/fluent-systems-filled/15/000000/back.png"/> Anterior
                    </button>
                    <button type="button" class="btn btn-light border">
                        Siguiente <img src="https://img.icons8.com/fluent-systems-filled/15/000000/more-than.png"/>
                    </button>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                       <div class="row">
                           <div class="col-6">
                               {{datetask}}
                           </div>
                           <div class="col-6 text-right">
                               <button title="Iniciar" class="btn btn-light" @click="countDown = 10;countDownTimer()">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/circled-play.png"/>
                                </button>
                               <button title="Pausar" class="btn btn-light">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/circled-pause.png"/>
                                </button>
                               <button title="Reiniciar" class="btn btn-light">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/rewind-button-round.png"/>
                                </button>
                                <button title="Detener" class="btn btn-light">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/stop-circled.png"/>
                                </button>
                                <div class="btn btn-light border">
                                    <span id="timer">{{timer}}</span>
                                </div>
                           </div>
                       </div>
                    </div>
                    <div class="card-body">
                        <div v-for="n in 5" class="row border-bottom mb-3">
                            <div class="col-8">
                                <b>Diseño web (Draco Studios)</b>
                                <p>Trabajar mucho</p>
                            </div>
                            <div class="col-4 text-right">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-light">
                                        00:24
                                    </button>
                                    <button type="button" class="btn btn-light border">
                                        <img src="https://img.icons8.com/small/15/000000/edit.png"/>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            todaydate : Number
        },
        data() {
            return {
                countDown : 10,
                timer : '00:00:00',
                restart : 0,
                pause : false,
            }
        },
        computed:{
            datetask(){
                const today = new Date(Date.now());
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                let fecha = new Date(today.setDate(today.getDate() + this.todaydate)).toLocaleDateString('es-MX', options);

                return fecha;
            }
        },
        methods:{
            countDownTimer() {
                if(this.countDown > 0) {
                    setTimeout(() => {
                        this.countDown -= 1
                        var date = new Date(0);
                        date.setSeconds(this.countDown);
                        this.timer = date.toISOString().substr(11, 8);
                        this.countDownTimer()
                    }, 1000)
                }
            }
        },
        created(){
            this.countDownTimer()
        }
    }
</script>
