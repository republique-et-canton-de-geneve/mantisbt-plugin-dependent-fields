
# Plugin MantisBT – Dependent Fields

## License
License: **Apache V2**

## Purpose
Le but de ce plugin est de permettre, dans le logiciel MantisBT, de définir, pour aider à la construction d’un ticket, un champ de saisie personalisé dont le contenu dépend d’un autre champ de saisie personalisé.

Par exemple je définis un champ « Type d’OS » qui permet de choisir dans une liste entre « UNIX - Linux - Windows - MacOS» et selon la sélection faite par l’utilisateur un autre champs (une autre list box) voit son contenu modifié. Si par exemple on a sélectionné « UNIX » le second champs contiendra par exemple « AIX – HPUX – Solaris », si on a sélectionné « Linux » il contiendra par exemple « Ubuntu - Fedora - RHEL » …

En 2022, il existait bien un plugin MantisBT sensé offrir un comportement similaire à celui souhaité (https://github.com/mantisbt-plugins/LinkedCustomFields), mais il ne fonctionnait pas. 
Ce plugin a alors été développé en « forkant » et en corrigeant le plugin défectueux.

## Requirement et installation
 
### Requirement
- MantisBT version 2.23 ou +

### Installation
- Télécharger le code du plugin.
- Copier le plugin (le répertoire mantisbt-plugin-dependent-fields/) dans le répertoire plugins/ de la version de MantisBT installé.
- En tant qu'administrateur, connectez-vous à MantisBT et choisissez Manage -> Manage Plugins.
- Dans la liste des Plugins disponible, vous trouverez mantisbt-plugin-dependent-fields; cliquez sur le bouton Install.