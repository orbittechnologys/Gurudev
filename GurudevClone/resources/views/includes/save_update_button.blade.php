<div class="pull-right">
    @if($model['id']!='')
        {{ Form::submit('Update',['class'=>'btn btn-info wrap ml-10']) }}
    @else
        <input type="reset" class="btn btn-default wrap" value="Cancel" />
        {{ Form::submit('Save',['class'=>'btn btn-info wrap ml-10']) }}
    @endif
</div>
