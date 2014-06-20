/**
 * Created by aagafonov on 20.06.14.
 */

function edit(){
    block = $(".block");
    block.css("border", "1px solid red");
    block.addClass('edit');
    //block.onclick(block.css("border", "1px solid green"))

    tinymce.init({
        inline : true,
        language : 'ru',
        selector:'div.edit',
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
                    console.log('Result: ' + msg);
                }
            });
        },
        theme: "modern"
    });
}
