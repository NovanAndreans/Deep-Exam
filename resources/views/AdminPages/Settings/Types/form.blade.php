<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" enctype="multipart/form-data" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-4">
                        <select name="master_id" class="form-select" id="master_id" aria-label="Floating label select example">
                            <option value="">Select Parent</option>
                            @foreach ($parent as $pr)
                            <option value="{{$pr->id}}">{{$pr->name}}</option>
                            @endforeach
                        </select>
                        <label for="master_id">Parent</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="name" type="text" class="form-control" id="name" placeholder="Name">
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="file" id="picture" name="picture">
                        <label for="picture" class="form-label">Picture</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i>
                        Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-bs-dismiss="modal"><i
                            class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>