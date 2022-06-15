<?php
// On redirige l'utilisateur vers l'index du parent
// Pour que personne ne puisse savoir quels sont les fichiers dans includes/
// afin d'éviter des problèmes de sécurité

Header("Location: ../");
?>