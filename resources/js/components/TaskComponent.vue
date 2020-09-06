<template>
    <div class="row border-bottom mb-3">
        <div class="col-6 col-md-8">
            <b>{{task.title}}</b>
            <p>{{task.description}}</p>
        </div>
        <div class="col-6 col-md-4 text-right">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light">
                    {{time}}
                </button>
                <button type="button" class="btn btn-light border">
                    <img src="https://img.icons8.com/small/15/000000/edit.png"/>
                </button>
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
            timer : ''
        }
    },
    computed:{
        time(){
            let seconds = parseInt(this.task.minutes * 60) + parseInt(this.task.seconds);
            console.log(seconds)
            var date = new Date(0)
            date.setSeconds(seconds)
            return date.toISOString().substr(11, 8)
        }
    }
}
</script>