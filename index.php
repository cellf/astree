<?php
// prendre le pot
include (dirname(__FILE__).'/teipot/Teipot.php');
// mettre le sachet SQLite dans le pot
$pot=new Teipot(dirname(__FILE__).'/astree.sqlite', 'fr');
// est-ce qu’un fichier statique (ex: epub) est attendu pour ce chemin ? 
// Si oui, l’envoyer maintenant depuis la base avant d’avoir écrit la moindre ligne
$pot->file($pot->path);
// Si un document correspond à ce chemin, charger un tableau avec différents composants (body, head, breadcrumb…)
$doc=$pot->doc($pot->path);
$teipot = $pot->basehref() . 'teipot/';
$theme = $pot->basehref() . 'theme/';


?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <?php if (isset($doc['head'])) echo $doc['head']; ?>
    <link rel="favicon" href="<?php echo $theme; ?>favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?php echo $teipot; ?>html.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $teipot; ?>teipot.css" />
  </head>
  <body>
    <header id="header">
      <h1>
        <a href="<?php echo $pot->basehref(); ?>">ASTRÉE, prototype version 2</a>
      </h1>
      <?php // liens de téléchargements
        // if ($doc['downloads']) echo "\n".'<nav id="downloads"><small>Télécharger :</small> '.$doc['downloads'].'</nav>';
      ?>
    </header>
    <div id="center">
      <nav id="toolbar">
        <?php 
        echo '<a href="' . $pot->basehref . '">ASTRÉE</a> » ';
        // nous avons un livre, glisser aussi les liens de téléchargement
        if (isset($doc['breadcrumb'])) echo $doc['breadcrumb']; 
        ?>
      </nav>
      <div id="article">
      <?php
      
if (isset($doc['body'])) {
  echo $doc['body'];
  // page d’accueil d’un livre avec recherche plein texte, afficher une concordance
  if ($pot->q && (!$doc['artname'] || $doc['artname']=='index')) echo $pot->concBook($doc['bookid']);
}
// pas de livre demandé, montrer un rapport général
else {
  // charger des résultats en mémoire
  $pot->search();
  // nombre de résultats
  echo $pot->report();
  // présentation bibliographique des résultats
  echo $pot->biblio(array('date', 'title'));
  echo $pot->chrono();
  // concordance s’il y a recherche plein texte
  echo $pot->concByBook();
}
      ?>
      </div>
      <aside id="aside">
        <p> </p>
          <?php
// livre
if (isset($doc['bookrowid'])) {
  echo "\n<nav>";
  // auteur, titre, date
  if ($doc['byline']) $doc['byline']=$doc['byline'].'<br/>';
  echo "\n".'<header><a href="' . $pot->basehref() . $doc['bookname'] . '/">' . $doc['byline'] . $doc['title'] . ' ('.$doc['end'].')</a></header>';
  // table des matières
  echo $doc['toc'];
  echo "\n</nav>";
}
// accueil ? formulaire de recherche général
else {
  echo'
    <form action="" style="text-align:center">
      <input name="q" placeholder="Rechercher" class="text" value="'.str_replace('"', '&quot;', $pot->q).'"/>
      <button type="submit">Rechercher</button>
    </form>
  ';
}
?>
      </aside>
    </div>
    <footer id="footer">
      Prototype d'application TEI
    </footer>
    <script type="text/javascript" src="<?php echo $teipot; ?>Tree.js">//</script>
    <script type="text/javascript" src="<?php echo $teipot; ?>Sortable.js">//</script>
    <script type="text/javascript"><?php echo $doc['js']; ?></script>  
  </body>
</html>
