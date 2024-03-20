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
                  <h3 class="card-title">Form edit quiz "{{$quiz->question}}"</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="/quiz/edit/{{ $quiz->id }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="card-body">
                    <div class="form-group">
                      <label for="question">Masukan pertanyaan</label>
                      <input type="text" value="{{$quiz->question}}" name="question" class="form-control" id="question" placeholder="masukan pertanyaan" required />
                    </div>
                  </div>
                  <div class="card-body">
                    <label for="answer">Masukan Jawaban</label>
                    <div class="form-group">
                      <input type="text" value="{{$quiz->answer}}" name="answer" class="form-control" id="answer" placeholder="masukan pertanyaan" />
                    </div>
                  </div>
                  <div class="card-body">
                    <label for="option1">Option 1</label>
                    <div class="form-group">
                      <input type="text" value="{{$quiz->option1}}" name="option1" class="form-control" id="option1" placeholder="masukan pertanyaan" />
                    </div>
                  </div>
                  <div class="card-body">
                    <label for="option2">Option 2</label>
                    <div class="form-group">
                      <input type="text" value="{{$quiz->option2}}" name="option2" class="form-control" id="option2" placeholder="masukan pertanyaan" />
                    </div>
                  </div>
                  <div class="card-body">
                    <label for="option3">Option 3</label>
                    <div class="form-group">
                      <input type="text" value="{{$quiz->option3}}" name="option3" class="form-control" id="option3" placeholder="masukan pertanyaan" />
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