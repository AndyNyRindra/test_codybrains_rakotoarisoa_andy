<script type="text/javascript">
    //Les codes ci dessous sont executé lors que la page est chargée
    window.addEventListener("load", function () {

        function sendData() {
            var xhr;
            try {  xhr = new ActiveXObject('Msxml2.XMLHTTP');   }
            catch (e)
            {
                try {   xhr = new ActiveXObject('Microsoft.XMLHTTP'); }
                catch (e2)
                {
                    try {  xhr = new XMLHttpRequest();  }
                    catch (e3) {  xhr = false;   }
                }
            }


            // Liez l'objet FormData et l'élément form
            var formData = new FormData(form);

            // Définissez ce qui se passe si la soumission s'est opérée avec succès
            xhr.addEventListener("load", function(event) {
                $msg=(event.target.responseText!="")?event.target.responseText:"OK";
                $msg = JSON.parse($msg);
                if (!$msg["success"]) {
                    console.log($msg["msg"]);
                    alert($msg["msg"]);
                } else {
                    window.location.replace("<?php echo site_url($form_data['redirect']); ?>");
                }

            });

            // Definissez ce qui se passe en cas d'erreur
            xhr.addEventListener("error", function(event) {
                alert('Oups! Quelque chose s\'est mal passé.');
            });

            // Configurez la requête
            xhr.open("POST", "<?php echo site_url($form_data['url']); ?>");

            // Les données envoyées sont ce que l'utilisateur a mis dans le formulaire
            xhr.send(formData);
        }

        // Accédez à l'élément form …
        var form = document.getElementById("<?php echo $form_data['attributes']['id']; ?>");

        // … et prenez en charge l'événement submit.
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // évite de faire le submit par défaut

            sendData();
        });
    });

</script>