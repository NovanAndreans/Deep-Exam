<div class="card p-3">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0"></h4>
    <div class="card-header-form">
      <form>
        <div class="input-group mb-3">
          <input id="datatable-search" type="text" class="form-control" placeholder="Search">
          <button id="basic-addon2" type="button" onclick="addForm('{{ route('users.store') }}')"
              class="input-group-text btn btn-success btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
        </div>
      </form>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Data rows here -->
        </tbody>
      </table>
    </div>
  </div>
</div>