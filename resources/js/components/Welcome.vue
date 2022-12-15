<template>
    <div class="welcome box">
        <h3 class="title">Welcome</h3>
        <TaskCreateForm @taskWasCreated="getTasks"></TaskCreateForm>
        <Tasks :tasks="tasks" @taskWasUpdated="getTasks" @taskWasDeleted="getTasks"></Tasks>
    </div>
</template>

<script>
import Tasks from "./Tasks.vue";
import TaskCreateForm from "./TaskCreateForm.vue";
import axios from "axios";

export default {
    name: "Welcome",
    data(){
      return {
          tasks: []
      }
    },
    mounted() {
        this.getTasks()
    },
    methods:{
        getTasks() {
            axios.get("http://127.0.0.1:8000/api/tasks").then(tasks => {
                this.tasks = tasks.data
            }).catch(err => {
                console.log(err)
            })
        },
    },
    components:{
        Tasks,
        TaskCreateForm
    }
}
</script>

<style scoped lang="scss">

</style>
