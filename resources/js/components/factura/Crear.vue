<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h4>Crear Factura</h4></div>
                <div class="card-body">
                    <form @submit.prevent="crear">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Nombre emisor</label>
                                    <input type="text" required class="form-control" v-model="factura.nombre_emisor">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>NIT emisor</label>
                                    <input type="number" required class="form-control" v-model="factura.nit_emisor">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Nombre receptor</label>
                                    <input type="text" required class="form-control" v-model="factura.nombre_receptor">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>NIT receptor</label>
                                    <input type="number" required class="form-control" v-model="factura.nit_receptor">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Valor sin IVA</label>
                                    <input type="number" required class="form-control" v-model="factura.valor_sin_iva">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>IVA</label>
                                    <input type="number" required class="form-control" v-model="factura.iva">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Valor total</label>
                                    <input type="number" required class="form-control" v-model="factura.valor_total">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"crear-factura",
    data(){
        return {
            factura:{
                nombre_emisor:"",
                nit_emisor:"",
                nombre_receptor:"",
                nit_receptor:"",
                valor_sin_iva:"",
                iva:"",
                valor_total:"",
            }
        }
    },
    methods:{
        async crear(){
            await this.axios.post('/api/factura',this.factura,{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
                this.$router.push({name:"editarFactura", params: { id: response.data.factura.id }})
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>