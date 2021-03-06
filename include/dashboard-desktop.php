<section class="stile-image-parallax">
  <div id="info-desktop" class="mdl-grid">
    <br>
    <div class="mdl-grid mdl-card mdl-cell mdl-cell--12-col mdl-cell--middle mdl-shadow--4dp mdl-color--white stile-card-corners">
      <div class="mdl-cell--2-col" style="text-align:center">
        <img src=" <?php echo $_SESSION['fotoProfilo'] ?>"
             style="width:120px;height:120px;border-radius:50%;">
        </img>
       <div style="margin:50px">
         <button id="button-settings" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-color--blue"
                 onclick="location.href='show_user.php'">
           <i class="material-icons">settings</i>
         </button>
         <!--Descrizione del pulsante mostra utente -->
         <div class="mdl-tooltip mdl-tooltip--large" for="button-settings">
           Mostra Utente
         </div>
       </div>
      </div>
      <div class="mdl-cell--1-col"></div>
      <div class="mdl-cell--9-col">
        <h2 class="stile-text-azzurro ">
          Ciao <?php echo $user['Nome'] ?>
        </h2>
         <hr class="stile-azzurro" style="width:100px;height:8px;border:5px solid white;border-radius:10px;">
         <div class="mdl-grid">
           <div class="stile-dashboard-card mdl-cell mdl-cell--4-col mdl-shadow--4dp mdl-color--white">
             <p class="stile-text-azzurro">EMAIL</p>
             <p>
               <?php
                echo $user['Email'];
               ?>
             </p>
           </div>
           <div class="stile-dashboard-card mdl-cell mdl-cell--4-col mdl-shadow--4dp mdl-color--white">
             <p class="stile-text-azzurro">CITTA'</p>
             <p>
               <?php
                echo $user['Residenza'];
               ?>
             </p>
           </div>
           <div class="stile-dashboard-card mdl-cell mdl-cell--4-col mdl-shadow--4dp mdl-color--white">
             <p class="stile-text-azzurro">SEGNALAZIONI EFFETTUATE</p>
             <p>
               <?php
                include "php/get_user_reports.php";
               ?>
             </p>
           </div>
         </div>
      </div>
    </div>
  </div>
</section>
