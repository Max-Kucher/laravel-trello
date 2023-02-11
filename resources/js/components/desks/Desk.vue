<template>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-3 mb-5">Доски</h1>

            <div class="col-lg-4 col-md-6 col-sm-12 mb-3" v-for="desk in desks">
                <div class="card text-bg-dark">
<!--                    <img src="https://images.all-free-download.com/images/graphiclarge/camera_test_apple_563728.jpg" class="card-img-top" alt="Яблоки">-->
                    <div class="card-header">{{ desk.desk_name }}</div>
                    <div class="card-body" v-if="desk.desk_description.length">
                        <p class="card-text">{{ desk.desk_description }}</p>
                    </div>
                    <ul class="list-group list-group-flush mt-2" v-if="desk.desk_lists !== undefined && desk.desk_lists !== null && desk.desk_lists.length">
                        <li class="list-group-item" v-for="list_item in desk.desk_lists">
                            {{ list_item.item_name }}
                        </li>
                    </ul>
                    <div class="card-body">
                        <router-link class="btn btn-primary" :to="{name: 'show-desk', params: {deskId: desk.id}}">Изменить</router-link>

<!--                        <a href="#" class="card-link">Card link</a>-->
<!--                        <a href="#" class="card-link">Another link</a>-->
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 mb-3" v-if="loading">
                <div class="card text-bg-dark">
                    <div class="card-header">Загрузка...</div>
                    <div class="card-body">
                    </div>
                </div>
            </div>

            <div class="alert alert-danger" role="alert" v-if="error">
                <h4 class="alert-heading">Ошибка!</h4>
                <hr>
                <div>Произошла ошибка при загрузке досок</div>
            </div>
        </div>
    </div>


</template>

<script>
    export default {
        data() {
            return {
                desks: [],
                error: false,
                loading: true,
            }
        },
        mounted() {
            axios.get('api/v1/desks')
                .then(response => {
                    if (response.data !== undefined && response.data !== null
                        && response.data.data !== undefined && response.data.data !== null) {
                        this.desks = response.data.data;
                    }
                }).catch(err => {
                    console.log(err);

                    this.error = true;
            }).finally(() => { this.loading = false; });
        },
    }
</script>

<style scoped>

</style>
