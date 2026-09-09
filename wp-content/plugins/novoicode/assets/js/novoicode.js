//Arquivo: wp-content/plugins/novoicode/assets/js/novoicode.js
jQuery(document).ready(function ($) {
    $("#adminmenu #toplevel_page_suporte ul li.wp-first-item a").html("Sobre");

    $('#tacessos').DataTable({
        order: [[3, 'desc']],
        dom: 'lBfrtip',
        buttons: [
            'excelHtml5',
        ],
        "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
        "iDisplayLength": 25,
        language: {
            emptyTable: "Não há dados disponíveis para a consulta",
            oPaginate: {
                sNext: "Próximo",
                sPrevious: "Anterior",
                sFirst: "Primeiro",
                sLast: "Último",
            },
            sSearch: "",
            sInfo: "",
            sShow: "",
            searchPlaceholder: 'Pesquisar'
        }
    });
});

function upload_image(val) {
    aw_uploader = wp.media({
        title: 'Upload File',
        library: {
            uploadedTo: wp.media.view.settings.post.id
        },
        button: {
            text: 'Use this File'
        },
        multiple: false
    }).on('select', function () {
        var attachment = aw_uploader.state().get('selection').first().toJSON();
        var url = attachment.url.split('/').splice(3, 6);
        url = url.join('/');
        jQuery('#portal_input_' + val).val("/" + url);
        jQuery('#preview_portal_input_' + val).attr('src', "/" + url);
    }).open();
}