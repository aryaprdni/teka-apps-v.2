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
            <li class="breadcrumb-item"><a href="/avatar">Avatar</a></li>
            <li class="breadcrumb-item active">Create</li>
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
                  <h3 class="card-title">Form tambah avatar</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="/avatar/create" method="POST" enctype="multipart/form-data">
                @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="avatar_name">Masukan nama avatar</label>
                      <input type="text" name="avatar_name" class="form-control" id="avatar_name" placeholder="masukan nama avatar" required />
                    </div>
                  </div>

                  <div class="card-body">
                    <div class="form-group">
                      <label for="image">Masukan image</label>
                      <input type="file" name="image" class="form-control" id="image" placeholder="masukan nama image" required />
                    </div>
                  </div>

                  <div class="card-body">
                    <div class="form-group">
                      <label for="price">Masukan harga</label>
                      <input type="number" name="price" class="form-control" id="price" placeholder="masukan nama harga" required />
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