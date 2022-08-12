# Backbone Systems Challenge

Primero tuve dudas al momento de pensar el ¿cómo iba a utilizar los datos proporcionados? (los que están dentro de los archivos xsl, txt y xml). Pense en exportar el archivo xls o txt hacia la base de datos para luego crear un modelo dentro del proyecto y poder gestionar más fácil la búsqueda de los ZipCodes. Pero una de las cosas que ustedes resaltaban era que el tiempo de respuesta promedio tenía que ser menor a 300ms. Por lo tanto tomé la decisión de no utilizar base de datos y trabajar la búsqueda directamente con el archivo .txt, porque cuando se trabaja con archivos el tiempo de respuesta es más rápido comparandolo con el de una base de datos. Eso no quiere decir que las base de datos no deberían utilizarce, no para nada. Solo tomé esa decisión para hacer la búsqueda más rápida. Por otro lado, para mejorar la velocidad de respuesta, se utilizó la Cache mediante archivos.

## Sobre este proyecto:

### Los archivos creados dentro del proyecto de Laravel fueron los siguientes:

- app/Http/Controllers/Api/ZipCodeController.php: Controlador que contiene el método para recibir las peticiónes

- app/Traits/ZipCodeData.php: Este Trait se creó para tener los métodos que tendrán toda la lógica.

  - El método fillData() recorre el archivo buscando el zip_code correspondiente para agregar los datos al array que se devuelve en formato Json.
  - El método cleanString() permite eliminar los acentos de las cadenas de caracteres que se gestionan mientras se recorre el archivo.
  - El método cache() es el encargado de almacenar en cache el array final y también lo devuelve en dado caso que se envíe un zip_code repetido. Esto con el fin de evitar buscar de nuevo en el archivo si se está solicitando la información de un código encontrado anteriormente.

- routes/api.php: Esto archivo no fue creado ya que viene por defecto en Laravel, pero se usó para agregar la ruta correspondiente.

- tests/Feature/ZipCodeTest.php: Contiene dos tests, una para verificar que se realice la búsqueda correctamente y devuelva la información adecuada. Y otro test encargado de verificar cuando un zip_code no se encuentra dentro del archivo.

## Instalación

### Pasos para instalar este proyecto en tu entorno local

- git clone https://github.com/gamg/backbonetest.git
- composer install

### Para ejecutar todos los Tests:

- php artisan test

### Para ejecutar un test específico:

- php artisan test ./tests/Feature/ZipCodeTest.php
