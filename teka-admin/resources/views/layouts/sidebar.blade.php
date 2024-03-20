  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center ">
      <span class="brand-text font-weight-bold" style="color: #48B8E9">teka</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{$user->image}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info ">
          <a href="/" class="d-block">{{$user->name}}</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/user" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/avatar" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Avatars
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/quiz" class="nav-link">
            <i class="nav-icon fa fa-question-circle"></i>
              <p>
                Quiz
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/diamond" class="nav-link">
            <i class="nav-icon fa fa-diamond-alt"></i>
              <p>
                Diamond
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/payment" class="nav-link">
              <i class="nav-icon fa fa-credit-card"></i>
              <p>
                Payment
              </p>
            </a>
          </li>
         
        </ul>
      </nav>
      
      <form action="/logout" method="POST" style="position: absolute; bottom: 10px; width: 93%;">
        @csrf
        <button  type="submit" class="btn btn-danger w-100">Log Out</button>
      </form>
      <!-- /.sidebar-menu -->
    </div>
    
    <!-- /.sidebar -->
  </aside>