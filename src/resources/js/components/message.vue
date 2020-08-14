<template>

    <div class="container mt-5">
        <div class="alert alert-success" role="alert" v-if="success">
            {{ success }}
        </div>

        <div class="alert alert-danger" role="alert" v-if="error">
            {{ error }}
        </div>
    </div>

</template>

<script>

export default{
    data(){
        return{
            success : null,
            error : null
        }
    },
    created(){
        this.messageListener()
    },
    methods : {
        messageListener(){
            let self = this
            self.$root.$on('message',function(msg){
                self.showMessage(msg.type,msg.message)
            })
        },
        showMessage(type,message){
            this.success = null
            this.error = null

            if(type == "error"){
                this.error = message
            }else{
                this.success = message
            }

            this.clearMessage()
        },
        clearMessage(){
            setTimeout(() => {
                this.success = null
                this.error = null
            },3000);
        }

    }
}

</script>
