$('body').on('change','.get-next-child',function(e){
    let table_id= $(this).attr('id');
    model= table_id.split("-");
    var id=$(this).val();
    var display_field=model[1];
    condition_field=$(this).attr('name');

    var url=$('#getNextChild').text();
    data= {'id': id, 'model': model[0], 'condition_field': condition_field, 'display_field': model[1]}
    if(id) {

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: data,
            url: url,
            dataType: 'json',
            success: function (data) {
                child_class = '.' + table_id;
                child_valie = '._' + table_id;

                $(child_class).find('option').remove();
                $(child_class).append(new Option("Select", ""));

                $.each(data, function (index, value) {
                    if(model[0]=='Staff')
                        $(child_class).append(new Option(value[display_field]+'-'+value['id'], value['id']));
                    else
                        $(child_class).append(new Option(value[display_field], value['id']));

                    $(child_class).val($(child_valie).val());
                    if ($(child_valie).val() == value['id']) {

                        $(child_class).trigger('change')
                    }
                });

            }, error: function (data) {

               // console.log(data)
            }
        });
    }
});
$('body').find('.get-next-child').trigger('change');

$('body').on('change','.getSections',function(e){
    var table_id= $(this).attr('id').split('-')[0];
    var i=$(this).attr('id').split('-')[1];
    var branch_id=$('#branch-'+i).val();
    var sem=$('#sem-'+i).val();
    let urlPath=$('#appPath').text();
    data= {'branch_id': branch_id,'sem':sem}
    if(branch_id!='' && sem!='') {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: data,
            url: urlPath+'/academic/getSectionOnBranchSem',
            dataType: 'json',
            success: function (data) {

                $('#section-'+i).find('option').remove();
                $('#section-'+i).append(new Option("Select", ""));

                $.each(data, function (index, value) {
                    $('#section-'+i).append(new Option(value['section'], value['id']));
                });

                if($('#hidden_section_id-'+i).val()){
                    $('#section-'+i).val($('#hidden_section_id-'+i).val());
                }

            }, error: function (data) {

                // console.log(data)
            }
        });
    }
});
$('body').find('.getSections').trigger('change');

$('body').on('change','.getBranch',function(e){
    var i=$(this).attr('id').split('-')[1];
    var course_id=$('#academic_course-'+i).val();
    var academic_year_id=$('#academic_year-'+i).val();
    let urlPath=$('#appPath').text();
    data= {'course_id': course_id,'academic_year_id':academic_year_id}
    if(course_id!='' && academic_year_id!='') {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: data,
            url: urlPath+'/academic/getBranchOnAcademicYear',
            dataType: 'json',
            success: function (data) {

                $('#academic_branch-'+i).find('option').remove();
                if(course_id==1)
                    $('#academic_branch-'+i).append(new Option("Select", ""));
                var display_field= ($('#academic_branch-'+i).attr('data-short-name') == 1 ) ? 'short_name' : 'branch';
                $.each(data, function (index, value) {
                    $('#academic_branch-'+i).append(new Option(value[display_field], value['id']));
                });

                if($('#hidden_academic_branch_id-'+i).val()){
                    $('#academic_branch-'+i).val($('#hidden_academic_branch_id-'+i).val());
                }

            }, error: function (data) {

                // console.log(data)
            }
        });
    }
});
$('body').find('.getBranch').trigger('change');
