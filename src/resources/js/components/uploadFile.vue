<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                {{header}}
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <input type="file" class="csvFileUpload" ref="file" @change="uploadButtonActive()">
                        <input type="button" class="btn btn-primary" value="Upload" v-on:click="submitFile()" v-if="isUploadButtonActive">
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props : ['header','fileId'],
    data: function(){
        return {
            success : null,
            error : null,
            isUploadButtonActive : false
        }
    },
    methods: {
        resetFileInput(){
            this.$refs.file.value = null;
        },
        submitFile (){
            let self = this;
            let formData = new FormData();

            formData.append('csv', this.$refs.file.files[0]);

            let url = '/api/file/create';
            if(this.fileId){
                url = '/api/file/'+this.fileId+'/edit';
            }

            axios
            .post(url,
                formData,{headers: {'Content-Type': 'multipart/form-data'}}
                )
            .then(function(res){
                if(res){
                    self.resetFileInput();
                    self.$root.$emit('message',{type : "success",message : res.data.message})
                    self.$root.$emit('newFile',true);
                }
            })
            .catch(function(err){
                if(err){
                    self.$root.$emit('message',{type : "error", message : "Your request can not be proccessed, please contact with administrator!"})
                }
            });

        },
        uploadButtonActive(){
            this.isUploadButtonActive = true
        }
    }
}

</script>
