<tbody>
@foreach($brands as $brand)
<tr data-id="{{ $brand->id }}">
    <td>{{ $brand->name }}</td>
    <td>{{ $brand->status == 1 ? 'Active' : 'Inactive' }}</td>
    <td>
        <button class="btn btn-sm btn-warning me-2" onclick="editBrand({{ $brand->id }}, this)">Edit</button>
        <button class="btn btn-sm btn-danger" onclick="deleteBrand({{ $brand->id }}, this)">Delete</button>
    </td>
</tr>
@endforeach
</tbody>
