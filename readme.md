DATOS DE ESTUDIANTE: (solitario)
Nombres: Reyner David Contreras Rojas.
Programación II sección 02.

La base de datos es el archivo "sistema_boletos.sql" y la usé con colación utf8mb4_spanish_ci

Realizado en PHP 7, utilizando XAMPP para el mismo PHP y para el servidor de pruebas y base de datos.

** Para que un cliente pueda comprar un boleto para un evento es necesario
que ese evento exista y haya sido registrado por un administrador.

** Contraseñas de usuarios cifradas con la misma función de PHP password_hash (hash = BCRYPT)
Ni de lejos es el mejor cifrado pero es mejor que nada.

Para probar ya existe una cuenta de administrador.
CUENTA ADMINISTRADOR:
Usuario: admin
Contraseña: admin1234

De igual forma se puede crear o hacer un nuevo admin desde la base de datos,
AUNQUE es preferible que a un usuario normal se le cambie el valor del rol
para que se convierta en administrador debido a que las contraseñas en la página
web están cifradas.

Para probar ya existe una cuenta de cliente.
CUENTA CLIENTE:
Usuario: usuario
Contraseña: admin1234

Igualmente se pueden registrar más clientes.
