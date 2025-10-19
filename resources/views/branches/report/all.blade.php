<h1>All Branches</h1>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @foreach($branches as $branch)
            <tr>
                <td>{{ $branch->id }}</td>
                <td>{{ $branch->name }}</td>
                <td>{{ $branch->phone }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
