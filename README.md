# Kidlee Test

Intégration des Systèmes de Paiement Stripe et PayPal dans une Boutique enLigne avec Traits.

## Structure de Solution
La communication dans ce projet est : Controller => Service => Trait.

- Controller => Service : communication par injection de dépendance pour éviter le couplage de code. (il nous facilite l’utilisation des tests unitaires pour tester l'app)
- Service => Trait : le service fait des appelles au traits et utiliser leur methodes.

J’ai utilisé une autre solution, où le contrôleur communique avec deux services et chaque service appelle le trait correspondante.
## Les Classes
- Trait : sont des classes responsables de tous le traitement du paiment "Stripe ou paypal".
- Controller : recevoire les requettes HTTP.
- Service: responsable de la communication entre le contrôle et le trait, pour rendre le code plus lisible et facile à ajouter d’autres fonctions.
- Dto: Data Trasfer Object, pour transformer les données entre les classes et éviter d’écrire plusieurs attributs dans le paramètre d’une méthode.
