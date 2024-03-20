<table id="example2" class="table table-bordered table-hover table-striped" style="width: 100%">
  <thead>
    <tr>
      <th style="width: 7%">No</th>
      <th style="width: 15%">Quantity</th>
      <th>Image</th>
      <th style="width: 20%">Price</th>
      <!-- <th style="width: 15%">Status</th> -->
      <th style="width: 19%">Actions</th>
    </tr>
  </thead>
  <tbody>
    
        @foreach($diamonds as $index => $diamond)
        <tr>
        <td>{{ $index + 1 }}</td>
        <td class="text-center">
            <img src="{{ $diamond->image }}" alt="diamond" height="100" width="100" >
        </td>
        <td>{{ $diamond->quantity }}</td>
        <td>{{ $diamond->image }}</td>
        <td>{{ $diamond->price }}</td>

        <!-- button -->
        <td style="text-align: center">
            <form action="/diamond/delete/{{ $diamond->_id }}" method="POST" style="display: inline-block">
            <a href="/diamond/edit/{{ $diamond->_id }}" class="btn btn-warning">
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