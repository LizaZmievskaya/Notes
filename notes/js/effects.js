$(document).ready(function() {
	$('#add').click(function() {
        $('#notes').animate({left: "-100%"});
        $('#main').css("visibility","visible");
        $('#content').css("visibility","hidden");
	});
    
    $('#cancel').click(function() {
        $('#notes').animate({left: "0px"});
        $('#main').css("visibility","hidden");
	});
    
    $('#ready').click(function() {
        $('#notes').animate({left: "0px"});
        $('#main').animate({left: "100px"});
	});

    $('#name').focus(function(){
        $('#new').css("display","none");
    });

    $('#name').focusout(function(){
        var name_val = $('#name').val();
        if (name_val==''){
            $('#new').css("display","block");
        }
    });

    var notes = document.getElementsByClassName('col-md-4');
    if(notes.length==0){
        $('#text').css("display","block");
    }
    $("#add").click(function(){
        $('#new').css("display","block");
        $('input[name="name"]').val('');
        $('textarea[name="content"]').val('');
    });

    var parent = document.getElementsByClassName('notes');
    $('input[name="save"]').on('click',function (){
        var name = $('input[name="name"]').val();
        var content = $('textarea[name="content"]').val();
        var file = $('input[name="attach"]');
        $.ajax({
            url:'save.php',
            method:'POST',
            //data:'name='+name+'&'+'content='+content+'&attach='+new FormData(file),
            data:new FormData($(this).parent().parent()),
            type: 'Json',
            success: function(data){
                data = jQuery.parseJSON(data);
                var div = document.createElement('div');
                var name = document.createElement('div');
                var content = document.createElement('div');
                div = parent.appendChild(div);
                name.innerHTML = data.name;
                content.innerHTML = data.content;
                div.appendChild(name);
                div.appendChild(content);
                div.setAttribute('data-id',data.id_note);
                $(div).addClass('col-md-4');
                //$('#text').css("display","none");
                $("#myModal").modal("hide");
            }
        });
    });

    $('input[name="delete"]').on('click',function (){
        var check = $('.notes').find('input:checked').length;
        if(check>1){
            var arr = [];
            $('.notes').find('input:checked').each(function(){
                arr.push($(this).parent().data('id'));
            });
            console.log(arr);
        } else {
            var act = $('.notes').find('input:checked').parent();
            var arr = act.data('id');
        }
        $.ajax({
            url:'delete.php',
            method:'POST',
            data: {id_note:arr},
            type: 'Json',
            success: function(data){
                data = jQuery.parseJSON(data);
                if(data.status=='success'){
                    $('.notes').find('input:checked').parent().remove();
                    if(notes.length==0){
                        $('#text').css("display","block");
                    }
                }
            }
        });
    });


    $('#edit').on('click',function(){
        var name = $('.notes').find('input:checked').parent().find('div:first').text();
        var content = $('.notes').find('input:checked').parent().find('div.content').text();
        var id = $('.notes').find('input:checked').parent().data('id');
        $('#editModal').attr('data-id',id);
        $('#new').css("display","none");
        $('input[name="name"]').val(name);
        $('textarea[name="content"]').val(content);
    });


    $('button[name="save_edit"]').on('click',function (){
        var name = $('#editModal input[name="name"]').val();
        var content = $('#editModal textarea[name="content"]').val();
        var id = $('#editModal').data('id');
        $.ajax({
            url:'edit.php',
            method:'POST',
            data:'name='+name+'&'+'content='+content+'&'+'id_note='+id,
            type:'Json',
            success:function(data){
                console.log(data);
                data = jQuery.parseJSON(data);
                if(data.status=='success'){
                    $("#editModal").modal("hide");
                    $('.notes').find('input:checked').parent().find('div:first').text(name);
                    $('.notes').find('input:checked').parent().find('div.content').text(content);
                }
            }
        });
        return false;
    });


    $('input[name=accept]').on('click',function(){
        var color = $('input[type=color]').val();
        var id = $('.notes').find('input:checked').parent().data('id');
        $.ajax({
            url:'color.php',
            method:'POST',
            data:'color=' + color + '&' + 'id_note=' + id,
            type:'Json',
            success:function(data){
                data = jQuery.parseJSON(data);
                if(data.status=='success'){
                    $('.notes').find('input:checked').parent().css('background-color',color);
                }
            }
        });
    });

    $('a[name=exit]').on('click',function(){
        window.location.replace("http://localhost:81/notes/index.php");
    });

});



