/**
 * Created by aagafonov on 20.06.14.
 */

function edit(){
    block = $(".block");
    if (block.hasClass('editable')){
        tinymce.plugins.save_onsavecallback();
        block.removeClass('editable');
        tinymce.remove();
    } else {
        block.addClass('editable');
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
                "searchreplace visualblocks code fullscreen",
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
