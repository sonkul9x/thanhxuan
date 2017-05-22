$(function()
    {
        reload_selected();
        $('#add_role').click(function(){
            get_selected_role('#list_role', '#selected_role');
        });
        $('#remove_role').click(function(){
            get_selected_role('#selected_role', '#list_role');
        });
        
        $('#language').change(function(){
            $.ajax({
                type:   'post',
                url:    '/menus/menus_admin/get_combo_menu',
                data:   {
                    "is-ajax"   :   1,
                    "lang"      :   $(this).val(),
                    "parent"    :   $('input[name=parent]').val(),
                    "current_id":   $('input[name="menu_id"]').val()
                },
                success: function(responseText) {
                    $('select[name=navigation]').replaceWith(responseText);
                }
            });
        });
    });
    
function get_selected_role(id_select, id_move_to)
{
    var items = $(id_select + ' option:selected');
        
    if(items != null && items.length > 0){
        items.appendTo(id_move_to);
        $(id_move_to + ' option').attr('selected', 'selected');
    }
    reload_selected();
}
    
function reload_selected(){
    $('#selected_role option').each(function(){
        $(this).attr('selected', 'selected');
    });
    $('#list_role option').each(function(){
        $(this).removeAttr('selected');
    });
}
