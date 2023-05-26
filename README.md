## Test Práctico

## Clonamos el proyecto desde github
git clone https://github.com/DaniHerrera/TestProfe.git

## para levantar el contenedor docker
docker-compose up -d

## Opción 1 (dentro del contenedor)
## entramos dentro del contendor
docker-compose docker exec -it php82-container bash
## ejecutar
php init.php input/entrada.txt output/salida.txt   ##El fichero de datos se encuentra en input/entrada.txt

## Opción 2 (desde fuera del contenedor)
docker exec -it php82-container php init.php input/entrada.txt output/salida.txt

- He dejado como puerto de php el 9005; en caso de tener problemasmodificadlo gracias.

## Entorno ubuntu-debian
## en caso de no tener docker ni docker-compose instalados

https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04
https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-22-04