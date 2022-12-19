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
