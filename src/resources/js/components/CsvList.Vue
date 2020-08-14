<template>

    <div>
        <uploadfile header="Csv Upload" :fileId="null"></uploadfile>
        <table class="table mt-5" v-if="files.length > 0">
            <thead>
                <tr>
                    <th scope="col">File Name</th>
                    <th scope="col">Upload Date</th>
                    <th scope="col">Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(file,index) in files" v-bind:key="index" :style="[(index == 0 && newFile) ? {'background':'#f3f3f3'} : {'background':'#fff'}]">
                    <td>{{ file.title }}</td>
                    <td>{{ file.created_at }} </td>
                    <td> <a class="btn btn-info" :href="'/csv/'+file.id" role="button">Detail</a> </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>

export default {
    data: function(){
        return {
            files : [],
            newFile : false
        }
    },
    created() {
        this.getList()
        this.newFileListener()
    },
    methods: {
        getList() {
            let self = this

            axios
            .get('/api/csv')
            .then(function(res){
                self.files = JSON.parse(res.data)
            })
            .catch(function(err){
                if(err){
                    self.$root.$emit('error',{type : "success",message : "The file list could not loaded, please contact with administrator!"})
                }
            });
        },
        newFileListener(){
            let self = this;
            self.$root.$on('newFile',function(status){
                if(status){
                    self.getList();
                    self.newFileIndicator()
                }
            })
        },
        newFileIndicator(){
            this.newFile = true
            setTimeout(() => this.newFile = false, 5000);
        }
    }
}


</script>
