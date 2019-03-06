# GeradorCracha
Gerador de Crachás para eventos

Requisitos
	*PHP 7.3;
	*PHP-GD;
	*Composer;
	*Servidor;

*PHP 7.3: Para instalar a versão 7.3 do PHP basta rodar os seguintes comandos:

sudo apt install apt-transport-https lsb-release

sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg # Download the signing key

sudo sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' # Add Ondrej's repo to sources list.

sudo apt update

sudo apt install php7.3 php7.3-common php7.3-cli

sudo apt install php7.3-bcmath php7.3-bz2 php7.3-curl php7.3-gd php7.3-intl php7.3-json php7.3-mbstring php7.3-readline php7.3-xml php7.3-zip


*PHP7.0-GD: Para instalar, execute o comando:

sudo apt install php7.3-gd

*Composer:

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

php composer-setup.php

php -r "unlink('composer-setup.php');"

mv composer.phar /usr/local/bin/composer


*Servidor: Qualquer servidor on-line para inserir o projeto, um exemplo de servidor local é o XAMPP que pode ser baixado pelo site:

https://www.apachefriends.org/pt_br/index.html

Inicie o servidor pelo comando:

sudo /opt/lampp/lampp start


------------------------------------------------------------------------------------------------------------------------------------
Iniciar

Uma vez que os requisitos estejam funcionando, basta da git clone nesse projeto e rodar o comando na pasta raiz do projeto:

composer install


Após a instalação, o projeto está pronto, se estiver utilizando um servidor local, pode iniciá-lo com o comando:

php artisan serve




