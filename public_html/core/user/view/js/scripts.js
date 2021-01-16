$(document).ready(
    function () {

        showModal()


    })

function showModal(){

    if (window.location.href.indexOf('#enterError') !== -1) {
        $('#enter').modal('show')

    }
    else if (window.location.href.indexOf('#systemMessage') !== -1) {
        $('#systemMessage').modal('show')

    }

}