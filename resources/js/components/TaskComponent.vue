<template>
    <div>
        <div v-if="!edit" class="row border-bottom mb-3">
            <div class="col-6 col-md-8">
                <b>{{task.title}}</b>
                <p>{{task.description}}</p>
            </div>
            <div class="col-6 col-md-4 text-right">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-light">
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
                        <button type="button" class="btn btn-light border" @click="cancel()">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="save()">Guardar</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-danger border" @click="cancel()">
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
        task : Object
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
        }
    },
    methods:{
        cancel(){
            this.edit = !this.edit
            this.$emit('cancel')
        },
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