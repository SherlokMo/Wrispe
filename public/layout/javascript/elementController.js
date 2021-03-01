function addClass(elements,classes = ["hidden"]) {
    elements.forEach(element => {
        classes.forEach(classname => {
            if(!element.classList.contains(classname)){
                element.classList.add(classname);
            }
        });
    });
}
function removeClass(elements,classes = ["hidden"]) {
    elements.forEach(element => {
        classes.forEach(classname => {
            if(element.classList.contains(classname)){
                element.classList.remove(classname);
            }
        });
    });
}

function changeText(element,newText){
    element.innerHTML = newText;
}
