<template>
    <div class="row border-bottom mb-3">
        <div class="col-6 col-md-8">
            <div class="form-group">
                <label for="title">Titulo</label>
                <input v-model="title" type="text" class="form-control" autofocus>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <input v-model="description" type="text" class="form-control">
            </div>
        </div>
        <div class="col-6 col-md-4 text-right">
            <div class="form-group">
                <label for="time">Tiempo Actividad</label>
                <select v-model="time" class="form-control">
                    <option value="30">Corta</option>
                    <option value="60">Media</option>
                    <option value="120">Larga</option>
                    <option value="0">Otro</option>
                </select>
            </div>
            <div v-if="time == '0'" class="form-group">
                <label for="minutos">Minutos ({{minutes}})</label>
                <input v-model="minutes" type="range" class="form-control-range" min="0" max="120">
            </div>
            <div v-if="time == '0'" class="form-group">
                <label for="segundos">Segundos ({{seconds}})</label>
                <input v-model="seconds" type="range" class="form-control-range" min="0" max="59">
            </div>
            <div class="form-group">
                <label for="margin">&nbsp;</label>
                <div class="form-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-light border" @click="cancel()">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="save()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NewTask',
    props:{
        api_token : String,
        fixedDate : Date,
    },
    data(){
        return {
            minutes : "0",
            seconds : "0",
            time : "30",
            title : "",
            description : "",
        }
    },
    computed:{
        minutesValidated(){
            if(this.time == '0'){
                if(this.seconds > 0 && this.minutes == 120){
                    return "119";
                }
                return this.minutes;
            }
            return this.time;
        },
        secondsValidated(){
            if(this.time == '0'){
                return this.seconds;
            }
            return "0";
        }
    },
    methods:{
        cancel(){
            this.$emit('cancel')
        },
        save(){
            if(this.title != ''){
                axios
                    .post('/api/tasks?api_token=' + this.api_token,{
                        params: {
                            title: this.title,
                            description: this.description,
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
                
                this.$emit('saved')
            }else{
                alert('El campo de titulo es obligatorio')
            }
            
        }
    }
}
</script>