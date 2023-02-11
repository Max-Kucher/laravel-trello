<template>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-3 mb-5">Доски</h1>

            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                <div class="card">
<!--                    <img src="https://images.all-free-download.com/images/graphiclarge/camera_test_apple_563728.jpg" class="card-img-top" alt="Яблоки">-->
                    <div class="card-header">Card title</div>
<!--                    <ul class="list-group list-group-flush">-->
<!--                        <li class="list-group-item">An item</li>-->
<!--                        <li class="list-group-item">A second item</li>-->
<!--                        <li class="list-group-item">A third item</li>-->
<!--                    </ul>-->
                    <div class="card-body">
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
            </div>
<!--            <div class="col-lg-4 col-md-6 col-sm-12">2</div>-->
<!--            <div class="col-lg-4 col-md-6 col-sm-12">3</div>-->
<!--            <div class="col-lg-4 col-md-6 col-sm-12">4</div>-->
        </div>
    </div>


</template>

<script>
    export default {
        data() {
            return {
                desks: []
            }
        },
        mounted() {
            axios.get('api/v1/descs')
                .then(response => {
                    console.log(response);
                })
        },
    }
</script>

<style scoped>

</style>
