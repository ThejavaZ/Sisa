<h1>All Brands</h1>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Website</th>
        </tr>
    </thead>
    <tbody>
        @foreach($brands as $brand)
            <tr>
                <td>{{ $brand->id }}</td>
                <td>{{ $brand->name }}</td>
                <td>{{ $brand->website }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
