
/*need to be fixed for multiple images and exchanging thumbnails to bigger imgs */
    // Get the modal
function openModal() {
  document.getElementById('myModal').style.display = "block";
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
}

$(document).mouseup(function(e) {
    var container = $(".modal");

    // if the target of the click isn't the container nor a descendant of the container
    if (container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide();;
    }
});