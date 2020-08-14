<template>
    <div class="container mt-5">
        <div class="mb-5">
            <a href="/" class="btn btn-primary">Back to List</a>
        </div>
        <div class="card">
            <div class="card-header">
                {{fileName}}
            </div>
            <div class="card-body">
                <h5 class="card-title">Create a calculated field</h5>
                <form>
                    <div class="form-group" v-if="columnsReadyCompute.length > 0">
                        <label>Compute Column</label>
                        <select class="form-control" v-model="computedColumn">
                            <option v-for="(column,index) in columnsReadyCompute" v-bind:key="index" :value="column.id">{{column.title}}</option>
                        </select>
                    </div>
                    <div class="form-group" v-else>
                        <label>There is no numeric column to compute</label>
                    </div>
                    <div class="form-group" v-if="columnsReadyCompute.length > 0">
                        <label>Calculation</label>
                        <select class="form-control" v-model="calculation">
                            <option v-for="(calculation,index) in calculations" v-bind:key="index" :value="calculation">{{calculation}}</option>
                        </select>
                    </div>
                    <div class="form-group" v-if="columnsReadyGroupBy.length > 0">
                        <label>Group By</label>
                        <select class="form-control" v-model="groupByColumn">
                            <option v-for="(column,index) in columnsReadyGroupBy" v-bind:key="index" :value="column.id">{{column.title}}</option>
                        </select>
                    </div>
                    <div class="form-group" v-else>
                        <label>There is no text column to groupBy</label>
                    </div>
                    <div class="form-group" v-if="computedColumn && groupByColumn && calculation">
                        <input type="button" class="btn btn-primary" value="Create" v-on:click="sendComputed()">
                    </div>
                </form>
                <div class="float-right">
                    <a class="btn btn-success" :href="'/api/file/'+$route.params.id"> Download Csv with Computed Columns </a>
                </div>
            </div>
        </div>

        <uploadfile header="Csv Append" :fileId="$route.params.id"></uploadfile>
    </div>
</template>

<script>
export default {
    data (){
        return {
            fileName : null,
            columnsReadyCompute : [],
            columnsReadyGroupBy : [],
            calculations: ["sum","avg","min","max","count"],

            computedColumn : null,
            groupByColumn: null,
            calculation: null
        }
    },
    created(){
        this.getFileInfo()
    },
    methods: {

        sendComputed(){

            let self = this
            let postData = {
                fileId : this.$route.params.id,
                computeColumn : this.computedColumn,
                groupByColumn : this.groupByColumn,
                calculation : this.calculation,
            };



            axios
            .post('/api/compute/create', postData)
            .then(function(res){
                self.$root.$emit('message',{type : "success",message : res.data.message})
            })
            .catch(function(err){
                if(err){
                    console.log(err)
                    self.$root.$emit('message',{type : "error",message : "The file could not loaded, please contact with administrator!"})
                }
            });
        },
        getFileInfo(){
            let self = this
            let fileId = this.$route.params.id

            axios
            .get('/api/csv/'+fileId)
            .then(function(res){
                let file = JSON.parse(res.data)
                self.fileName = file.title
                self.columnsReadyCompute = file.columns.filter(column => column.isNumeric == 1)
                self.columnsReadyGroupBy = file.columns.filter(column => column.isNumeric == 0)
            })
            .catch(function(err){
                if(err){
                    self.$root.$emit('message',{type : "error",message : "The file could not loaded, please contact with administrator!"})
                }
            });
        }
    }
}
</script>
