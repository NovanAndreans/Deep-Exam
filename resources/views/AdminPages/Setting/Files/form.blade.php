<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" enctype="multipart/form-data" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <left>
                        <h4 class="modal-title"></h4>
                    </left>
                    <right><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button></right>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-4">
                        <select name="role_id" class="form-select" id="role" aria-label="Floating label select example">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        <label for="role">Role</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="name" type="text" class="form-control" id="name" placeholder="Name">
                        <label for="name">Fullname</label>
                    </div>
                    <div class="form-floating mb-4">
                        <select name="gender_id" class="form-select" id="gender" aria-label="Floating label select example">
                            <option value="">Select Gender</option>
                            @foreach ($genders as $gender)
                            <option value="{{$gender->id}}">{{$gender->name}}</option>
                            @endforeach
                        </select>
                        <label for="gender">Pilih Gender</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating mb-4 position-relative">
                        <input name="password" type="password" minlength="8" class="form-control" id="password"
                            placeholder="Password">
                        <label for="password">Password</label>
                        <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password"
                            data-target="#password"></i>
                    </div>
                    <div class="form-floating mb-4 position-relative">
                        <input name="password_confirmation" type="password" minlength="8" class="form-control"
                            id="password_confirmation" placeholder="Password Confirmation">
                        <label for="password_confirmation">Password Confirmation</label>
                        <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password"
                            data-target="#password_confirmation"></i>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="file" id="photo" name="photo">
                        <label for="photo" class="form-label">Photo Profile</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i>
                        Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i
                            class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>