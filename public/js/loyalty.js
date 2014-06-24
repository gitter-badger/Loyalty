/**
 * Created by aagafonov on 20.06.14.
 */

function edit(){
    // Contents block
    content = $(".content");

    // News block


    if (content.length >0){
        if (content.hasClass('editable')){
            content.removeClass('editable');
            tinymce.remove();
        } else {
            content.addClass('editable');
            tinymce.init({
                inline : true,
                fixed_toolbar_container: ".mce",
                language : 'ru',
                selector:'div.editable',
                toolbar:
                    " core |" +
                        " save |" +
                        " insertfile undo redo |" +
                        " styleselect |" +
                        " bold italic |" +
                        " alignleft aligncenter alignright alignjustify |" +
                        " bullist numlist |" +
                        " link image |" +
                        " forecolor backcolor |" +
                        " textcolor |" +
                        " code",
                plugins: [
                    "save","textcolor","advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualcontents code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                save_enablewhendirty: true,
                save_onsavecallback: function() {
                    $.ajax({
                        type: "POST",
                        url: "#",
                        data: {
                            position: $(".mce-edit-focus").attr("positionId"),
                            text: $(".mce-edit-focus").html(),
                            save: true
                        },
                        success:function( msg ) {
                            console.log('Save result: ' + msg);
                        }
                    });
                },
                theme: "modern"
            });
        }
    }
}