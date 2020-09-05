<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 my-1">
                <a class="btn btn-light px-2">
                    <img src="https://img.icons8.com/fluent-systems-filled/15/000000/plus-math.png"/> Agregar tarea
                </a>
            </div>
            <div class="col-md-5 my-1 text-right">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-light">
                        <img src="https://img.icons8.com/fluent-systems-filled/15/000000/back.png"/> Anterior
                    </button>
                    <button type="button" class="btn btn-light">
                        Siguiente <img src="https://img.icons8.com/fluent-systems-filled/15/000000/more-than.png"/>
                    </button>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                       {{datetask}}
                    </div>
                    <div class="card-body">

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
        mounted() {
            // console.log('Component mounted.')
        },
        computed:{
            datetask(){
                const today = new Date(Date.now());
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                let fecha = new Date(today.setDate(today.getDate() + this.todaydate)).toLocaleDateString('es-MX', options);

                return fecha;
            }
        }
    }
</script>
