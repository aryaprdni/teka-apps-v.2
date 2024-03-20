@include('layouts.header')
@include('layouts.Sidebar')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Quiz</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/quiz">Quiz</a></li>
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
                  <h3 class="card-title">Form tambah Quiz</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="/quiz/create" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="question">Masukan Pertanyaan</label>
                      <input type="text" name="question" class="form-control" id="question" placeholder="masukan nama pertanyaa" required />
                    </div>
                  </div>

                  <div class="card-body">
                    <div class="form-group">
                      <label for="answer">Masukan Jawaban</label>
                      <input type="text" name="answer" class="form-control" id="answer" placeholder="masukan jawaban" required />
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="option1">Masukan option 1</label>
                      <input type="text" name="option1" class="form-control" id="option1" placeholder="masukan option" required />
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="option2">Masukan option 2</label>
                      <input type="text" name="option2" class="form-control" id="option2" placeholder="masukan option" required />
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="option3">Masukan option 3</label>
                      <input type="text" name="option3" class="form-control" id="option3" placeholder="masukan jawaban" required />
                    </div>
                  </div>

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <button type="submit" class="btn btn-secondary">
                      <a href="/quiz" style="color: white"><i class="fa fa-undo"></i> Cancel</a>
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