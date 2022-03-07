<template>
    <div class="row">
        <div class="col-12 mb-2">
            <!-- llamamos al componente para Crear   -->
            <router-link :to='{name:"crearFactura"}' class="btn btn-success"><i class="fas fa-plus-circle"></i></router-link>
            <span class="text-right">Hola {{nombre}} <a type="button" @click="salir()" class="text-danger"><i class="fas fa-power-off"></i></a></span>
        </div>
        <div class="col-12">             
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No. Factura</th>
                            <th>Fecha</th>
                            <th>Remitente</th>
                            <th>Receptor</th>
                            <th>Valor total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="factura in facturas" :key="factura.id">
                            <td>{{ factura.numero_factura }}</td>
                            <td>{{ factura.fecha }}</td>
                            <td>{{ factura.nombre_emisor }}</td>
                            <td>{{ factura.nombre_receptor }}</td>
                            <td>{{ factura.valor_total }}</td>
                            <td>
                                <!-- llamamos al componente para Editar     -->
                                <router-link :to='{name:"editarFactura",params:{id:factura.id}}' class="btn btn-info"><i class="fas fa-edit"></i></router-link>
                                <a type="button" @click="borrarFactura(factura.id)" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>                          
        </div>
    </div>
</template>

<script>
//Bootstrap and jQuery libraries
import 'jquery/dist/jquery.min.js';
//Datatable Modules
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery'; 
export default {
    name:"facturas",
    data(){
        return {
            facturas:[],
            nombre:localStorage.nombre
        }
    },
    mounted(){
        
        this.mostrarFacturas()
        
    },
    methods:{
        async mostrarFacturas(){
            await this.axios.get('/api/factura',{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
                this.facturas = response.data
                setTimeout(() => {
                    $("#datatable").DataTable({
                        lengthMenu: [
                        [5,10, 25, 50, -1],
                        [5,10, 25, 50, "All"],
                        ],
                        pageLength: 5,
                    });
                });
                
            }).catch(error=>{
                console.log(error)
                this.facturas = []
            })
        },
        borrarFactura(id){
            if(confirm("¿Confirma eliminar el registro?")){
                this.axios.delete(`/api/factura/${id}`,{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
                    this.mostrarFacturas()
                }).catch(error=>{
                    console.log(error)
                })
            }
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