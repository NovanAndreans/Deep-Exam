<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('rps.store') }}" enctype="multipart/form-data" method="post" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah RPS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input name="title" type="text" class="form-control" id="title" placeholder="Masukkan Judul">
                        <label for="title">Judul</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="cpmk" placeholder="CPMK" id="cpmk"
                            style="height: 100px;"></textarea>
                        <label for="cpmk">Capaian Pembelajaran Mata Kuliah</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="desc" placeholder="Deskripsi" id="desc"
                            style="height: 150px;"></textarea>
                        <label for="desc">Deskripsi</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-bs-dismiss="modal">
                        <i class="fa fa-arrow-circle-left"></i> Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>