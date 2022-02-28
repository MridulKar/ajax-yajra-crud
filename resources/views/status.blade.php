@if($group->status == 1)
    $status = '<span style="background-color: #97df1a; border-radius: 3px; padding: 3px;">Active</span>';
@else
    $status = '<span style="background-color: #fe7472; border-radius: 3px; padding: 3px;">Inactive</span>';
@endif