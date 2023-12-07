<style>
    #exportTable th{
        color: #ffffff;
    }
</style>

<table  id="exportTable" class="table table-striped table-bordered w-100" >
    <thead class="text-nowrap ">
    <tr class="bg-info" >
        <th>#</th>
        <th>Name</th>
        <th>Login Time</th>

    </tr>
    </thead>
    <tbody >

    @foreach($stud_list as $list)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $list['user']['name']}}</td>
            <td ><?php echo date('d-m-Y h:i A',strtotime($list['login']))?></td>

        </tr>
    @endforeach
    @if(sizeof($stud_list)==0)
        <tr>
            <td colspan="3" class="text-center">No Data Found</td>
        </tr>
    @endif

    </tbody>

</table>

