<h1>All Departments</h1>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Cost Center</th>
        </tr>
    </thead>
    <tbody>
        @foreach($departments as $department)
            <tr>
                <td>{{ $department->id }}</td>
                <td>{{ $department->name }}</td>
                <td>{{ $department->cost_center }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
