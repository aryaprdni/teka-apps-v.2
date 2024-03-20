<table id="example2" class="table table-bordered table-hover table-striped" style="width: 100%">
  <thead>
    <tr>
      <th style="width: 7%">No</th>
      <th style="width: 15%">Image</th>
      <th style="width: 20%">Name</th>
      <th>price</th>
      <!-- <th style="width: 15%">Status</th> -->
      <th style="width: 19%">Actions</th>
    </tr>
  </thead>
  <tbody>
    
        @foreach($avatars as $index => $avatar)
        <tr>
        <td>{{ $index + 1 }}</td>
        <td class="text-center">
            <img src="{{ $avatar->image }}" alt="avatar" height="100" width="100" >
        </td>
        <td>{{ $avatar->avatar_name }}</td>
        <td>{{ $avatar->price }}</td>

        <!-- button -->
        <td style="text-align: center">
            <form action="/avatar/delete/{{ $avatar->_id }}" method="POST" style="display: inline-block">
            <a href="/avatar/edit/{{ $avatar->_id }}" class="btn btn-warning">
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