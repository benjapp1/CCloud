<style>
    .v-dialog
    {
        width: 50% !important;
        background-color: white;
    }
</style>
<template>
    <main>
        <div class="row">
            <div class="col-6">
                <h2 class="display-6 mb-4">Lista de usuarios</h2>
            </div>
            <div class="col-6">
                <v-btn class="btn btn-primary" @click="abrirModalusuario()" style="float: right !important;">
                    <span>Agregar usuario</span>
                </v-btn>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table text-center">
            <thead>
                <tr>
                    <th style="width: 10%;">ID</th>
                    <th style="width: 30%;">Nombre</th>
                    <th style="width: 30%;">Email</th>
                    <th style="width: 10%;">Fecha de cumpleaños</th>
                    <th style="width: 10%;">Estado</th>
                    <th style="width: 10%;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="usuarios.data.length">
                    <tr v-for="usuario in usuarios.data">
                        <td> {{ usuario.id }}</td>
                        <td> {{ usuario.name }} </td>
                        <td> {{ usuario.email }} </td>
                        <td> {{ usuario.birthdate }} </td>
                        <td v-if="usuario.active == 1"> 
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </td>
                        <td v-else>
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </td>
                        <td style="display:flex !important">
                            <v-btn class="btn btn-primary" @click="editarUsuario(usuario.id)" style="float: right !important; width: 50% !important">
                                <span>Editar</span>
                            </v-btn>
                            <v-btn class="btn btn-primary" @click="eliminarUsuario(usuario.id)" style="float: right !important; width: 50% !important">
                                <span>Eliminar</span>
                            </v-btn> 
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr>
                        <td colspan="6">No existen usuarios creados</td>
                    </tr>
                </template>
                
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item" v-show="usuarios.first_page_url">
                    <button class="page-link" @click.prevent="getFirstPage"><i class="fa fa-fast-backward" aria-hidden="true"></i></button>
                </li>
                <li class="page-item" v-show="usuarios.prev_page_url">
                    <button class="page-link" @click.prevent="getPreviousPage"><i class="fa fa-backward" aria-hidden="true"></i></button>
                </li>
                <li class="page-item" v-show="usuarios.next_page_url">
                    <button class="page-link" @click.prevent="getNextPage"><i class="fa fa-forward" aria-hidden="true"></i></button>
                </li>
                <li class="page-item" v-show="usuarios.last_page_url">
                    <button class="page-link" @click.prevent="getLastPage"><i class="fa fa-fast-forward" aria-hidden="true"></i></button>
                </li>
            </ul>
        </nav>
        </div>
        <v-dialog v-model="modalUsuario" style="width: 50% !important; background-color: white;">
            <v-main>
                <v-col cols="12">
                    <template>
                    <div class="row">
                        <div class="col-12">
                            <label class="label-sm" style="font-size: 16px;">Agregar usuario</label>
                            <v-btn class="close" text @click="cerrarModalUsuario()" style="float: right; border: 1px solid blue;"> 
                                X
                            </v-btn>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="margin-bottom: 0px;">
                            <label for="anio" class="label-sm" style="font-size: 16px;">Nombre</label>
                            <v-text-field
                                v-model="nombre"
                                class="form-control"
                                style="max-width: 100% !important"
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="margin-bottom: 0px;">
                            <label for="anio" class="label-sm" style="font-size: 16px;">Correo Electronico</label>
                            <v-text-field
                                v-model="email"
                                :rules="emailRules"
                                class="form-control"
                                style="max-width: 100% !important"
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="margin-bottom: 0px;">
                            <label for="anio" class="label-sm" style="font-size: 16px;">Contraseña</label>
                            <v-text-field
                                v-model="contrasena"
                                type="password"
                                class="form-control"
                                style="max-width: 100% !important"
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="margin-bottom: 0px;">
                            <label for="anio" class="label-sm" style="font-size: 16px;">Activo</label>
                            <v-select
                                v-model="activado"
                                :items="items"
                                item-value="id" 
                                item-text="name"
                            ></v-select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="margin-bottom: 0px;">
                            <label for="anio" class="label-sm" style="font-size: 16px;">Fecha de cumpleaños</label>
                            <input type="date" v-model="fecha">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="margin-bottom: 0px;">
                            <v-btn class="btn btn-primary" @click="guardarUsuario()" >
                                <span>Guardar</span>
                            </v-btn>
                        </div>
                        <br>
                    </div>
                    </template>
                </v-col>
            </v-main>
        </v-dialog>
        <ul>
        </ul>
    </main>
</template>
<script>
    export default {
        data: () => ({
            usuarios: {},
            modalUsuario: false,
            fecha: '',
            nombre: '',
            contrasena: '',
            email: '',
            nombre: '',
            activado: '',
            id: '',
            errors: [],
            items: [
                {
                    id: 1,
                    name: "Si"
                },
                {
                    id: 2,
                    name: "No",
                }
            ],
            emailRules: [
                v => !!v || 'Email requerido',
                v => /.+@.+/.test(v) || 'Email invalido',
            ],
        }),
        mounted() 
        {
            this.obtenerUsuarios();
        },
        methods: {
            abrirModalusuario()
            {
                this.modalUsuario = true;
                this.editar = false;
                this.id = '';
            },
            obtenerUsuarios()
            {
                axios.get('/api/getUsers', { headers: { 'x-ccloud-auth': 'prueba'}})
                .then( response => {
                    this.usuarios = response.data.data.users;
                });
            },
            cerrarModalUsuario()
            {
                this.fecha = '';
                this.nombre = '';
                this.contrasena = '';
                this.email = '';
                this.activado = '';
                this.id = '';
                this.modalUsuario = false;
                this.editar = false;
            },
            editarUsuario(id)
            {
                this.modalUsuario = true;
                this.editar = true;
                let t = this;
                this.usuarios.data.forEach((value, index) => {
                    if(id == value.id)
                    {
                        t.fecha = value.birthdate;
                        t.nombre = value.name;
                        t.contrasena = value.contrasena;
                        t.email = value.email;
                        t.activado = value.active;
                        t.id = value.id;
                    }
                });
            },
            guardarUsuario()
            {
                if(this.editar == false)
                {
                    let t = this;
                    let params = new FormData();
                    params.append('name', this.nombre);
                    params.append('password', this.contrasena);
                    params.append('email', this.email);
                    params.append('birthdate', this.fecha);
                    params.append('active', this.activado);
                    axios.post('/api/save', params, { headers: { 'x-ccloud-auth': 'prueba'}})
                    .then(response=> {
                        this.obtenerUsuarios();
                        this.cerrarModalUsuario();  

                    }).catch(error => {
                        this.mostrarToast(error);
                    });
                }
                else
                {
                    let t = this;
                    let params = new FormData();
                    params.append('id', this.id);
                    params.append('name', this.nombre);
                    params.append('password', this.contrasena);
                    params.append('email', this.email);
                    params.append('birthdate', this.fecha);
                    params.append('active', this.activado);
                    axios.post('/api/update', params, { headers: { 'x-ccloud-auth': 'prueba'}})
                    .then(response=> {
                        this.obtenerUsuarios();
                        this.cerrarModalUsuario();
                    }).catch(error => {
                        this.mostrarToast(error);
                    });
                }
                
            },
            eliminarUsuario(id)
            {
                let t = this;
                let params = new FormData();
                params.append('id', id);
                axios.post('/api/delete', params, { headers: { 'x-ccloud-auth': 'prueba'}})
                .then(response=> {
                    this.obtenerUsuarios();
                })
                .catch(error => {
                    this.mostrarToast(error);
                });
            },
            getFirstPage(){
                axios.get(this.usuarios.first_page_url, { headers: { 'x-ccloud-auth': 'prueba'}}).then((response) => {                  
                    this.usuarios = response.data.data.users;
                });
            },
            getPreviousPage(){
                axios.get(this.usuarios.prev_page_url, { headers: { 'x-ccloud-auth': 'prueba'}}).then((response)=>{ 
                    console.log(response);                 
                    this.usuarios = response.data.data.users;
                });
            },
            getNextPage(){
                axios.get(this.usuarios.next_page_url, { headers: { 'x-ccloud-auth': 'prueba'}}).then((response)=>{ 
                    console.log(response);                  
                    this.usuarios = response.data.data.users;
                });
            },
            getLastPage(){
                axios.get(this.usuarios.last_page_url, { headers: { 'x-ccloud-auth': 'prueba'}}).then((response)=>{  
                    console.log(response);                 
                    this.usuarios = response.data.data.users;
                });
            },
            mostrarToast(error)
            {
                this.errors = error.response.data.errors;
                let t = this;
                for (var prop in t.errors) {
                    if ( t.errors.hasOwnProperty(prop) ) {
                        t.$toasted.show('' + this.errors[prop] +'', { 
                            theme: "bubble", 
                            position: "top-right", 
                            duration : 1500
                        });
                    }
                }
                
            }
        }
    };
</script>