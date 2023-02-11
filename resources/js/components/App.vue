<template>
    <nav class="bg-dark" role="navigation">
        <div class="container">
            <div class="navbar navbar-expand-lg navbar-dark row">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <router-link :to="{ name: 'index' }" class="nav-link" exact-active-class="active">Home</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'desks' }" class="nav-link" exact-active-class="active">Descs</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <router-view></router-view>
</template>

<script>
export default {

}
</script>

<style scoped>

</style>
