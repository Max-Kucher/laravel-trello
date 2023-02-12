<template>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-3 mb-5">{{ loading ? 'Загрузка...' : desk.desk_name }}</h1>
        </div>

        <form method="post" @submit.stop.prevent="submitClick" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="desk_name" class="form-label">Название доски</label>
                <input name="desk_name"
                       id="desk_name"
                       type="text"
                       class="form-control"
                       :class="{ 'is-invalid': v$.desk.desk_name.$error, 'is-valid': !v$.desk.desk_name.$error }"
                       v-model="desk.desk_name"
                       placeholder="Название доски"
                       aria-label="Название доски"
                       required
                       @keyup.stop.prevent="v$.desk.desk_name.$touch"
                       @blur="validate"
                >

                <div class="valid-feedback">
                    Выглядит здорово!
                </div>
                <div class="invalid-feedback" v-if="v$.desk.desk_name.required.$invalid">
                    Вы должны заполнить название доски.
                </div>
                <div class="invalid-feedback" v-if="v$.desk.desk_name.minLength.$invalid">
                    Длинна названия доски должна быть больше {{ v$.desk.desk_name.minLength.$params.min }} букв
                </div>
                <div class="invalid-feedback" v-if="v$.desk.desk_name.maxLength.$invalid">
                    Длинна названия доски не должна быть больше {{ v$.desk.desk_name.maxLength.$params.max }} букв
                </div>
            </div>

            <div class="mb-3">
                <label for="desk_description" class="form-label">Описание доски</label>
                <textarea name="desk_description"
                          id="desk_description"
                          class="form-control"
                          v-model="desk.desk_description"
                          rows="3"
                >{{ desk.desk_description }}</textarea>

                <!--                          @keyup.stop.prevent="validate"-->
            </div>

            <div class="mb-3">
                <router-link class="btn btn-outline-danger" :to="{name: 'desks'}">Отмена</router-link>

                <button class="btn btn-primary mx-2">Сохранить</button>
            </div>
        </form>
    </div>
</template>

<script>
import { useVuelidate } from '@vuelidate/core';
import { required, maxLength, minLength } from '@vuelidate/validators';

export default {
    props: [
        'deskId',
    ],
    setup() {
        return {
            v$: useVuelidate()
        }
    },
    data() {
        return {
            desk: { },
            error: false,
            loading: true,
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
        }).finally(() => { this.loading = false });
    },
    methods: {
        async submitClick() {
            const validation_result = await this.v$.$validate();

            if (!validation_result) {
                return false;
            }

            let desk_data = JSON.parse(JSON.stringify( this.desk ));

            axios.patch('/api/v1/desks/' + this.deskId, desk_data)
                .then(response => {
                console.log(response);
            });
        },
    },
    validations: {
        desk: {
            desk_name: {
                required,
                maxLength: maxLength(255),
                minLength: minLength(3),
            },
        }
    },
}
</script>

<style scoped>

</style>
