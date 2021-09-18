import $ from 'jquery';

function isValidHttpUrl(string) {
    let url;

    try {
        url = new URL(string);
    } catch (_) {
        return false;
    }

    return url.protocol === "http:" || url.protocol === "https:";
}

function reset_pokemon_picture() {
    document.getElementById('picture').setAttribute("src", window.default_picture);
}

function refresh_pokemon_picture(picture_url) {
    document.getElementById('picture').setAttribute("src", picture_url);
}

if(document.getElementById('picture_link') !== null) {
    document.getElementById('picture_link').addEventListener('change', (event) => {
        const picture_url = event.target.value;

        const onError = (error) => {
            document.getElementById("btn_send").disabled = true;
            $('#picture_link').addClass("is-invalid");
            reset_pokemon_picture();

            // if (error != null) {
            //     console.log(error);
            // }
        };

        if (picture_url !== "" && isValidHttpUrl(picture_url)) {
            let xhr = new XMLHttpRequest();

            const onSuccess = () => {
                document.getElementById("btn_send").disabled = false;
                $('#picture_link').removeClass("is-invalid");
                refresh_pokemon_picture(picture_url);
            }

            xhr.onerror = onError;

            xhr.onloadend = function () {
                try {
                    if (this.responseURL !== picture_url) {
                        throw new Error("Redirections not allowed");
                    }

                    if (this.status === 200) {
                        onSuccess();
                    } else {
                        throw new Error("Bas response code : " + this.status + ' - ' + this.statusText);
                    }
                } catch (error) {
                    onError(error);
                }
            }

            xhr.open("GET", picture_url, true);
            xhr.send();
        } else {
            onError("Invalid or empty picture url");
        }
    });
}
