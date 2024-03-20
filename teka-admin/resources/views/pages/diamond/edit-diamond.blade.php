@include('layouts.header')
@include('layouts.Sidebar')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Diamond</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/diamond">Diamond</a></li>
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
                  <h3 class="card-title">Form edit diamond "{{$diamond->quantity}}"</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="/diamond/edit/{{ $diamond->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                  <div class="card-body">
                    <div class="form-group">
                      <label for="quantity">Masukan Jumlah Diamond</label>
                      <input type="text" value="{{$diamond->quantity}}" name="quantity" class="form-control" id="quantity" placeholder="masukan jumlah diamond" required />
                    </div>
                  </div>
                  <div class="card-body">
                      <label for="name">Masukan Image</label>
                    <div class="form-group">
                      <img
                        src="{{$diamond->image}}"
                        class="img-fluid rounded-top py-3"
                        style="height: 20%; width: 20%;"
                        alt=""
                      />
                      <!-- <img id="perview" src="{{$diamond->image}}" style="height: 20%; width: 20%;"> -->
                      
                      <input type="file" value="{{$diamond->image}}" name="image" class="form-control" id="image" placeholder="masukan image diamond" />
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name">Masukan Harga</label>
                      <input type="number" value="{{$diamond->price}}" name="price" class="form-control" id="price" placeholder="masukan harga diamond" />
                    </div>
                  </div>

                  <div class="card-footer">
               
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <button type="submit" class="btn btn-secondary">
                      <a href="/diamond" style="color: white"><i class="fa fa-undo"></i> Cancel</a>
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