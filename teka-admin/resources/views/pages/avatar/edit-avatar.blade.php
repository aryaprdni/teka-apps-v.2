@include('layouts.header')
@include('layouts.Sidebar')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Avatar</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/avatar">avatar</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Form edit avatar "{{$avatar->avatar_name}}"</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="/avatar/edit/{{ $avatar->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name">Masukan nama avatar</label>
                      <input type="text" value="{{$avatar->avatar_name}}" name="avatar_name" class="form-control" id="avatar_name" placeholder="masukan nama avatar" required />
                    </div>
                  </div>
                  <div class="card-body">
                      <label for="name">Masukan Image</label>
                    <div class="form-group">
                      <img
                        src="{{$avatar->image}}"
                        class="img-fluid rounded-top py-3"
                        style="height: 20%; width: 20%;"
                        alt=""
                      />
                      <!-- <img id="perview" src="{{$avatar->image}}" style="height: 20%; width: 20%;"> -->
                      
                      <input type="file" value="{{$avatar->image}}" name="image" class="form-control" id="image" placeholder="masukan image avatar" />
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name">Masukan Harga</label>
                      <input type="number" value="{{$avatar->price}}" name="price" class="form-control" id="price" placeholder="masukan harga avatar" />
                    </div>
                  </div>

                  <div class="card-footer">
               
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <button type="submit" class="btn btn-secondary">
                      <a href="/avatar" style="color: white"><i class="fa fa-undo"></i> Cancel</a>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- /.card -->
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>


@include('layouts.footer')