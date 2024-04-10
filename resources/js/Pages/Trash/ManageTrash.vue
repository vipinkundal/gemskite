<template>
  <div>
    <h1>Product Trash</h1>
    <table class="table">
      <thead>
        <tr>
          <th>S No.</th>
          <th>SKU</th>
          <th>Stone Name</th>
          <th>Shape</th>
          <th>Price</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(product, index) in products" :key="index">
          <td>{{ product.id }}</td>
          <td>{{ product.sku }}</td>
          <td>{{ product.stone_name }}</td>
          <td>{{ product.shape }}</td>
          <td>{{ product.price }}</td>
          <td>{{ product.created_at }}</td>
          <td>
            <!-- <span v-if="customer.status == '1'" class="badge badge-success">Active</span> -->
            <!-- <span v-else class="badge badge-danger">Inactive</span> -->
          </td>
          <td>
            <a :href="`/manage/trashes/product/delete/${product.id}`" class="mx-1">
              <button class="btn btn-danger">Delete</button>
            </a>
            <a :href="`/manage/trashes/product/restore/${product.id}`" class="mx-1">
              <button class="btn btn-primary">Restore</button>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div>
    <h1>Dealer Trash</h1>
    <table class="table">
      <thead>
        <tr>
          <th>S No.</th>
          <th>Name</th>
          <th>Firm Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(dealer, index) in dealers" :key="index">
          <td>{{ dealer.id }}</td>
          <td>{{ dealer.name }}</td>
          <td>{{ dealer.firm_name }}</td>
          <td>{{ dealer.phone }}</td>
          <td>{{ dealer.email }}</td>
          <td>{{ dealer.created_at }}</td>
          
          <td>
            <a :href="`/manage/trashes/dealer/delete/${dealer.id}`" class="mx-1">
              <button class="btn btn-danger">Delete</button>
            </a>
            <a :href="`/manage/trashes/dealer/restore/${dealer.id}`" class="mx-1">
              <button class="btn btn-primary">Restore</button>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div>
    <h1>Supplier Trash</h1>
    <table class="table">
      <thead>
        <tr>
          <th>S No.</th>
          <th>Name</th>
          <th>Firm Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(supplier, index) in suppliers" :key="index">
          <td>{{ supplier.id }}</td>
          <td>{{ supplier.name }}</td>
          <td>{{ supplier.firm_name }}</td>
          <td>{{ supplier.phone }}</td>
          <td>{{ supplier.email }}</td>
          <td>{{ supplier.created_at }}</td>
          
          <td>
            <a :href="`/manage/trashes/supplier/delete/${supplier.id}`" class="mx-1">
              <button class="btn btn-danger">Delete</button>
            </a>
            <a :href="`/manage/trashes/supplier/restore/${supplier.id}`" class="mx-1">
              <button class="btn btn-primary">Restore</button>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div>
    <h1>InwardEntry Trash</h1>
    <table class="table">
      <thead>
        <tr>
          <th>S No.</th>
          <th>Date</th>
          <th>Invoice Number</th>
          <th>Supplier</th>
          <th>Location</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(customer, index) in inwardEntry" :key="index">
          <td>{{ customer.id }}</td>
          <td>{{ customer.date }}</td>
          <td>{{ customer.invoice_number }}</td>
          <td>{{ customer.supplier }}</td>
          <td>{{ customer.location }}</td>
          <td>{{ customer.created_at }}</td>
          
          <td>
            <a :href="`/manage/trashes/inwardEntry/delete/${customer.id}`" class="mx-1">
              <button class="btn btn-danger">Delete</button>
            </a>
            <a :href="`/manage/trashes/inwardEntry/restore/${customer.id}`" class="mx-1">
              <button class="btn btn-primary">Restore</button>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div>
    <h1>OutwardEntry Trash</h1>
    <table class="table">
      <thead>
        <tr>
          <th>S No.</th>
          <th>Date</th>
          <th>Dealer Name</th>
          <th>Firm Name</th>
          <th>Phone</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(outwardEntry, index) in outwardEntrys" :key="index">
          <td>{{ outwardEntry.id }}</td>
          <td>{{ outwardEntry.date }}</td>
          <td>{{ outwardEntry.dealer_name }}</td>
          <td>{{ outwardEntry.firm_name }}</td>
          <td>{{ outwardEntry.phone }}</td>
          <td>{{ outwardEntry.created_at }}</td>
          <td>
            <a :href="`/manage/trashes/outwardEntry/delete/${outwardEntry.id}`" class="mx-1">
              <button class="btn btn-danger">Delete</button>
            </a>
            <a :href="`/manage/trashes/outwardEntry/restore/${outwardEntry.id}`" class="mx-1">
              <button class="btn btn-primary">Restore</button>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ['inwardEntry','dealers','inwardEntryItems','outwardEntrys','outwardEntryItems','products','suppliers']
};
</script>

<style>
/* Add your styles here */
</style>
