/**
*	jQuery admin.js
*	Version 1.0.0
*	
*	04/10/2015
*/

if(jQuery) (function($){
	
	$(document).ready(function(){		
		if (document.getElementById('dirSite') !== null){
			var o = document.getElementById('dirSite');
			var repSite = o.getAttribute("data-rep");
			var dosSite = '';
			var isLocal = false;
			
			if (repSite.search('localhost')>0){isLocal = true;} else if(repSite.search('127.0.0.1')>0){isLocal = true;}
// affichage dans la console ==> console.log('Serveur Local : ' + isLocal);

			repSite = repSite.substring(0, repSite.length - 1);
		
			p = repSite.lastIndexOf("/");
			repRacine = repSite.substring(0, p);
			
			o = document.getElementById('dirPlugin');
			var repPlugin = o.getAttribute("data-rep");
			repPlugin = repPlugin.substr(p);		
		
			o = document.getElementById('dirMedia');
			var repMedia = o.getAttribute("data-rep");
			repMedia = repMedia.substr(p);
			
			if (isLocal) {
				repSite = repSite.substr(p) + '/';
			} 
			else {
				n = repSite.indexOf("//");
				dosSite = repSite.substr(n + 1);
				
				repMedia = repMedia.replace(dosSite, '');
				repPlugin = repPlugin.replace(dosSite, '');
				repSite = '/';
			}
		}
		
		
		/*$('.nav-tab').click(function(){
			/*var tabSelect = this;
			var isActif = $(this).hasClass('nav-tab-active');
			var nom = $(this).attr('name');
			console.log(tabSelect);
			console.log('Actif : '+isActif +' Name : '+nom);*/
			
			//$('.nav-tab').toggleClass( 'nav-tab-active' );
		/*	$('#parametre-generaux').removeClass('nav-tab-active');
			$('#parametre-images').addClass('nav-tab-active');
			
		});*/

		
		/*** Nouvelle image ***/
		// Selon le choix de 'emplacement-image' on affiche la sélection d'image à la une ou la possibilité de choisir un fichier 
		$('#emplacement-image').change(function(){
			selected_value = $("input[name='emplacement-image']:checked").val();
			//if(selected_value == 'lien'){jQuery('#lien-image-p').slideDown(); jQuery('#postimagediv').slideUp();} else {jQuery('#lien-image-p').slideUp(); jQuery('#postimagediv').slideDown();};
			if(selected_value == 'lien'){
				//jQuery('#lien-image-p').slideDown(); 
				//jQuery('#postimagediv').slideUp();
			}
			else {
				//jQuery('#lien-image-p').slideUp(); 
				jQuery('#postimagediv').slideDown();}
			;
		});

		// validation du bouton 'Choisissez un fichier'
		/*function renseigneFichier(fichier) {
console.log(fichier);			
			document.getElementById('lien_image').value = fichier[0].pathinfo ;
		}*/
		
		/*** Paramètres ***/
		// Modifie les paramètres affiché selon la case à cocher nommée 'swd_sliders_use_media_settings'
		$('#swd_sliders_use_media_settings').change(function(){
			if(this.checked){
				this.value = 1;
				jQuery('#parametre_swd_sliders').slideUp(); 
				jQuery('#parametre_wp_media').slideDown();
			} else {
				this.value = 0;
				jQuery('#parametre_swd_sliders').slideDown(); 
				jQuery('#parametre_wp_media').slideUp();
			}
		});
		
		// Modifie #labelRacine en fonction de la case d'option sélectionnée dans #emplacement
		$('#emplacement').change(function(){
			racine_select = $("input[name='emplacement']:checked").val();
			
			if (racine_select == 'dossier_plugin'){ 
				racine = 'Plugin';
				o = document.getElementById('dirPlugin');

				// affichage dans la console ==> console.log(repDest);
				$('#dirPlugin').css('display', 'block');
				$('#dirSite').css('display', 'none');
				$('#dirMedia').css('display', 'none');
			} else if (racine_select == 'dossier_site'){ 
				racine = 'Site';
				o = document.getElementById('dirSite');

				$('#dirPlugin').css('display', 'none');
				$('#dirSite').css('display', 'block');
				$('#dirMedia').css('display', 'none');
			} else { 
				racine = 'Media';
				o = document.getElementById('dirMedia');
				
				$('#dirPlugin').css('display', 'none');
				$('#dirSite').css('display', 'none');
				$('#dirMedia').css('display', 'block');
			}
			repDest = o.getAttribute("data-rep");
		
			$('#labelRacine').text(racine);	
			$('#repertoireDestination').text(repDest);
			document.getElementById("labelRacine").setAttribute('value', racine);
			document.getElementById("repertoireDestination").setAttribute('value', repDest);
		});
	
		// Affiche l'arborescence des dossiers pour le chemin définit selon les paramètres : root, onlyFolders, expandSpeed, collapseSpeed, multiFolder
		$('#dirMedia').fileTree({
		   script: repPlugin + 'jqueryFileTree.php',
		   root: repMedia,
		   onlyFolders: true,
		   multiFolder: false,
		   expandSpeed: 250,
		   collapseSpeed: 250
		})
		.on('filetreeexpanded filetreecollapsed', function(e, data) {
			document.getElementById("repertoireDestination").setAttribute('value', repRacine + dosSite + data.rel);
		});
		
		$('#dirSite').fileTree({
		   script: repPlugin + 'jqueryFileTree.php',
		   root: repSite,
		   onlyFolders: true,
		   multiFolder: false,
		   expandSpeed: 250,
		   collapseSpeed: 250
		})
		.on('filetreeexpanded filetreecollapsed', function(e, data) {
			document.getElementById("repertoireDestination").setAttribute('value', repRacine + dosSite + data.rel);
		});
		
		$('#dirPlugin').fileTree({
		   script: repPlugin + 'jqueryFileTree.php',
		   root: repPlugin,
		   onlyFolders: true,
		   multiFolder: false,
		   expandSpeed: 250,
		   collapseSpeed: 250
		})
		.on('filetreeexpanded filetreecollapsed', function(e, data) {
			document.getElementById("repertoireDestination").setAttribute('value', repRacine + dosSite + data.rel);
		});
				
	});
	
})(jQuery);	