# Eve Quantum

L'objectif principale de cette application et de proposer aux utilisateurs un moyen d'obtenir des réponses à leurs questions
à propos du MMORPG Eve Online développer par CCP. eveonline.com

Les utilisateurs seront identifiés via l'authentification du site officiel et n'auront pas besoin de créer un compte sur la plateforme.
Toutefois, ils auront bien une existence dans notre base de donnée.

Sur Eve Quantum les personnages sont identifiés par leur "character owner hash".
Cet identifiant est unique, et permet d'éviter les confusions lorsque qu'un personnage change de compte (possibilité offerte par CCP).

Dans le but d'augmenter l'interactivité entre la plateforme et le jeu, Eve Quantum offre la possibilité aux utilisateurs de recevoir un mail "in-game" lorsqu'ils recoivent une réponse à leur question.
Celà est rendu possible grâce à l'API d'Eve Online.
Les utilisateurs connecté et seulement les utilisateurs connecté peuvent interagir avec leurs propres contenu in-game via cet API.

Les scopes de l'API utilisés par Eve Quantum concerne pour l'instant uniquement l'envoie de mail "in-game".
Ces scopes seront toujours précisés au moment de la connexion.
