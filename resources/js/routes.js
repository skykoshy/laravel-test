import VueRouter from 'vue-router'

const Home = () => import('./components/Home.vue')
const Login = () => import('./components/Login.vue')
//importamos los componentes para la gestion de las facturas
const Mostrar = () => import('./components/factura/Mostrar.vue')
const Crear = () => import('./components/factura/Crear.vue')
const Editar = () => import('./components/factura/Editar.vue')
const Registro = () => import('./components/Registro.vue')

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
    },
    {
        name: 'mostrarFacturas',
        path: '/facturas',
        component: Mostrar,
        meta:{'requiresAuth':true}
        
    },
    {
        name: 'crearFactura',
        path: '/crear',
        component: Crear,
        meta:{'requiresAuth':true}
        
    },
    {
        name: 'editarFactura',
        path: '/editar/:id',
        component: Editar,
        meta:{'requiresAuth':true}
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'registro',
        path: '/registro',
        component: Registro
    }
    
]

