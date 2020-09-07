<template>
    <div>
        <div v-if="!edit" class="row border-bottom mb-3">
            <div class="col-2 col-md-1">
                <div class="btn-group-vertical" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-light btn-sm border" @click="orderUp()">
                        <img src="https://img.icons8.com/small/16/000000/up-squared.png"/>
                    </button>
                    <button type="button" class="btn btn-light btn-sm border" @click="orderDown()">
                        <img src="https://img.icons8.com/small/16/000000/down-squared.png"/>
                    </button>
                </div>
            </div>
            <div class="col-10 col-md-7">
                <b>{{task.title}}</b>
                <p>{{task.description}}</p>
            </div>
            <div class="col-12 col-md-4 text-right">
                <div class="btn-group mb-1" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-light border">
                        {{time}}
                    </button>
                    <button type="button" class="btn btn-light border" @click="edit = !edit">
                        <img src="https://img.icons8.com/small/15/000000/edit.png"/>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="edit" class="row border-bottom mb-3">
            <div class="col-6 col-md-8">
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input v-model="task.title" type="text" class="form-control" autofocus>
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <input v-model="task.description" type="text" class="form-control">
                </div>
            </div>
            <div class="col-6 col-md-4 text-right">
                <div class="form-group">
                    <label for="time">Tiempo Actividad</label>
                    <select v-model="minutesFixed" class="form-control">
                        <option value="30">Corta</option>
                        <option value="60">Media</option>
                        <option value="120">Larga</option>
                        <option value="0">Otro</option>
                    </select>
                </div>
                <div v-if="minutesFixed == '0'" class="form-group">
                    <label for="minutos">Minutos ({{task.minutes}})</label>
                    <input v-model="task.minutes" type="range" class="form-control-range" min="0" max="120">
                </div>
                <div v-if="minutesFixed == '0'" class="form-group">
                    <label for="segundos">Segundos ({{task.seconds}})</label>
                    <input v-model="task.seconds" type="range" class="form-control-range" min="0" max="59">
                </div>
                <div class="form-group">
                    <label for="margin">&nbsp;</label>
                    <div class="form-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-light border btn-sm" @click="cancel()">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click="save()">Guardar</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-danger btn-sm" @click="destroy()">
                            <img src="https://img.icons8.com/small/16/FFFFFF/delete.png"/> Borrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TaskComponent',
    props: {
        api_token : String,
        task : Object,
        fixedDate : Date,
    },
    data(){
        return {
            edit : false,
            minutesFixed : ''
        }
    },
    computed:{
        time(){
            let seconds = parseInt(this.task.minutes * 60) + parseInt(this.task.seconds);
            var date = new Date(0)
            date.setSeconds(seconds)
            return date.toISOString().substr(11, 8)
        },
        minutesValidated(){
            if(this.minutesFixed == '0'){
                if(this.task.seconds > 0 && this.task.minutes == 120){
                    return "119";
                }
                return this.task.minutes;
            }
            return this.minutesFixed;
        },
        secondsValidated(){
            if(this.minutesFixed == '0'){
                return this.task.seconds;
            }
            return "0";
        }
    },
    methods:{
        cancel(){
            this.edit = !this.edit
            this.$emit('cancel')
        },
        save(){
            axios
                .patch('/api/tasks/' + this.task.id + '?api_token=' + this.api_token,{
                    params: {
                        title: this.task.title,
                        description: this.task.description,
                        minutes: this.minutesValidated,
                        seconds: this.secondsValidated,
                        date: this.fixedDate,
                    }
                })
                .then(response => (
                    console.log(response)
                ))
                .catch(error => 
                    console.log(error)
                )

            this.edit = !this.edit
            this.$emit('saved')
        },
        destroy(){
            if(confirm("Esta acción no se puede deshacer. ¿Esta seguro?")){
                axios.delete('/api/tasks/' + this.task.id + '?api_token=' + this.api_token)
                    .then(response => (
                        console.log(response)
                    ))
                    .catch(error => 
                        console.log(error)
                    )

                this.edit = !this.edit
                this.$emit('saved')
            }
        },
        orderUp(){
            axios.patch('/api/tasks/up/' + this.task.id + '?api_token=' + this.api_token,{
                params : {
                    date : this.fixedDate
                }
            })
                .then(response => (
                    console.log(response)
                ))
                .catch(error => 
                    console.log(error)
                )
        },
        orderDown(){
            axios.patch('/api/tasks/down/' + this.task.id + '?api_token=' + this.api_token,{
                params : {
                    date : this.fixedDate
                }
            })
                .then(response => (
                    console.log(response)
                ))
                .catch(error => 
                    console.log(error)
                )
        }
    },
    created(){
        if(this.task.minutes == "30" && this.task.seconds == "0"){
            this.minutesFixed = "30"
        }else if(this.task.minutes == "60" && this.task.seconds == "0"){
            this.minutesFixed = "60"
        }else if(this.task.minutes == "120" && this.task.seconds == "0"){
            this.minutesFixed = "120"
        }else{
            this.minutesFixed = "0"
        }
    }
}
</script>