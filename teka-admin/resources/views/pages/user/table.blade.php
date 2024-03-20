<table id="example2" class="table table-bordered table-hover table-striped" style="width: 100%">
  <thead>
    <tr>
      <th style="width: 7%">No</th>
      <th>Name</th>
      <th>Email</th>
      <th>Avatar</th>
      <!-- <th>Purchased Avatar</th> -->
      <th>Diamond</th>
      <th style="width: 19%">Actions</th>
    </tr>
  </thead>
  <tbody>
    
        @foreach($users as $index => $user)
        <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td class="text-center">
          <img src="{{ $user->avatar }}" alt="user" height="100" width="100" >
        </td>
        <td>{{ $user->diamond }}</td>

        <!-- button -->
        <td style="text-align: center">
            <form action="/user/delete/{{ $user->_id }}" method="POST" style="display: inline-block">
            <a href="/user/edit/{{ $user->_id }}" class="btn btn-warning">
                <i class="fas fa-pencil-alt"></i>
                Edit
            </a>
            @csrf
            @method('DELETE')
            <button href="" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i>
                Delete
            </button>
            </form>
        </td>
        </tr>
        @endforeach
  </tbody>
</table>