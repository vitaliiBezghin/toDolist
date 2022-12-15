<template>
    <Toast group="task-update-delete"/>

    <h4 class="title">
        Your tasks:
    </h4>
    <ul v-for="(task, index) in tasks" :key="task.id" class="tasks-list">
        <li :class="{done: task.status == TaskEnum.DONE}" :data-task-id="task.id">
          #{{index + 1}} {{task.task }} <mark> {{ task.created_at}}</mark>
            <span class="actions">
                <i v-if="task.status != TaskEnum.DONE" class="pi pi-check mark-as-done-btn" @click="markAsDone(task.id)"></i>
                <i class="pi pi-trash delete-task-btn" @click="deleteTask(task.id)"></i>
            </span>
        </li>
    </ul>
</template>

<script>
import axios from "axios";
import TaskEnum from "../TaskEnum";
import Toast from 'primevue/toast';

export default {
    name: "Tasks",
    props:['tasks'],
    emits:['taskWasUpdated', 'taskWasDeleted'],
    data() {
        return {
            TaskEnum
        }
    },
    methods: {
        markAsDone(id) {
            axios.patch("http://127.0.0.1:8000/api/tasks/" + id).then(tasks => {
                if (tasks.status == 204) {
                    this.$toast.add({
                        severity: 'info',
                        summary: 'Task status successfully changed !',
                        group: 'task-update-delete',
                        life: 3000
                    })
                    this.$emit('taskWasUpdated')
                }
            }).catch(err => {
                console.log(err)
            })
        },
        deleteTask(id) {
            axios.delete("http://127.0.0.1:8000/api/tasks/" + id).then(tasks => {
                if (tasks.status == 204) {
                    this.$toast.add({
                        severity: 'info',
                        summary: 'Task status successfully deleted !',
                        group: 'task-update-delete',
                        life: 3000
                    })
                    this.$emit('taskWasDeleted')
                }
            }).catch(err => {
                console.log(err)
            })
        }
    },
    components:{
        Toast
    }
}
</script>

<style scoped lang="scss">
.tasks-list {
    display: flex;
    justify-content: center;
    margin: 30px auto 10px auto;
    padding: 0;
    list-style: none;
}
</style>
