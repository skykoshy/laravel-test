<template>
    <div class="row">
        <div v-if="showAlert" class="alert alert-primary" role="alert">
                {{mensaje}}
        </div>
        <span class="text-right">Hola {{nombre}} <a type="button" @click="salir()" class="text-danger"><i class="fas fa-power-off"></i></a></span>
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h4>Actualizar Factura</h4></div>
                <div class="card-body">
                    <div class="col-12">
                        <form @submit.prevent="actualizar">
                            <div class="row">
                                <div class="col-6 mb-12">
                                    <div class="form-group">
                                        <label>Nombre emisor</label>
                                        <input type="text" required class="form-control" v-model="factura.nombre_emisor">
                                    </div>
                                </div>
                                <div class="col-6 mb-12">
                                    <div class="form-group">
                                        <label>NIT emisor</label>
                                        <input type="number" required class="form-control" v-model="factura.nit_emisor">
                                    </div>
                                </div>
                                <div class="col-6 mb-12">
                                    <div class="form-group">
                                        <label>Nombre receptor</label>
                                        <input type="text" required class="form-control" v-model="factura.nombre_receptor">
                                    </div>
                                </div>
                                <div class="col-6 mb-12">
                                    <div class="form-group">
                                        <label>NIT receptor</label>
                                        <input type="number" required class="form-control" v-model="factura.nit_receptor">
                                    </div>
                                </div>
                                <div class="col-6 mb-12">
                                    <div class="form-group">
                                        <label>Valor sin IVA</label>
                                        <input type="number" required class="form-control" v-model="factura.valor_sin_iva">
                                    </div>
                                </div>
                                <div class="col-6 mb-12">
                                    <div class="form-group">
                                        <label>IVA</label>
                                        <input type="number" required class="form-control" v-model="factura.iva">
                                    </div>
                                </div>
                                <div class="col-6 mb-12">
                                    <div class="form-group">
                                        <label>Valor total</label>
                                        <input type="number" required class="form-control" v-model="factura.valor_total">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <br>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </div>
                            </div>                        
                        </form>
                        <div class="table-responsive">
                            <form @submit.prevent="crear">
                            <table class="table table-bordered caption-top">
                                <caption>Items de la factura</caption>
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cant</th>
                                        <th>Val unitario</th>
                                        <th>Val total</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in factura.items" :key="item.id">
                                        <td>{{ item.descripcion }}</td>
                                        <td>{{ item.cantidad }}</td>
                                        <td>{{ item.valor_unitario }}</td>
                                        <td>{{ item.valor_total }}</td>
                                        <td class="text-center">
                                            <a type="button" @click="borrarItem(item.id)" class="fas fa-trash text-danger"></i></a>
                                        </td>
                                    </tr>
                                    
                                    
                                    <tr>
                                            
                                        <td>
                                            <input type="text" required class="form-control" v-model="item.descripcion">
                                        </td>
                                        <td>
                                            <input type="number" required class="form-control" v-model="item.cantidad">
                                        </td>
                                        <td>
                                            <input type="number" required class="form-control" v-model="item.valor_unitario">

                                        </td>
                                        <td>
                                            <input type="number" required class="form-control" v-model="item.valor_total">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">Agregar</button>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </form>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"crear-item",
    data(){
        return {
            item:{
                id:"",
                descripcion:"",
                cantidad:"",
                valor_unitario:"",
                valor_total:"",
                factura_id:"",
            },
            factura:{
                id:"",
                numero_factura:"",
                nombre_emisor:"",
                nit_emisor:"",
                nombre_receptor:"",
                nit_receptor:"",
                valor_total:"",
                iva:"",
                valor_sin_iva:"",
                items:[]
            },
            mensaje:"",
            showAlert:false,
            nombre:localStorage.nombre
            
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        async getData(){
            await this.axios.get(`/api/factura/${this.$route.params.id}`,{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
                this.factura.id = response.data.id
                this.factura.numero_factura =  response.data.numero_factura
                this.factura.nombre_emisor = response.data.nombre_emisor
                this.factura.nit_emisor = response.data.nit_emisor
                this.factura.nombre_receptor = response.data.nombre_receptor
                this.factura.nit_receptor = response.data.nit_receptor
                this.factura.valor_total = response.data.valor_total
                this.factura.valor_sin_iva = response.data.valor_sin_iva
                this.factura.iva = response.data.iva
                this.factura.items = response.data.items
                this.item.factura_id = response.data.id
                
            }).catch(error=>{
                console.log(error)
            })
        },
        borrarItem(id){
            if(confirm("¿Confirma eliminar el registro?")){
                this.axios.delete(`/api/item/${id}`,{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
                    this.getData();
                    this.mensaje = response.data.mensaje
                    this.showAlert = true;
                    setTimeout(() => {this.showAlert = false;}, 2000);  
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
        
        async crear(){
            await this.axios.post('/api/item',this.item,{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
               this.getData();
               this.unsetItemForm();
               this.mensaje = response.data.mensaje
               this.showAlert = true;
               setTimeout(() => {this.showAlert = false;}, 2000);
            }).catch(error=>{
                console.log(error)
            })
        },
        async actualizar(){
            await this.axios.put(`/api/factura/${this.$route.params.id}`,this.factura,{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
               this.getData();
               this.unsetItemForm();
               this.mensaje = response.data.mensaje
               this.showAlert = true;
               setTimeout(() => {this.showAlert = false;}, 2000);
            }).catch(error=>{
                console.log(error)
            })
        },
        unsetItemForm(){
            this.item.id=""
            this.item.descripcion=""
            this.item.cantidad=""
            this.item.valor_unitario=""
            this.item.valor_total=""
            this.item.factura_id=""
            this.mensaje=""
        },
        salir()
        {
            
            localStorage.removeItem('nombre')
            localStorage.removeItem('token')
            localStorage.auth = false
            this.$router.push({name:"login"})
        }
    }
}
</script>