<a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" data-original-title="Edit"
    class="edit btn btn-success edit">
    Edit
</a>
<a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" data-original-title="Delete"
    data-id="{{ $id }}" class="delete btn btn-danger">
    Delete
</a>

{{-- @if($group->status == 1)
   <a href="group/status/'.$group->id.'" class="btn" title="Click to Deactive class" style="padding: 2px;"> 
                    <i class="fa fa-fw ti-arrow-down text-danger actions_icon"></i>
                </a> 
@else
    <a href="group/status/'.$group->id.'" class="btn" title="Click to Deactive class" style="padding: 2px;"> 
                    <i class="fa fa-fw ti-arrow-up text-success actions_icon"></i>
                </a>
@endif --}}
