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
                               <button title="Iniciar" class="btn btn-light" @click="pause = false">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/circled-play.png"/>
                                </button>
                               <button title="Pausar" class="btn btn-light" @click="pause = true">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/circled-pause.png"/>
                                </button>
                               <button title="Reiniciar" class="btn btn-light" @click="countDown = restart">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/rewind-button-round.png"/>
                                </button>
                                <button title="Detener" class="btn btn-light" @click="resetTimer()">
                                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/stop-circled.png"/>
                                </button>
                                <div class="btn btn-light border">
                                    <span id="timer">{{timer}}</span>
                                </div>
                           </div>
                       </div>
                    </div>
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <div class="col-7">
                                <b>Tarea en curso:</b> {{currentTask.task.title}}
                            </div>
                            <div class="col-4">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="btn btn-light border btn-sm" @click="starTask()">
                                        <img src="https://img.icons8.com/small/15/000000/play.png"/> Iniciar
                                    </button>
                                    <button class="btn btn-light border btn-sm" @click="maskAsCompleteTask()">
                                        <img src="https://img.icons8.com/small/15/000000/checked-2--v1.png"/> Terminar
                                    </button>
                                    <button class="btn btn-light border btn-sm" @click="resetTimer()">
                                        <img src="https://img.icons8.com/small/15/000000/delete-sign.png"/> Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="loading" class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <task-component :running="running" v-for="task in tasks.tasks" :key="task.id" :task="task" :api_token="user.api_token" :fixedDate="fixedDate" v-on:cancel="cancel()" v-on:saved="saved()"/>
                        <new-task-component :fixedDate="fixedDate" :api_token="user.api_token" v-on:cancel="cancel()" v-on:saved="saved()" v-if="newTask" />
                    </div>
                    <div class="card-footer text-right">
                        © Irvin Raúl López Contreras
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mt-5">
                <img src="/img/goals.svg" class="img-fluid" alt="img-goals">
            </div>
        </div>
    </div>
</template>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    export default {
        props:{
            todaydate : Number,
            user : Object
        },
        data() {
            return {
                countDown : 10,
                loading : true,
                timer : '00:00:00',
                restart : 0,
                pause : true,
                newTask : false,
                dateTask : '',
                tasks : Object,
                fixedDate : '',
                currentTask : {task : {title : ''}}, 
                running : false
            }
        },
        computed:{
            
        },
        methods:{
            apiCallGetTask(){
                this.loading = true
                let today = new Date()
                today.setDate(today.getDate() + this.todaydate);
                this.fixedDate = today;

                setTimeout(() => {
                axios.get('/api/tasks',{
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

                this.loading = false

                }, 1000)
                
            },
            countDownTimer() {
                if(this.countDown > 0) {
                    setTimeout(() => {
                        if(!this.pause){
                            this.running = true
                            this.countDown -= 1
                        }
                        var date = new Date(0)
                        date.setSeconds(this.countDown)
                        this.timer = date.toISOString().substr(11, 8)
                        this.countDownTimer()
                    }, 1000)
                }else if(this.countDown <= 0 && this.restart > 0){
                    this.maskAsCompleteTask()
                }
            },
            resetTimer(){
                this.running = false
                this.countDown = this.restart
                this.pause = true
                var date = new Date(0)
                date.setSeconds(this.countDown)
                this.timer = date.toISOString().substr(11, 8)
            },
            cancel() {
                this.newTask = false
                this.apiCallGetTask()
            }
            ,
            saved() {
                this.newTask = false
                this.apiCallGetTask()
            },
            currentTaskCall(){
                let today = new Date()
                today.setDate(today.getDate() + this.todaydate);
                this.fixedDate = today;

                axios.get('/api/tasks/current',{
                        params: {
                            api_token: this.user.api_token,
                            date: today
                        }
                    })
                    .then(response => {
                        console.log(response)
                        this.currentTask = response.data
                        let seconds = parseInt(response.data.task.minutes * 60) + parseInt(response.data.task.seconds);
                        this.countDown = seconds;
                        this.restart = seconds;
                        this.resetTimer()
                    })
                    .catch(error => 
                        console.log(error)
                    )
            }, 
            maskAsCompleteTask(){
                let timeRequired = parseInt(this.restart) - parseInt(this.countDown)
                if(timeRequired > 0){
                    axios.patch('/api/task/mark/' + this.currentTask.task.id + '?api_token=' + this.user.api_token,{
                            params : {
                                timeRequired : timeRequired
                            }
                        })
                        .then(response => {
                            console.log(response)
                            this.currentTaskCall()
                            this.apiCallGetTask()
                        })
                        .catch(error => 
                            console.log(error)
                        )
                    this.running == false
                }else{
                    alert('¡No puedes terminar la tarea si no la has empezado!');
                }
                
            },
            starTask(){
                if(this.running == false){
                    this.countDownTimer();
                    this.pause = false;
                }
            }
        },
        created(){
            let today = new Date(Date.now())
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
            this.dateTask = new Date(today.setDate(today.getDate() + this.todaydate)).toLocaleDateString('es-MX', options)
            
            this.apiCallGetTask()
            this.restart = this.countDown
            this.currentTaskCall()
            
        }
    }

    
</script>
