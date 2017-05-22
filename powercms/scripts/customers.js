//@dzung.tt : module customers
function add_new_item(template, container)
{
    $rad = Math.random() * 10000;
    $template = $('#' + template).html();
    $template = $template.replace(/xxxx/g, Math.floor($rad));
    $current = $('#' + container).append($template);
    bind_nav_input_keypress_event(container);
    $('#' + container + ' li:last-child').find('textarea').last().focus();
    $('#' + container + ' li:last-child').find('input').last().focus();
    return false;
}
function bind_nav_input_keypress_event( container ){
    $('#' + container + ' input').each(function(){
       $(this).keypress(function(event){
           if(event.keyCode == 40){
               $(this).parent('li').next('li').find('input').last().focus();
           }
           if(event.keyCode == 38){
               $(this).parent('li').prev('li').find('input').last().focus();
           }
           if(event.keyCode == 46){
               $(this).parent('li').prev('li').find('input').last().focus();
               parent_id = this.parentNode.id;
               delete_item(parent_id);
           }
       }); 
    });
    $('#' + container + ' textarea').each(function(){
       $(this).keypress(function(event){
           if(event.keyCode == 40){
               $(this).parent('li').next('li').find('textarea').last().focus();
           }
           if(event.keyCode == 38){
               $(this).parent('li').prev('li').find('textarea').last().focus();
           }
           if(event.keyCode == 46){
               $(this).parent('li').prev('li').find('textarea').last().focus();
               parent_id = this.parentNode.id;
               delete_item(parent_id);
           }
       }); 
    });
}

function delete_item($item_id)
{
    current = $('input[name=delete_items]').val();
    $id = $('#' + $item_id + '_id').val();
    $new = '';
    if( 
        typeof(current) != 'undefined' 
        && typeof($id) != 'undefined'
    )
        $new = current + $id + ',';
    $('input[name=delete_items]').val($new);
    $('#' + $item_id).remove();
    return false;
}
bind_nav_input_keypress_event('list_email');
bind_nav_input_keypress_event('list_website');
bind_nav_input_keypress_event('list_address');
bind_nav_input_keypress_event('list_phone');
bind_nav_input_keypress_event('list_im');