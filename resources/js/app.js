import 'bootstrap';
import './image-mgr';
import { Autocomplete } from "./autocomplete";

if (document.getElementById("search-user-input") != null) {
    const user_autocomplete = new Autocomplete(document.getElementById("search-user-input"), {
        data: window.user_autocomplete,
        maximumItems: 10,
        treshold: 1,
    });
}

export function scrollToDiv(divName) {
    const myEl = document.getElementById(divName);

    if (myEl != null) {
        const top = myEl.getBoundingClientRect().top + document.documentElement.scrollTop;

        window.scrollTo({
            top: top,
            behavior: "smooth",
        })
    }
}

window.scrollToDiv = scrollToDiv;
