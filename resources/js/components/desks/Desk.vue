<template>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-3 mb-5">Доски</h1>

            <div class="col-lg-4 col-md-6 col-sm-12 mb-3" v-if="desks.length" v-for="desk in desks">
                <div class="card text-bg-dark">
<!--                    <img src="https://images.all-free-download.com/images/graphiclarge/camera_test_apple_563728.jpg" class="card-img-top" alt="Яблоки">-->
                    <div class="card-header">{{ desk.desk_name }}</div>
                    <div class="card-body" v-if="desk.desk_description !== undefined && desk.desk_description.length">
                        <p class="card-text">{{ desk.desk_description }}</p>
                    </div>
                    <ul class="list-group list-group-flush mt-2" v-if="desk.desk_lists !== undefined && desk.desk_lists !== null && desk.desk_lists.length">
                        <li class="list-group-item" v-for="list_item in desk.desk_lists">
                            {{ list_item.item_name }}
                        </li>
                    </ul>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <router-link class="btn btn-primary" :to="{name: 'show-desk', params: {deskId: desk.id}}">Изменить</router-link>

                        <div class="btn-group" role="group">
                            <button :data-desk-id="desk.id" @click="deleteDesk" class="btn btn-outline-danger">
                                <i class="bi bi-trash3"></i>
                                <span class="visually-hidden">Удалить</span>
                            </button>
                            <button :data-desk-id="desk.id" @click="cloneDesk" class="btn btn-outline-secondary">
                                <i class="bi bi-clipboard-plus"></i>
                                <span class="visually-hidden">Клонировать</span>
                            </button>
                        </div>
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
    import {  } from 'vue';

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
        methods: {
            cloneDesk: function($event) {
                let desk = find_target_desk_by_event.apply(this, [$event]);

                if (desk !== null && desk.id !== undefined) {
                    // Reset ids to null
                    delete desk.id;
                    for (let list_item in desk.desk_lists) {
                        delete desk.desk_lists[list_item].id;
                        delete desk.desk_lists[list_item].desk_id;
                    }

                    axios.post('/api/v1/desks/', desk)
                        .then(response => {
                            this.desks.push(response.data.data);
                        }).catch(err => {
                            console.log(err);
                    });
                }
            },
            deleteDesk: function($event) {
                let desk = find_target_desk_by_event.apply(this, [$event]);

                if (desk !== null && desk.id !== undefined) {
                    axios.delete('/api/v1/desks/' + desk.id)
                        .then(response => {
                            if ([200, 202, 204].includes(response.status)) {

                                for (let index in this.desks) {
                                    if (this.desks[index].id === desk.id) {
                                        this.desks.splice(index, 1);
                                    }
                                }
                            }
                        }).catch(err => {
                            console.log(err);
                    });
                }
            },
        },
    }

    /**
     * Find target desk object
     *
     * @param $event
     * @returns {Object}
     */
    function find_target_desk_by_event($event)
    {
        let desk = { };

        let target = $event.currentTarget;
        let target_desk_id = target.dataset.deskId;

        let _desk = this.desks.filter(tmp => { return parseInt(tmp.id) === parseInt(target_desk_id) });

        if (_desk !== null && _desk !== undefined) {
            desk = JSON.parse(JSON.stringify( _desk ));
            desk = desk[0];
        }

        return desk;
    }
</script>

<style scoped>

</style>
