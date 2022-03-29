<template>
   <div class="container my-5">

      <!-- Search -->
      <div class="row mb-3 justify-content-end">
         <div class="col-12 col-md-5">
            <button class="btn btn-primary" @click="create">
               <i class="fas fa-circle-plus"></i>
               Create
            </button>
         </div>
         <div class="col-12 col-md-3">
            <form @submit.prevent="show">
               <div class="input-group">
                  <input v-model="search" type="text" class="form-control" placeholder="Search">
                  <button type="submit" class="btn btn-primary">
                     <i class="fas fa-search"></i>
                  </button>
               </div>
            </form>
         </div>
      </div>
      <!-- Search End -->

      <div class="row">
         <!-- Create -->
         <div class="col-12 col-md-4">
            <div class="card shadow-sm">
               <h5 class="card-header fw-bold">{{ isEditMode ? 'Edit' : 'Create' }}</h5>
               <div class="card-body">

                  <form @submit.prevent="isEditMode ? update() : store()" @keydown="product.onKeydown($event)">

                     <AlertError :form="product" :message="message" />

                     <div class="form-floating mb-3">
                        <input v-model="product.name" type="text" class="form-control" name="name" id="Name" placeholder="Product Name">
                        <label for="Name">Name</label>
                        <HasError :form="product" field="name" />
                     </div>
                     <div class="form-floating mb-3">
                        <input v-model="product.price" type="number" class="form-control" name="price" id="Product Price" placeholder="Password">
                        <label for="Product Price">Price</label>
                        <HasError :form="product" field="price" />
                     </div>
                     <Button :form="product" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Submit
                     </Button>
                  </form>
               </div>
            </div>
         </div>
         <!-- Create End -->

         <!-- Show Products -->
         <div class="col-12 col-md-8">
            <div class="table-responsive">
               <table class="table table-striped table-hover border-top">
                  <thead>
                  <tr>
                     <th>#</th>
                     <th>Name</th>
                     <th>Price</th>
                     <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="product in products" :key="product.id">
                     <td>{{ product.id }}</td>
                     <td>{{ product.name }}</td>
                     <td>{{ product.price }}</td>
                     <td>
                        <button class="btn btn-sm btn-outline-secondary" @click="edit(product)">
                           <i class="fas fa-edit"></i>
                           Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" @click="destroy(product.id)">
                           <i class="fas fa-trash-alt"></i>
                           Del
                        </button>
                     </td>
                  </tr>
                  </tbody>
               </table>
            </div>

<!--            <pagination :data="products" @pagination-change-page="show"></pagination>-->
         </div>
         <!-- Show Products End -->

      </div>
   </div>
</template>

<script>

   import Form from 'vform'
   import { Button, HasError, AlertError } from 'vform/src/components/bootstrap5'

   export default {
      name: "ProductComponent",

      components: {
         Button, HasError, AlertError
      },
      data() {
         return {
            isEditMode: false,
            search: '',
            products: [],
            product: new Form({
               id: '',
               name: '',
               price: ''
            }),
            message: ''
         }
      },
      methods: {
         show() {
            this.$Progress.start();
            axios.get(`/api/products`)
               .then( response => {
               this.products = response.data;
                  this.$Progress.finish();
               }).catch(() => {
               this.$Progress.fail();
            })
         },
         create() {
            this.isEditMode = false;
            this.product.clear();
            this.product.reset();
         },
         store() {
            this.product.post('/api/products')
            .then( () => {
               this.show();
               this.product.reset();
               Toast.fire({
                  icon: 'success',
                  title: 'Product Created successfully'
               })

            }).catch(error => {
               this.message = error.response.data.message;
            })
         },
         edit(product) {
            this.isEditMode = true;
            this.product.clear();
            this.product.fill(product);
         },
         update() {
            this.product.put(`/api/products/${this.product.id}`)
            .then(() => {
               this.show();
               this.product.reset();
               Toast.fire({
                  icon: 'success',
                  title: 'Product updated successfully'
               })
            })
         },
         destroy(id) {
            Swal.fire({
               title: 'Are you sure?',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Delete'
            }).then((result) => {
               if (result.isConfirmed) {
                  axios.delete(`/api/products/${id}`).then(() => {
                     this.show();
                     Swal.fire({title:'Deleted!', icon:'success'});
                     Toast.fire({
                        icon: 'success',
                        title: 'Product Deleted successfully'
                     })
                  });
               }
            });
         }
      },
      created() {
         this.show();
      }
   }
</script>