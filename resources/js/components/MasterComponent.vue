<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5 my-1">
                <a class="btn btn-light px-2 border" @click="newTask = true">
                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/plus-math.png"/> Agregar tarea
                </a>
            </div>
            <div class="col-12 col-md-5 my-1 text-right">
                <button class="btn btn-light border">
                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/report-card.png"/>
                </button>
                <button class="btn btn-light border">
                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/statistics.png"/>
                </button>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a :href="'/home/' + (todaydate - 1)" class="btn btn-light border">
                        <img src="https://img.icons8.com/fluent-systems-filled/15/000000/back.png"/> Anterior
                    </a>
                    <a :href="'/home/' + (todaydate + 1)" class="btn btn-light border">
                        Siguiente <img src="https://img.icons8.com/fluent-systems-filled/15/000000/more-than.png"/>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-10">
                <div class="card">
                    <div class="card-header">
                       <div class="row">
                           <div class="col-12 col-md-6">
                               {{dateTask}}
                           </div>
                           <div class="col-12 col-md-6 text-right">
                               <button title="Iniciar" class="btn btn-light" @click="countDown = 10;countDownTimer()">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/circled-play.png"/>
                                </button>
                               <button title="Pausar" class="btn btn-light" @click="pause = !pause">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/circled-pause.png"/>
                                </button>
                               <button title="Reiniciar" class="btn btn-light" @click="countDown = restart">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/rewind-button-round.png"/>
                                </button>
                                <button title="Detener" class="btn btn-light" @click="countDown = 1;countDownTimer()">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/stop-circled.png"/>
                                </button>
                                <div class="btn btn-light border">
                                    <span id="timer">{{timer}}</span>
                                </div>
                           </div>
                       </div>
                    </div>
                    <div class="card-body">
                        <task-component v-for="task in tasks.tasks" :key="task.id" :task="task" v-on:cancel="cancel()"/>
                        <new-task-component :fixedDate="fixedDate" :api_token="user.api_token" v-on:cancel="cancel()" v-on:saved="saved()" v-if="newTask" />
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mt-5">
                <img src="/img/goals.svg" class="img-fluid" alt="img-goals">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            todaydate : Number,
            user : Object
        },
        data() {
            return {
                countDown : 10,
                timer : '00:00:00',
                restart : 0,
                pause : false,
                newTask : false,
                dateTask : '',
                tasks : Object,
                fixedDate : ''
            }
        },
        computed:{

        },
        methods:{
            apiCallGetTask(){
                const today = new Date()
                today.setDate(today.getDate() + this.todaydate);
                this.fixedDate = today;

                axios
                    .get('/api/tasks',{
                        params: {
                            api_token: this.user.api_token,
                            date: today
                        }
                    })
                    .then(response => {
                        console.log(response)
                        this.tasks = response.data
                    })
                    .catch(error => 
                        console.log(error)
                    )
            },
            countDownTimer() {
                if(this.countDown > 0) {
                    setTimeout(() => {
                        if(!this.pause){
                            this.countDown -= 1
                        }
                        var date = new Date(0)
                        date.setSeconds(this.countDown)
                        this.timer = date.toISOString().substr(11, 8)
                        this.countDownTimer()
                    }, 1000)
                }
            },
            cancel() {
                this.newTask = false
                this.apiCallGetTask()
            }
            ,
            saved() {
                this.newTask = false
                this.apiCallGetTask()
            }
        },
        created(){
            const today = new Date(Date.now())
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
            this.dateTask = new Date(today.setDate(today.getDate() + this.todaydate)).toLocaleDateString('es-MX', options)
            
            this.countDownTimer()
            this.apiCallGetTask()
            this.restart = this.countDown
        }
    }
</script>
