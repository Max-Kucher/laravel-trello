<template>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-3 mb-5">Доски</h1>

            <div class="col-lg-4 col-md-6 col-sm-12 mb-3" v-if="desks.length" v-for="desk in desks">
                <div class="card text-bg-dark">
                    <div class="card-header">{{ desk.desk_name }}</div>
                    <div class="card-body" v-if="desk.desk_description !== undefined && desk.desk_description.length">
                        <p class="card-text">{{ desk.desk_description }}</p>
                    </div>
                    <ul class="list-group list-group-flush mt-2">
                        <li class="list-group-item"
                            v-if="desk.desk_lists !== undefined && desk.desk_lists !== null && desk.desk_lists.length"
                            v-for="list_item in desk.desk_lists"
                        >
                            {{ list_item.item_name }}
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       placeholder="Добавить пункт задачи..."
                                >
                                <button class="btn btn-outline-secondary"
                                        onclick="alert('Не робыть пока!')"
                                        type="button">Добавить</button>
                            </div>
                        </li>
                    </ul>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <router-link class="btn btn-primary" :to="{name: 'show-desk', params: {deskId: desk.id}}">Изменить</router-link>

                        <div class="btn-group" role="group">
                            <button :data-desk-id="desk.id" @click="deleteDesk(desk.id)" class="btn btn-outline-danger">
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

            <NewDesk @ondeskcreated="addDeskData"></NewDesk>

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
    import NewDesk from "./NewDesk.vue";

    export default {
        components: {
            NewDesk
        },
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

                    confirm('Доска будет клонирована. Продолжить?') && axios.post('/api/v1/desks/', desk)
                        .then(response => {
                            this.addDeskData(response.data.data);
                        }).catch(err => {
                            console.log(err);
                    });
                }
            },
            deleteDesk: function(desk_id) {
                confirm('Вы действительно хотите удалить эту доску?') && axios.delete('/api/v1/desks/' + desk_id)
                    .then(response => {
                        if ([200, 202, 204].includes(response.status)) {

                            for (let index in this.desks) {
                                if (this.desks[index].id === desk_id) {
                                    this.desks.splice(index, 1);
                                }
                            }
                        }
                    }).catch(err => {
                        console.log(err);
                });
            },
            addDeskData: function (desk) {
                this.desks.push(desk);
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
