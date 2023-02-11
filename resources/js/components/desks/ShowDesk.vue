<template>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-3 mb-5">{{ desk.desk_name || "Загрузка..." }}</h1>
        </div>

        <form method="post" @submit.stop.prevent="submitClick">
            <div class="mb-3">
                <label for="desk_name" class="form-label">Название доски</label>
                <input name="desk_name"
                       id="desk_name"
                       type="text"
                       class="form-control"
                       v-model="desk.desk_name"
                       placeholder="Название доски"
                       aria-label="Название доски"
                >
            </div>

            <div class="mb-3">
                <label for="desk_description" class="form-label">Описание доски</label>
                <textarea name="desk_description"
                          id="desk_description"
                          class="form-control"
                          v-model="desk.desk_description"
                          rows="3"
                >{{ desk.desk_description }}</textarea>
            </div>

            <div class="mb-3">
                <router-link class="btn btn-outline-danger" :to="{name: 'desks'}">Отмена</router-link>

                <button class="btn btn-primary mx-2">Сохранить</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: [
        'deskId',
    ],
    data() {
        return {
            desk: { },
            error: false,
        }
    },
    mounted() {
        axios.get('/api/v1/desks/' + this.deskId + '/edit')
            .then(response => {
                if (response.data !== undefined && response.data !== null
                    && response.data.data !== undefined && response.data.data !== null) {
                    this.desk = response.data.data;
                }
            }).catch(err => {
                console.log(err);

                this.error = true;
        });
    },
    methods: {
        submitClick: function() {
            let desk_data = JSON.parse(JSON.stringify( this.desk ));

            axios.patch('/api/v1/desks/' + this.deskId, desk_data)
                .then(response => {
                console.log(response);
            });
        },
    },
}
</script>

<style scoped>

</style>
