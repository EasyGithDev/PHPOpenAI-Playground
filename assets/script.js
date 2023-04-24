/**
 * Copyright (c) 2023-present Florent Brusciano <easygithdev@gmail.com>
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

const downloadDir = '../download';

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

function downloadImg(url) {
    // Créer une balise <a> pour télécharger l'image
    var link = document.createElement("a");
    link.href = url;
    link.download = url.split("/").pop();

    // Ajouter la balise <a> au DOM
    document.body.appendChild(link);

    // Simuler un clic sur la balise <a> pour lancer le téléchargement
    link.click();

    // Retirer la balise <a> du DOM une fois le téléchargement terminé
    document.body.removeChild(link);
}

function variation(formData) {
    disableUi(true);

    postData("variation.php", formData).then((data) => {
        // console.log(data); // JSON data parsed by `data.json()` call
        if (!data.success) {
            alert(data.error);
            return;
        }

        data.output.forEach((val) => {
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

    postData("imagine.php", formData).then((data) => {
        // console.log(data); // JSON data parsed by `data.json()` call
        if (!data.success) {
            alert(data.error);
            return;
        }

        data.output.forEach((val) => {
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

function display() {
    disableUi(true);

    postData("display.php").then((data) => {
        // console.log(data); // JSON data parsed by `data.json()` call
        if (!data.success) {
            alert(data.error);
            return;
        }

        data.output.forEach((val) => {
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

function displayCard(url) {
    $("#exampleModal").find("img").attr("src", url);
    $("#exampleModal").modal();
}

function createCard(imgObj) {

    const imgSrc = downloadDir + '/' + imgObj.filename;
    const imgAlt = imgSrc.split("/").pop();
    const imgTitle = imgObj.prompt;

    let img = $("<img>").attr("src", imgSrc)
        .attr("alt", imgAlt)
        .attr("title", imgTitle)
        .data("info", imgObj)
        .addClass('img-fluid')
        .css({
            'width': '98px',
            'height': '98px'
        })
        .click(function () {
            displayCard(imgSrc);
        });

    let card = $("<div>").addClass("border text-center float-left")
        .css({
            'width': '150px',
            'height': '150px'
        });

    let cardImg = $("<div>").addClass("p-2 mb-2")
        .css({
            'height': '100px'
        });

    let buttons = $("<div>").addClass('d-flex');

    let dButton = $("<button>").attr("type", "button")
        .attr("title", "Donwload")
        .addClass('btn btn-sm btn-block')
        .append('<i class="fas fa-download"></i>')
        .click(function () {
            downloadImg(imgSrc);
        });

    let aButton = $("<button>").attr("type", "button")
        .attr("title", "Variation")
        .addClass('btn btn-sm btn-block')
        .append('<i class="fas fa-sync-alt"></i>')
        .click(function () {
            const formData = new FormData();
            for (const property in imgObj) {
                // console.log(`${property}: ${object[property]}`);
                formData.append(property, imgObj[property]); 
            }
              
            variation(formData);
        });

    let sButton = $("<button>").attr("type", "button")
        .attr("title", "Show")
        .addClass('btn btn-sm btn-block')
        .append('<i class="fas fa-eye"></i>')
        .click(function () {
            displayCard(imgSrc);
        });

    buttons.append(dButton).append(aButton).append(sButton);

    img.appendTo(cardImg);
    cardImg.appendTo(card);
    buttons.appendTo(card);

    return card;
}