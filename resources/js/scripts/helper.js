window.on = function (selector, event, handler) {
    let rootElement = document.querySelector("body");
    //since the root element is set to be body for our current dealings
    rootElement.addEventListener(
        event,
        function (evt) {
            var targetElement = evt.target;
            while (targetElement != null) {
                if (targetElement.matches(selector)) {
                    return handler(evt, targetElement);
                }
                targetElement = targetElement.parentElement;
            }
        },
        true
    );
}

window.log = function() {
    let datas = []
    for (let index = 0; index < arguments.length; index++) {
        let argument = arguments[index];
        if (typeof argument == "object") argument = JSON.parse(JSON.stringify(argument))
        datas.push(argument)
    }
    console.log(...datas);
}
