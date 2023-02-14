<template>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <form method="post" class="card text-bg-dark">
            <div class="card-header">
                <input type="text"
                       name="desk_name"
                       class="form-control"
                       :class="{ 'is-invalid': v$.desk_name.$error, 'is-valid': !v$.desk_name.$error && desk_name.length }"
                       placeholder="Название доски"
                       v-model="desk_name"
                       @input.stop.prevent="v$.desk_name.$touch"
                >

                <div class="valid-feedback">
                    Выглядит здорово!
                </div>
                <div class="invalid-feedback" v-if="v$.desk_name.required.$invalid">
                    Вы должны заполнить название доски.
                </div>
                <div class="invalid-feedback" v-if="v$.desk_name.minLength.$invalid">
                    Длинна названия доски должна быть больше {{ v$.desk_name.minLength.$params.min }} букв
                </div>
                <div class="invalid-feedback" v-if="v$.desk_name.maxLength.$invalid">
                    Длинна названия доски не должна быть больше {{ v$.desk_name.maxLength.$params.max }} букв
                </div>
            </div>

            <div class="card-body">
                <textarea name="desk_description"
                          class="form-control" cols="30"
                          rows="1"
                          placeholder="Описание доски"
                          v-model="desk_description"
                ></textarea>
            </div>
            <div class="card-body d-flex justify-content-between align-items-center">
                <button @click.stop.prevent="createDesk" class="btn btn-outline-primary w-100">
<!--                    <i class="bi bi-plus"></i>-->
                    <span>Создать</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { useVuelidate } from '@vuelidate/core';
import { required, maxLength, minLength } from '@vuelidate/validators';

export default {
    setup() {
        return {
            v$: useVuelidate()
        }
    },
    methods: {
        async createDesk (event) {
            const validation_result = await this.v$.$validate();

            if (!validation_result) {
                return false;
            }

            let target_form = event.currentTarget.form;
            let form_entries = Object.entries(target_form);

            let form_data = { };
            form_entries.forEach(input => {
                form_data[input[1].name] = input[1].value;
            });

            axios.post('/api/v1/desks/', form_data)
                .then(response => {
                    this.$emit('ondeskcreated', response.data.data)
                }).catch(err => {
                    console.log(err)
            }).finally(() => {
                this.desk_name = this.desk_description = '';
            });
        },
    },
    data() {
        return {
            desk_name: '',
            desk_description: '',
        }
    },
    validations: {
        desk_name: {
            required,
            maxLength: maxLength(255),
            minLength: minLength(3),
        }
    },
}
</script>

<style scoped>

</style>
