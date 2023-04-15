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

async function downloadContent(url) {
    try {
        let res = await fetch('download.php?url=' + url);
        let json = await res.json();
        return (json.succes) ? json.filename : false;
    } catch (error) {
        console.log(error);
        return false;
    }
}

function downloadURI(url) {
    downloadContent(url).then((filename) => {
        fetch(url)
            .then(response => response.blob())
            .then(blob => {
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = filename;
                link.click();
            })
            .catch(error => {
                console.error(error);
            });
    });
}

function variation(formData) {
    disableUi(true);

    postData("variation.php", formData).then((data) => {
        // console.log(data); // JSON data parsed by `data.json()` call
        data.output.forEach((val) => {
            let imgSrc = 'download/' + val;
            let thumbnail = createCard(imgSrc);
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
        data.output.forEach((val) => {
            // console.log(val);
            let imgSrc = 'download/' + val;
            let thumbnail = createCard(imgSrc);
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

function createCard(imgSrc) {

    const imgAlt = "Description de l'image";
    const img = $("<img>").attr("src", imgSrc)
        .attr("alt", imgAlt)
        .addClass('img-fluid')
        .css({
            'width': '98px',
            'height': '98px'
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
            downloadURI(imgSrc);
        });

    let aButton = $("<button>").attr("type", "button")
        .attr("title", "Variation")
        .addClass('btn btn-sm btn-block')
        .append('<i class="fas fa-sync-alt"></i>')
        .click(function () {
            const formData = new FormData();
            formData.append('image', imgSrc);
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