<div class="card p-3">
  <div class="card-header" style="background-color: white">
    <div class="row align-items-center">
      <!-- Select Entries -->
      <div class="col-md-6 col-12 d-flex align-items-center">
        <h5 class="mb-0 me-2">Show</h5>
        <select id="entries" class="form-control form-control-sm w-auto">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <h5 class="mb-0 ms-2">entries</h5>
      </div>

      <!-- Search Form -->
      <div class="col-md-6 col-12">
        <form class="d-flex justify-content-end">
          <div class="input-group">
            <input id="datatable-search" type="text" class="form-control" placeholder="Search">
            <button id="basic-addon2" type="button" onclick="addForm('{{ route('types.store') }}')"
              class="input-group-text btn btn-success btn-sm btn-flat">
              <i class="fa fa-plus-circle"></i> Tambah
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Children</th>
          </tr>
        </thead>
        <tbody>
          <!-- Data rows here -->
        </tbody>
      </table>
    </div>
  </div>
</div>
