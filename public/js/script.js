/**
 * Copyright (c) 2023-present Florent Brusciano <easygithdev@gmail.com>
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

const downloadDir = '../download';

const getUrl = resource => {
    let url = new URL(window.location.href)
    return url.protocol + "//" + url.host + "/" + url.pathname + resource;
}

async function postData(url, formData) {
    // Default options are marked with *
    const response = await fetch(url, {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, *cors, same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
            // "Content-Type": "application/json",
            // 'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
        },
        redirect: "follow", // manual, *follow, error
        referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: formData, // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
}

function downloadImage(url) {
    // Créer une balise <a> pour télécharger l'image
    var link = document.createElement("a");
    link.href = url;
    link.download = url.split("=").pop();

    // Ajouter la balise <a> au DOM
    document.body.appendChild(link);

    // Simuler un clic sur la balise <a> pour lancer le téléchargement
    link.click();

    // Retirer la balise <a> du DOM une fois le téléchargement terminé
    document.body.removeChild(link);
}

function variation(formData) {
    disableUi(true);

    postData(getUrl("variation.php"), formData).then(data => {
        // console.log(data); // JSON data parsed by `data.json()` call
        if (!data.success) {
            alert(data.error);
            return;
        }

        data.output.forEach(val => {
            let thumbnail = createCard(val);
            $("#outputBox").append(thumbnail);
        });
    }).catch(error => {
        console.error(error);
    }).finally(() => {
        disableUi(false);
    });;
}

function imagine(formData) {
    disableUi(true);

    postData(getUrl("imagine.php"), formData).then(data => {
        // console.log(data); // JSON data parsed by `data.json()` call
        if (!data.success) {
            alert(data.error);
            return;
        }

        data.output.forEach(val => {
            // console.log(val);
            let thumbnail = createCard(val);
            $("#outputBox").append(thumbnail);
        });
    }).catch(error => {
        console.error(error);
    }).finally(() => {
        disableUi(false);
    });
}

function delImage(formData) {
    disableUi(true);

    postData(getUrl("delete.php"), formData).then(data => {
        // console.log(data); // JSON data parsed by `data.json()` call
        if (!data.success) {
            alert(data.error);
            return;
        }
        $("#" + data.output.image).parent().parent().remove();
    }).catch(error => {
        console.error(error);
    }).finally(() => {
        disableUi(false);
    });
}

function showImage(filename) {
    disableUi(true);

    postData(getUrl("show.php?filename=" + filename)).then(data => {
        // console.log(data); // JSON data parsed by `data.json()` call
        if (!data.success) {
            alert(data.error);
            return;
        }
        $("#" + data.output.image).parent().parent().remove();
    }).catch(error => {
        console.error(error);
    }).finally(() => {
        disableUi(false);
    });
}

function display() {
    disableUi(true);
    console.log(getUrl("display.php"))
    postData(getUrl("display.php")).then(data => {
        // console.log(data); // JSON data parsed by `data.json()` call
        if (!data.success) {
            alert(data.error);
            return;
        }

        data.output.forEach(val => {
            // console.log(val);
            let thumbnail = createCard(val);
            $("#outputBox").append(thumbnail);
        });
    }).catch(error => {
        console.error(error);
    }).finally(() => {
        disableUi(false);
    });
}

function disableUi(val) {
    $('button').prop('disabled', val);
    if (val)
        $("#run").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    else
        $("#run").html('Run');
}

function displayCard(imgObj) {
    $("#exampleModal").find("img").attr("src", getUrl("show.php") + "?filename=" + imgObj.filename);
    $("#exampleModalLabel").html("&#x22;" + imgObj.prompt + "&#x22; by " + imgObj.painter);
    $("#exampleModal").modal();
}

function inputUpdated(imgObj) {
    $("#inumber").val(imgObj.inumber);
    $("#isize").val(imgObj.isize);
    $("#painter").val(imgObj.painter);
    $("#prompt").val(imgObj.prompt);
}

function imageActivated(img) {
    $(".active").each(function () {
        $(this).removeClass("active");
    });
    img.addClass('active')
}

function createCard(imgObj) {

    const imgSrc = imgObj.filename;
    const imgAlt = imgObj.filename;
    const imgTitle = imgObj.prompt + ' by ' + imgObj.painter;
    const imgId = imgObj.filename.replace(".png", "");

    let img = $("<img>")
        .attr("id", imgId)
        .attr("src", getUrl("show.php") + "?filename=" + imgSrc)
        .attr("alt", imgAlt)
        .attr("title", imgTitle)
        .data("info", imgObj)
        .addClass('img-fluid')
        .addClass('cursor-pointer')
        .css({
            'width': '98px',
            'height': '98px'
        })
        .click(function (e) {
            imageActivated($(e.target));
            inputUpdated(imgObj);
            displayCard(imgObj);
        });

    let card = $("<div>").addClass("border text-center float-left")
        .css({
            'width': '160px',
            'height': '160px'
        });

    let cardImg = $("<div>").addClass("p-2 mb-2")
        .css({
            'height': '110px'
        });

    // download button
    let donwloadButton = $("<button>").attr("type", "button")
        .attr("title", "Donwload")
        .addClass('btn btn-sm')
        .append('<i class="fa-solid fa-download fa-fw""></i>')
        .click(function () {
            inputUpdated(imgObj);
            downloadImage(getUrl("show.php") + "?filename=" + imgObj.filename);
        });

    // variation button
    let variationButton = $("<button>").attr("type", "button")
        .attr("title", "Variation")
        .addClass('btn btn-sm')
        .append('<i class="fa-solid fa-rotate-right fa-fw""></i>')
        .click(function () {
            inputUpdated(imgObj);
            const formData = new FormData();
            for (const property in imgObj) {
                formData.append(property, imgObj[property]);
            }
            variation(formData);
        });

    // show button
    let showButton = $("<button>").attr("type", "button")
        .attr("title", "Show")
        .addClass('btn btn-sm')
        .append('<i class="fa-solid fa-eye fa-fw""></i>')
        .click(function () {
            inputUpdated(imgObj);
            displayCard(imgObj);
        });

    let deleteButton = $("<button>").attr("type", "button")
        .attr("title", "Delete")
        .addClass('btn btn-sm')
        .append('<i class="fa-solid fa-trash-can fa-fw""></i>')
        .click(function () {

            const action = () => {
                const formData = new FormData();
                for (const property in imgObj) {
                    formData.append(property, imgObj[property]);
                }
                delImage(formData);
            };
            $('#confirmationModal .modal-footer .btn-primary').data('action', action); // stocker l'action à effectuer dans le bouton "Oui"
            $('#confirmationModal').modal('show'); // afficher la pop-up de confirmation

        });

    let buttons = $("<div>").addClass('btn-group')
        .attr("role", "group")
        .append(deleteButton)
        .append(donwloadButton)
        .append(variationButton);
    // .append(showButton);

    img.appendTo(cardImg);
    cardImg.appendTo(card);
    buttons.appendTo(card);

    return card;
}