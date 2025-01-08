window.addEventListener('toastify-js', event => {
    $("#" + event.detail[0].id + "-title").text(event.detail[0].title);
    $("#" + event.detail[0].id + "-message").text(event.detail[0].message);

    Toastify({
        node: $("#" + event.detail[0].id).clone().removeClass("hidden")[0],
        duration: 5000,
        newWindow: true,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
    }).showToast();
})
