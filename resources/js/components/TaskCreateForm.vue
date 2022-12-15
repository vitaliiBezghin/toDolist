<template>
    <Toast group="task-create"/>
    <div class="taskForm">
        <form @submit.prevent.stop>
            <div class="form-group">
                <label>Task</label>
                <InputText type="text" v-model="task" class="input" required/>
            </div>
            <Button label="Create" @click="createForm" type="submit" class="btn"/>
        </form>
    </div>
</template>

<script>
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import axios from "axios";
import Toast from 'primevue/toast';

export default {
    name: "TaskCreateForm",
    emits: ['taskWasCreated'],
    data() {
        return {
            task: ''
        }
    },
    methods: {
        createForm() {
            axios.post('http://127.0.0.1:8000/api/tasks', {
                task: this.task
            }).then(res => {
                if (res.status == 204 || res.status == 200) {
                    this.$emit('taskWasCreated')
                    this.task = ''
                    this.$toast.add({
                        severity: 'success',
                        summary: 'Task successfully created !',
                        group: 'task-create',
                        life: 3000
                    })
                }
            }).catch(err => {
                console.log(err)
            })
        }
    },
    components: {
        InputText,
        Toast,
        Button
    }
}
</script>

<style scoped lang="scss">
.taskForm {
    margin: auto;
    max-width: 350px;
    display: flex;
    flex-direction: column;
    align-items: center;

    form {
        .input {
            display: block;
            margin: 10px 0;
        }
    }
}

</style>
