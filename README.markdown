# JPR: que faire si dans le guichet, les filtres par mode d'envoi ne fonctionnent plus ?

Toujours dans le cadre du festival JPR, une feature est en place dans le guichet, permettant d'utiliser les questions de formulaire traitées dans la doc précédente.
Il s'agit d'un filtre présent dans la liste des commandes du guichet, uniquement disponible pour les opérateurs des guichets appartenant à O70725 et O94151 (respectivement JPR français et anglais).

Cette feature est très spécifique et implémentée de façon très tordue, plusieurs personnes ayant fait du bricolage dessus, l'objectif étant de répondre au besoin de l'orgaqui est de pouvoir trier ses billets par mode de livraison, et de les imprimer par lots dans le cas d'un envoi postal.
Il est inutile d'expliquer l'intégralité du fonctionnement de cette feature. Pour le moment, ça marche, et on tiendra avec jusqu'à ce qu'on recode un guichet.

![](https://www.lereboot.com:2443/4dcc875e14cde2552696638c326d3927685206c0/687474703a2f2f33312e6d656469612e74756d626c722e636f6d2f33653863373136633166396566373738363130316462623765373433666363362f74756d626c725f696e6c696e655f6e6934756177626b4272317431753767312e676966)

## Mise en place

Losrs de l'ajout d'évènements à l'impression par lots comme indiqué dans la doc précédente. Il se peut que le filtre par mode d'envoi du guichet ne fonctionne plus, lorsqu'on l'utilise.
Pour réparer ça, voici les étapes à suivre (utiliset le guichet dans le navigateur, via l'adresse https://guichet.weezevent.com/) :

- Dans l'onglet "Commandes", cliquer sur le bouton "Filtrer", puis inspecter la liste déroulante nommée "Mode de récupération" ("Delivery mode" en anglais) .

- Repérer ensuite les attributs "value" de chaque balise `<option>`

- Ouvrir ensuite le fichier `api/v2/app/controllers/OrderController.class.php`, puis dans la méthode `getDeliveryParams`, ajouter chaque valeur des attributs `value` en tant que clé du tableau `$p`, puis mettez le wording correspondant en tant que valeur associée à cette clé.

- Vous pouvez tenter de vérifier le fonctionnement sur preprod, mais vu que le serveur est beaucoup plus lent que la prod, et que le nombre de commandes passant dans le filtre est généralement colossal, vous risquez de galérer. Donc au pire, testez en prod, vous ne risquez rien si vous avez suivi ces indications.

## Notes:


- le filtre sur le mode de livraison ne fonctionne pas lorsque le filtre par événement est sur "Tous les événements". Il faut sélectionner un événement particulier pour le voir fonctionner (c'est comme ça ¯\_(ツ)_/¯ )
 
- pour O70725, le guichet doit être configuré en français pour que les filtres par mode de livraison apparaissent. Pour O94151, il devra être configuré en anglais, sinon la liste des filtres par mode de livraison apparaîtra vide

