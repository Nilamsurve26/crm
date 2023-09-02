<table>
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Role Name</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Employee Code</th>
            <th>Address</th>
            <th>Date Of Birth</th>
            <th>Date Of Joining</th>
            <th>Imei No</th>
            <th>Phone</th>
           
        </tr>
    </thead>
    <tbody>
    
        @foreach ($users as $user)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $user->roles[0] ? $user->roles[0]->name  : '' }}</td>
            <!-- <td>{{ $user->roles[0]->name }}</td> -->
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->employee_code }}</td>
            <td>{{ $user->address }}</td>
            <td>{{ $user->dob }}</td>
            <td>{{ $user->doj }}</td>
            <td>{{ $user->imei_no }}</td>
         
            
        </tr>
        @endforeach
    </tbody>
</table>
