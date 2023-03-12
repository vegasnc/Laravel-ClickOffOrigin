const confirmModal = (title, content, callback) => {
    $("#modal_confirm .modal-title").text(title);
    $("#modal_confirm .modal-body").text(content);
    
    setTimeout(() => {
        $("#modal_confirm #ok").on("click", callback);
    }, 100);

    $("#modal_confirm").modal();
}
