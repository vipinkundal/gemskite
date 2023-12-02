<template>
  <nav
    id="sidebar"
    class="sidebar js-sidebar"
  >
    <div class="sidebar-content js-simplebar">
      <Link
        class="sidebar-brand"
        href="/"
      >
        <span class="align-middle">Gemskite</span>
      </Link>

      <ul class="sidebar-nav">
        <li class="sidebar-header">
          Add
        </li>

        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/master/add-user"
          >
            <i
              class="align-middle"
              data-feather="user-plus"
            /> <span class="align-middle">Add User</span>
          </Link>
        </li>

        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/master/add-dealer"
          >
            <i
              class="align-middle"
              data-feather="user-plus"
            /> <span class="align-middle">Add Dealer</span>
          </Link>
        </li>

        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/master/add-supplier"
          >
            <i
              class="align-middle"
              data-feather="users"
            /> <span class="align-middle">Add Supplier</span>
          </Link>
        </li>
        <!-- <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/master/add-supplier"
          >
            <i
              class="align-middle"
              data-feather="shopping-cart"
            /> <span class="align-middle">Add Sales</span>
          </Link>
        </li> -->
        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/master/add-product"
          >
            <i
              class="align-middle"
              data-feather="shopping-cart"
            /> <span class="align-middle">Add Product</span>
          </Link>
        </li>

        <li class="sidebar-header">
          Manage
        </li>

        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/master/manage-product"
          >
            <i
              class="align-middle"
              data-feather="package"
            /> <span class="align-middle">Manage Product</span>
          </Link>
        </li>

        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/master/manage-dealer"
          >
            <i
              class="align-middle"
              data-feather="package"
            /> <span class="align-middle">Manage Dealer</span>
          </Link>
        </li>

        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/master/manage-supplier"
          >
            <i
              class="align-middle"
              data-feather="package"
            /> <span class="align-middle">Manage Supplier</span>
          </Link>
        </li>

        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/sales/index"
          >
            <i
              class="align-middle"
              data-feather="package"
            /> <span class="align-middle">Manage Sales</span>
          </Link>
        </li>

        <li class="sidebar-header">
          Option
        </li>

        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/ledger/index"
          >
            <i
              class="align-middle"
              data-feather="book-open"
            /> <span class="align-middle">Ledger</span>
          </Link>
        </li>
        <!-- <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/invoice/index"
          >
            <i
              class="align-middle"
              data-feather="columns"
            /> <span class="align-middle">Invoice</span>
          </Link>
        </li> -->
        <!-- <li class="sidebar-item">
                <Link class="sidebar-link" href="/master/create-user">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Create User</span>
                </Link>
            </li>

            <li class="sidebar-item">
                <Link class="sidebar-link" href="/master/manage-units">
                    <i class="align-middle" data-feather="wind"></i> <span class="align-middle">Manage Units</span>
                </Link>
            </li> -->

        <li class="sidebar-header">
          Inventory
        </li>
        <!-- active -->
        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/inventory/inward-entry"
          >
            <i
              class="align-middle"
              data-feather="log-in"
            /> <span class="align-middle">Inward Entry</span>
          </Link>
        </li>
        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/inventory/manage-inward-entry"
          >
            <i
              class="align-middle"
              data-feather="package"
            /> <span class="align-middle">Manage Inward Entry</span>
          </Link>
        </li>

        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/inventory/outward-entry"
          >
            <i
              class="align-middle"
              data-feather="log-out"
            /> <span class="align-middle">Outward Entry</span>
          </Link>
        </li>
        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/inventory/manage-outward-entry"
          >
            <i
              class="align-middle"
              data-feather="package"
            /> <span class="align-middle">Manage Outward Entry</span>
          </Link>
        </li>



        <li class="sidebar-header">
          Reports
        </li>

        <!-- <li class="sidebar-item">
                <Link class="sidebar-link" href="/report/inward">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Inward Entry</span>
                </Link>
            </li>
              <li class="sidebar-item">
                <Link class="sidebar-link" href="/report/outward">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Outward Entry</span>
                </Link>
            </li> -->
        <!-- <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/report/stock"
          >
            <i
              class="align-middle"
              data-feather="file-text"
            /> <span class="align-middle">Stock in hand (PDF)</span>
          </Link>
        </li> -->
        <li class="sidebar-item">
          <Link
            class="sidebar-link"
            href="/report/ledger"
          >
            <i
              class="align-middle"
              data-feather="file-text"
            /> <span class="align-middle">Ledger (PDF)</span>
          </Link>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
export default {
	methods: {
		handleActive(url) {
			console.log(url);
		}
	}
};
</script>
