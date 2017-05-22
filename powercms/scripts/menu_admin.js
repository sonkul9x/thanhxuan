$(function(){
    $('img.active-menu').each(function(){
        $(this).click(function(){
            $this = jQuery(this);
            $id = $this.attr('menu_id');
            $.ajax({
                url : '/menus/active',
                method : 'POST',
                data : {"menu_id" : $id},
                beforeSend: function() {

		},
                success : function(data){
                    if(data == 'active'){
                        $this.attr('src', '/powercms/images/ontime.png')
                    }else{
                        $this.attr('src', '/powercms/images/absent.png')
                    }
                }
            });
        });
    });
});