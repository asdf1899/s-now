<?php
  @ob_start();
  session_start();
?>
<!doctype>
<html>
  <head>
  <?php
    include "include/header.html";
    include 'php/functions.php';
    include 'php/get_user_data.php';

    if(!$_SESSION['isLogged'] or $_SESSION['isLogged'] == "" or $_SESSION['email'] == ""){
      session_destroy();
      header("location:php/logout.php");
    }
    // getUserData ritorna un array con tutte le info dell'utente
    $user = getUserData($_SESSION['email'], "php/db_connection.php");
    if ($user['ID'] == null){
      session_destroy();
      header("location:php/logout.php");
    }
    // Controlla se la foto profilo esiste, altrimenti usa quella default
    $_SESSION['fotoProfilo'] = profilePicture($user['Email'], $_SESSION['fotoProfilo']);
    // restituisce le coordinate(Lat e Long) della residenza per la mappa
    $coordResidenza = getCoordinatesFromAddress($user['Residenza']);
   ?>
   <style>
    .mdl-layout__drawer-button{
      color: #2173b9!important;
    }
    .mdl-fab-bottom-right {
      position: fixed;
      bottom: 24px;
    	right: 24px;
    	transition: bottom .25s cubic-bezier(0,0,.2,1);
    }
   </style>
 </head>

  <body class="mdl-color--grey-100">
    <div id="loading-div" class="stile-parent" style="height:100%;background-color:white;z-index:10000">
      <div class="stile-child">
        <img src="img/loading.gif"></img>
      </div>
    </div>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
      <header class="mdl-layout__header mdl-layout__header--transparent mdl-cell--hide-desktop">
        <div class="mdl-layout__header-row">
          <div class="mdl-layout-spacer"></div>
        </div>
      </header>
      <div class="mdl-layout__drawer stile-main-vertical" style="border:none">
        <div style="height:120px;text-align:center;padding:20px;">
          <span class="mdl-layout-title mdl-color-text--white"><b>s-<i>now</i></b></span>
        </div>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="index.html">Home</a>
          <a class="mdl-navigation__link" href="mappa.php">Mappa</a>
          <a class="mdl-navigation__link" href="include/help.html">Serve aiuto?</a>
          <a class="mdl-navigation__link" href="php/logout.php">Esci</a>
        </nav>
      </div>
      <main id="main" class="mdl-layout__content">
        <!-- INFO UTENTE PER DESKTOP-->
        <section id="desktop" class="mdl-cell--hide-phone mdl-cell--hide-tablet">
          <?php
            include "include/dashboard-desktop.php";
           ?>
        </section>
        <!-- INFO UTENTE PER MOBILE-->
        <section id="mobile" class="mdl-cell--hide-desktop">
          <?php
            include "include/dashboard-mobile.php";
           ?>
        </section>

        <section>
          <div class="mdl-grid">
            <div id="mapCard" class="mdl-card mdl-cell mdl-shadow--4dp mdl-color--white stile-card-corners">
               <h2 class="stile-text-azzurro ">
                 Mappa
               </h2>
               <hr class="stile-azzurro" style="width:100px;height:8px;border:5px solid white;border-radius:10px;">
               <div style="text-align:center">
                 <button class="mdl-button mdl-js-button mdl-button--raised mdl-color--orange"
                         style="width:90%;height:35px;color:white;border:none;border-radius:20px;text-align:center;margin-bottom:15px"
                         onclick="location.href='report.php'">
                   Aggiungi segnalazione
                   <i class="material-icons">report_problem</i>
                 </button>
               </div>
               <div id="map" style="width:100%; height:420px;border-radius:20px"></div>

               <?php include "include/maps.php" ?>

             </div>

            <div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--4dp mdl-color--white stile-card-corners ">
              <h2 class="stile-text-azzurro ">
                Chat recenti
              </h2>
               <hr class="stile-azzurro" style="width:100px;height:8px;border:5px solid white;border-radius:10px;">
               <div style="text-align:center">
                 <button class="mdl-button mdl-js-button mdl-button--raised"
                         style="width:90%;height:35px;color:white;background-color:#27ae60;border:none;border-radius:20px;;text-align:center;margin-bottom:15px"
                         onclick="location.href='chat.php?username='">
                   Scrivi a un segnalatore
                   <i class="material-icons">account_circle</i>
                 </button>
                 <button class="mdl-button mdl-js-button mdl-button--raised"
                         style="width:90%;height:35px;color:white;background-color:#27ae60;border:none;border-radius:20px;;text-align:center;margin-bottom:15px;margin-bottom:2xp"
                         onclick="modal.open();">
                   Tutti i messaggi
                   <i class="material-icons">chat</i>
                 </button>
               </div>
               <div id="lastMsg" style="overflow:auto">
                 <?php
                    include "php/get_last_messages.php";
                    getMessages($user, "LIMIT 2");
                 ?>
               </div>
            </div>
          </div>
        </section>

      </main>
    </div>
    <script>
      if(window.innerWidth <= 837){
        jQuery("#mapCard").addClass("mdl-cell--12-col");
      }else{
        jQuery("#mapCard").addClass("mdl-cell--8-col");
      }

      // nasconde il contenuto della pagina per 2 secondi per mostrare il loading
      document.getElementById("main").style.display = "none";
      setTimeout(function(){
        document.getElementById("loading-div").remove();
        document.getElementById("main").style.display = "block";
      }, 2000);


      // modal per la visualizzazione di tutti i messaggi
      var modal = new tingle.modal({
          closeMethods: ['overlay', 'button', 'escape'],
          closeLabel: "Chiudi",
          cssClass: ['custom-class-1', 'custom-class-2'],
          onOpen: function() {
              console.log('modal open');
          },
          onClose: function() {
              console.log('modal closed');
          },
          beforeClose: function() {
              return true; // close the modal
              return false; // nothing happens
          }
      });
      var messages = `<?php getMessages($user, ''); ?>`;
      // set content
      modal.setContent(
        '<h2 class="stile-text-azzurro">Tutti i messaggi<h2>'+
        "<div>"+
        messages +
        "</div>"
      );
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgwoQUpZNuWrgKJseSI53sQvWZAFkBzQ4&callback=initMap" type="text/javascript"></script>
  </body>
</html>
