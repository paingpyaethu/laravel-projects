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
            <div class="input-group">
               <input type="text" class="form-control" placeholder="Search">
               <button class="btn btn-primary">
                  <i class="fas fa-search"></i>
               </button>
            </div>
         </div>
      </div>
      <!-- Search End -->



      <div class="row">
         <!-- Create -->
         <div class="col-12 col-md-4">
            <div class="card shadow-sm">
               <h5 class="card-header fw-bold">{{ isEditMode ? 'Edit' : 'Create' }}</h5>
               <div class="card-body">
                  <div class="form-floating mb-3">
                     <input v-model="product.name" type="text" class="form-control" id="Name" placeholder="Product Name">
                     <label for="Name">Name</label>
                  </div>
                  <div class="form-floating mb-3">
                     <input v-model="product.price" type="number" class="form-control" id="Product Price" placeholder="Password">
                     <label for="Product Price">Price</label>
                  </div>
                  <button class="btn btn-primary" @click="isEditMode ? update() : store()">
                     <i class="fas fa-save"></i>
                     Submit
                  </button>
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
                  <tr v-for="product in products.data" :key="product.id">
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

            <pagination :data="products" @pagination-change-page="show"></pagination>
         </div>
         <!-- Show Products End -->

      </div>
   </div>
</template>

<script>
   export default {
      name: "ProductComponent",
      data() {
         return {
            isEditMode: false,
            products: {},
            product: {
               id: '',
               name: '',
               price: ''
            }
         }
      },
      methods: {
         show(page = 1) {
            axios.get('/api/products?page=' + page)
               .then( response => {
               this.products = response.data;
            });
         },
         create() {
            this.isEditMode = false;
            this.product.id = '';
            this.product.name = '';
            this.product.price = '';
         },
         store() {
            axios.post('/api/products', this.product)
            .then( () => {
               this.show();
               this.product = { id: '', name: '', price: ''};
               // this.product.id = '';
               // this.product.name = '';
               // this.product.price = '';
            })
         },
         edit(product) {
            this.isEditMode = true;
            this.product.id = product.id;
            this.product.name = product.name;
            this.product.price = product.price;
         },
         update() {
            axios.put(`/api/products/${this.product.id}`, this.product)
            .then(() => {
               this.show();
               this.product.id = '';
               this.product.name = '';
               this.product.price = '';
            })
         },
         destroy(id) {
            if (!confirm('Are you sure to delete?'))
            {
               return;
            }
            axios.delete(`/api/products/${id}`)
            .then(() => this.show());
         }
      },
      created() {
         this.show();
      }
   }
</script>