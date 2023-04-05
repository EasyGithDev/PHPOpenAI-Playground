<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>DALL·E 2 Playground</title>
    <!-- Ajout des fichiers CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Ajout des fichiers CSS personnalisés -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">DALL·E 2 Playground</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Disabled</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Input Box -->
                    <div class="form-group">
                        <label for="prompt">Prompt:</label>
                        <textarea class="form-control" id="prompt" rows="8"></textarea>
                    </div>

                    <!-- Run Button -->
                    <button id="run" type="button" class="btn btn-primary">Run</button>

                    <!-- Output Box -->
                    <div class="form-group">
                        <label for="outputBox">Output:</label>
                        <!-- <textarea class="form-control" id="outputBox" rows="8" readonly></textarea> -->
                        <div id="outputBox">

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Settings -->
                    <div class="card" style="margin-top: 31px;">
                        <div class="card-header">
                            Settings
                        </div>
                        <div class="card-body">
                            <!-- Language Selector -->
                            <div class="form-group">
                                <label for="inumber">Number of frames:</label>
                                <select class="form-control" id="inumber">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>

                            <!-- Model Selector -->
                            <div class="form-group">
                                <label for="isize">Image size:</label>
                                <select class="form-control" id="isize">
                                    <option value="256x256">256x256</option>
                                    <option value="512x512">512x512</option>
                                    <option value="1024x1024">1024x1024</option>
                                </select>
                            </div>

                            <!-- Parameters -->
                            <div class="form-group">
                                <label for="painter">Painter:</label>
                                <select class="form-control" id="painter">
                                    <optgroup label="Renaissance">
                                        <option value="leonardo-da-vinci">Leonardo da Vinci</option>
                                        <option value="michelangelo">Michelangelo</option>
                                        <option value="raphael">Raphael</option>
                                        <option value="titian">Titian</option>
                                    </optgroup>
                                    <optgroup label="Mannerism">
                                        <option value="el-greco">El Greco</option>
                                        <option value="giuseppe-arcimboldo">Giuseppe Arcimboldo</option>
                                        <option value="jacopo-da-pontormo">Jacopo da Pontormo</option>
                                        <option value="tintoretto">Tintoretto</option>
                                    </optgroup>
                                    <optgroup label="Baroque">
                                        <option value="caravaggio">Caravaggio</option>
                                        <option value="diego-velazquez">Diego Velázquez</option>
                                        <option value="peter-paul-rubens">Peter Paul Rubens</option>
                                        <option value="rembrandt">Rembrandt</option>
                                    </optgroup>
                                    <optgroup label="Rococo">
                                        <option value="francois-boucher">François Boucher</option>
                                        <option value="jean-honore-fragonard">Jean-Honoré Fragonard</option>
                                        <option value="jean-antoine-watteau">Jean-Antoine Watteau</option>
                                        <option value="thomas-gainsborough">Thomas Gainsborough</option>
                                    </optgroup>
                                    <optgroup label="Neoclassicism">
                                        <option value="angelica-kauffman">Angelica Kauffman</option>
                                        <option value="jacques-louis-david">Jacques-Louis David</option>
                                        <option value="antonio-canova">Antonio Canova</option>
                                        <option value="jean-auguste-dominique-ingres">Jean-Auguste-Dominique Ingres</option>
                                    </optgroup>
                                    <optgroup label="Romanticism">
                                        <option value="francisco-de-goya">Francisco de Goya</option>
                                        <option value="eugene-delacroix">Eugène Delacroix</option>
                                        <option value="jmw-turner">J.M.W. Turner</option>
                                        <option value="caspar-david-friedrich">Caspar David Friedrich</option>
                                    </optgroup>
                                    <optgroup label="Realism">
                                        <option value="gustave-courbet">Gustave Courbet</option>
                                        <option value="edouard-manet">Édouard Manet</option>
                                        <option value="jean-francois-millet">Jean-François Millet</option>
                                        <option value="winslow-homer">Winslow Homer</option>
                                    </optgroup>
                                    <optgroup label="Impressionism">
                                        <option value="claude-monet">Claude Monet</option>
                                        <option value="edgar-degas">Edgar Degas</option>
                                        <option value="pierre-auguste-renoir">Pierre-Auguste Renoir</option>
                                        <option value="berthe-morisot">Berthe Morisot</option>
                                    </optgroup>
                                    <optgroup label="Post-Impressionism">
                                        <option value="vincent-van-gogh">Vincent van Gogh</option>
                                        <option value="paul-cezanne">Paul Cézanne</option>
                                        <option value="georges-seurat">Georges Seurat</option>
                                        <option value="henri-rousseau">Henri Rousseau</option>
                                    </optgroup>
                                    <optgroup label="Fauvism">
                                        <option value="henri-matisse">Henri Matisse</option>
                                        <option value="andré-derain">André Derain</option>
                                        <option value="raoul-dufy">Raoul Dufy</option>
                                        <option value="maurice-de-vlaminck">Maurice de Vlaminck</option>
                                    </optgroup>
                                    <optgroup label="Expressionism">
                                        <option value="edvard-munch">Edvard Munch</option>
                                        <option value="ernst-ludwig-kirchner">Ernst Ludwig Kirchner</option>
                                        <option value="franz-marc">Franz Marc</option>
                                        <option value="wassily-kandinsky">Wassily Kandinsky</option>
                                    </optgroup>
                                    <optgroup label="Cubism">
                                        <option value="pablo-picasso">Pablo Picasso</option>
                                        <option value="georges-braque">Georges Braque</option>
                                        <option value="juan-gris">Juan Gris</option>
                                        <option value="robert-delaunay">Robert Delaunay</option>
                                    </optgroup>
                                    <optgroup label="Surrealism">
                                        <option value="salvador-dali">Salvador Dalí</option>
                                        <option value="rene-magritte">René Magritte</option>
                                        <option value="max-ernst">Max Ernst</option>
                                        <option value="joan-miro">Joan Miró</option>
                                    </optgroup>
                                    <optgroup label="Abstract Expressionism">
                                        <option value="jackson-pollock">Jackson Pollock</option>
                                        <option value="mark-rothko">Mark Rothko</option>
                                        <option value="clyfford-still">Clyfford Still</option>
                                        <option value="franz-kline">Franz Kline</option>
                                    </optgroup>
                                    <optgroup label="Pop Art">
                                        <option value="andy-warhol">Andy Warhol</option>
                                        <option value="roy-lichtenstein">Roy Lichtenstein</option>
                                        <option value="james-rosenquist">James Rosenquist</option>
                                        <option value="tom-wesselmann">Tom Wesselmann</option>
                                    </optgroup>
                                    <optgroup label="Contemporary Art">
                                        <option value="jeff-koons">Jeff Koons</option>
                                        <option value="damien-hirst">Damien Hirst</option>
                                        <option value="yayoi-kusama">Yayoi Kusama</option>
                                        <option value="banksy">Banksy</option>
                                    </optgroup>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>Copyright © OpenAI</p>
    </footer>

    <!-- Ajout des fichiers JavaScript de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Ajout du fichier JavaScript personnalisé -->
    <script src="script.js"></script>
    <script>
        $(document).ready(function() {
            // Lorsque le bouton de soumission est cliqué
            $("#run").click(function() {
                // Récupérer les valeurs des champs de formulaire
                var inumber = $("#inumber").val();
                var isize = $("#isize").val();
                var painter = $("#painter").val();
                var prompt = $("#prompt").val();

                // Effectuer la requête POST
                $.post("imagine.php", {
                    inumber: inumber,
                    isize: isize,
                    painter: painter,
                    prompt: prompt
                }, function(jsonData) {
                    // Gérer la réponse de la requête
                    console.log(jsonData);
                    // const data = JSON.parse(jsonData);

                    jsonData.images.forEach((val) => {
                        console.log(val);
                        const imgSrc = val;
                        const imgAlt = "Description de l'image";
                        const img = $("<img>").attr("src", imgSrc).attr("alt", imgAlt);
                        // .addClass("card-img-top");

                        // const card = '<div class="card">'+img+
                        // '<div class="card-body" >'+
                        // '<h5 class="card-title">Titre de la carte</h5>' +
                        // '</div>' +
                        // '</div>';

                        $("#outputBox").append(img);
                    });
                });
            });
        });
    </script>