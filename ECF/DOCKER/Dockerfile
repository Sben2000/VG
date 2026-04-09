#Specification de la commande de pull image php apache correspondant (à ma version php utilisée)
#=>version disponible via http://localhost/dashboard/phpinfo.php 
FROM php:8.2.12-apache 

#copy de notre dossier (site/) dans l'emplacement containerisé dédiée (/var/www/html)
COPY site/ /var/www/html

#Pour éviter les messages d’erreur apparaissant lors du démarrage de service (du type « ne trouve pas le nom de domaine du serveur spécifié » : could not reliably determine the server’s fully qualified domain name)
RUN echo "serverName localhost" >> /etc/apache2/apache2.conf
#Installation des extensions pdo & pdo_mysql pour permettre l'interactivité des fichiers php avec la dB dans mysql à travers PDO (Voir :https://docs.docker.com/guides/php/develop/)
RUN docker-php-ext-install pdo pdo_mysql
#Nous exposons le port 80
EXPOSE 80

