<?php
echo '    <main >
    <div class="cote"></div>
    <div class=colonne>
        <div class="logo center">
                <img src=".\IMG\oups.png" alt="">
                <h1>Une erreur est survenue</h1>
        </div>
        <div class="err colonne center">
            <div>' .$_SESSION['erreur']['message']  . '</div>
        </div>';
        if (isset($_SESSION['erreur']['detail']))
    echo '    <div class="err colonne center">
            <div>' .$_SESSION['erreur']['detail']  . '</div>
        </div>';
    echo '    <div class="err colonne center mini">
            <div><button type="button">
                <a href=' .$_SESSION['erreur']['redirection'] . '><i class="fas fa-paper-plane"></i></a>
                </button>
            </div>
        </div>
    </div>
    <div class="cote"></div>
    </main>';
