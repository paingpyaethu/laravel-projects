<template>
   <div class="container my-5">
      <div class="row mb-3 justify-content-end">
         <div class="col-12 col-md-5">
            <button class="btn btn-primary">
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
      <div class="row">

         <div class="col-12 col-md-4">
            <div class="card shadow-sm">
               <h5 class="card-header fw-bold">Create</h5>
               <div class="card-body">
                  <div class="form-floating mb-3">
                     <input type="text" class="form-control" id="Name" placeholder="Product Name">
                     <label for="Name">Name</label>
                  </div>
                  <div class="form-floating mb-3">
                     <input type="number" class="form-control" id="Product Price" placeholder="Password">
                     <label for="Product Price">Price</label>
                  </div>
                  <button class="btn btn-primary">
                     <i class="fas fa-save"></i>
                     Submit
                  </button>
               </div>
            </div>
         </div>

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
                        <button class="btn btn-sm btn-outline-secondary">
                           <i class="fas fa-edit"></i>
                           Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                           <i class="fas fa-trash-alt"></i>
                           Del
                        </button>
                     </td>
                  </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
   export default {
      name: "ProductComponent",
      data() {
         return {
            products: []
         }
      },
      methods: {
         view() {
            axios.get('/api/products').then( response => {
               this.products = response.data;
            });
         }
      },
      created() {
         this.view();
      }
   }
</script>