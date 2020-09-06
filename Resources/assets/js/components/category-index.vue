<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{title}}
                    </div>

                    <div class="card-body">
                        {{initMsj}} : {{moduleName}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        moduleName: String,
        initMsj: String
    },
    mounted() {
        console.log('Component mounted.')
    },
    data() {
        return {
            loading : false
        }
    }
}
</script>
